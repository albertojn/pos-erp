<?php

class InstanciasController {

	/**
	 * Nueva($instance_token, $descripcion)
	 *
	 * Crear una nueva instancia(Instalacion de Caffeina POS)
	 *
	 * @author Alan Gonzalez Hernandez<alan@caffeina.mx>, Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 * @param string $instance_token 
	 * @param String $descripcion
	 * @return int(11) $I_ID
	 **/
	public static function Nueva($instance_token = null, $descripcion = null)
	{
		Logger::log("======== NUEVA INSTANCIA =============");

		if (!empty($instance_token)) {
			//quitamos espacios en los extremos y entre palabras
			$instance_token = str_replace(" ", "_", trim($instance_token));

			if (strlen($instance_token) === 0) {
				Logger::warn("se mando crear una nueva instancia con un token vacio, se mandara crear nuevamente con un token aleatorio");
				return self::Nueva(dechex(time()), $descripcion);
			}
		} else {
			return self::Nueva(dechex(time()), $descripcion);
		}

		//primero busquemos ese token
		if (!is_null(self::BuscarPorToken($instance_token))) {
			Logger::error("Instance `$instance_token` ya existe. Abortando `InstanciasController::Nueva()`.");
			return null;
		}

		//buscar que no exista esta instancia
		global $POS_CONFIG;

		//insertar registro en `instances` para que me asigne un id
		$sql = "INSERT INTO  `instances` ( `instance_id` ,`fecha_creacion`,`instance_token` ,`descripcion`  )VALUES ( NULL , " . time() . ",  ?,  ? );";

		try {
			$POS_CONFIG["CORE_CONN"]->Execute($sql, array($instance_token, $descripcion));
			$I_ID = $POS_CONFIG["CORE_CONN"]->Insert_ID();
		} catch (Exception $e) {
			Logger::error($e);
			return null;
		}

		$DB_NAME = strtolower("POS_INSTANCE_" . $I_ID);
		
		//crear la bd
		$sql = "CREATE DATABASE  $DB_NAME DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";

		try {
			$POS_CONFIG["CORE_CONN"]->Execute($sql);
		} catch (Exception $e) {
			Logger::error($e);
			throw $e;
		}

		//generamos el password del usuario
		$pass = md5(str_replace("_", "-", $DB_NAME));

		try {
			$POS_CONFIG["CORE_CONN"]->Execute("CREATE USER ?@'localhost' IDENTIFIED BY  ?;", array($DB_NAME, $pass));
		} catch (Exception $e) {
			Logger::error($e);
			throw $e;
		}

		$sql = "GRANT USAGE ON * . * TO  ?@'localhost' IDENTIFIED BY  ? WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;";

		try {
			$POS_CONFIG["CORE_CONN"]->Execute($sql, array($DB_NAME, $pass));
		} catch (Exception $e) {
			Logger::error($e);
			throw $e;
		}

		$HOST = $POS_CONFIG['CORE_DB_HOST'];

		$sql = "GRANT ALL PRIVILEGES ON  `$DB_NAME` . * TO  '$DB_NAME'@'$HOST';";

		try {
			$POS_CONFIG["CORE_CONN"]->Execute($sql);
		} catch (Exception $e) {
			Logger::error($e);
			throw $e;
		}

		//conectarse a la nueva bd
		$i_conn = null;

		try {
			$i_conn = ADONewConnection($POS_CONFIG["CORE_DB_DRIVER"]);
			$i_conn->debug = false;            
			$i_conn->PConnect($POS_CONFIG["CORE_DB_HOST"], $DB_NAME, $pass, $DB_NAME);

			if (!$i_conn) {
				Logger::error("Imposible conectarme a la base de datos de la instancia recien creada.");
				return null;
			}
		} catch (ADODB_Exception $ado_e) {
			Logger::error($ado_e);
			return null;
		} catch (Exception $e) {
			Logger::error($e);
			return null;
		}

		//llenar los datos
		$instalation_script = file_get_contents(POS_PATH_TO_SERVER_ROOT . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "private" . DIRECTORY_SEPARATOR . "pos_instance.sql");
		$queries = explode(";", $instalation_script);
		try {
			for ($i = 0; $i < sizeof($queries); $i++) {
				if (strlen(trim($queries[$i])) == 0){
					continue;
				}
				$i_conn->Execute($queries[$i] . ";");
			}
		} catch (ADODB_Exception $e) {
			Logger::error($e->msg);
			return null;
		}

		//llenar los datos
		$instalation_script = file_get_contents(POS_PATH_TO_SERVER_ROOT . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "private" . DIRECTORY_SEPARATOR . "pos_instance_foundation.sql");

		$queries = explode(";", $instalation_script);

		try {            
			for ($i = 0; $i < sizeof($queries); $i++) {
				if (strlen(trim($queries[$i])) == 0) {
					continue;
				}
				$i_conn->Execute($queries[$i] . ";");
			}
		} catch (ADODB_Exception $e) {
			Logger::error($e->msg);
			return null;
		}

		$sql = "UPDATE  `instances` SET
			   `db_user`        =  ?,
			   `db_password`    =  ?,
			   `db_name`        =  ?,
			   `db_driver`      =  ?,
			   `db_host`        =  ? WHERE  `instances`.`instance_id` = ?;";

		try {
			$POS_CONFIG["CORE_CONN"]->Execute($sql, array($DB_NAME, $pass, $DB_NAME, $POS_CONFIG["CORE_DB_DRIVER"], $POS_CONFIG["CORE_DB_HOST"], $I_ID));
		} catch (ADODB_Exception $e) {
			Logger::error($e->msg);
			return null;
		}

		//verificamos si hay un request relacionado con esta instancia y actualizamos el id de la instancia
		$sql = "UPDATE instance_request SET instance_id = ? WHERE token = ?";

		try {
			$POS_CONFIG["CORE_CONN"]->GetRow($sql, array($I_ID, $instance_token));
		} catch (ADODB_Exception $e) {
			Logger::error($e->msg);
			return null;
		}

		//creamos la estructura de carpetas necesaria para cada instancia
		{
			//verificamos los permisos de la carpeta statuc_content
			if (is_writable(POS_PATH_TO_SERVER_ROOT . "/../static_content")) {
				$path = POS_PATH_TO_SERVER_ROOT . "/../static_content/" . $I_ID;

				if (!is_dir($path)) {
					mkdir($path);
					chmod($path, 0777);
					mkdir($path . "/plantillas");
					chmod($path . "/plantillas", 0777);
					mkdir($path . "/plantillas/excel");
					chmod($path . "/plantillas/excel", 0777);
				}
			} else {
				Logger::error("Verifique los permisos de escritura de la carpeta static_content");
			}
		}

		Logger::log("Instancia $I_ID creada correctamente... ");

		return (int) $I_ID;
	}

	public static function BuscarPorId($I_ID) {
		global $POS_CONFIG;

		$sql = "select * from instances where instance_id = ?;";
		try {
			$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql, array($I_ID));
		} catch (ADODB_Exception $ado_e) {
			Logger::error($ado_e);
			return null;
		} catch (Exception $e) {
			Logger::error($e);
			return null;
		}


		if (empty($res))
			return NULL;

		return $res;
	}

	/**
	 * BuscarPorToken($instance_token)
	 *
	 * Verifica si hay una instancia registrada en la Base de Datos con el mismo token especificado.
	 *
	 * @author Alan Gonzalez Hernandez<alan@caffeina.mx>
	 * @param string $instance_token 
	 * @return array $res
	 **/
	public static function BuscarPorToken($instance_token = null)
	{
		global $POS_CONFIG;
		$sql = "select * from instances where instance_token = ?";
		$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql, array($instance_token));

		if (empty($res)) {
			return NULL;
		}

		return $res;
	}

	/**
	 * Buscar($instance_token, $descripcion)
	 *
	 * Lista todas las instancias registradas, pero si se prefiere puede regresar una lista de Instancias 
	 * que cumplan con las especificaciones indicadas en <i>$query</i>, ademas se puede manejar paginaci&oacute;n
	 * haciendo uso de los parametros <i>$star y $limit</i>.
	 *
	 * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 * @param boolean $activa true para mostrar solo las instancias activas, false se mostraran las inactivas, NULL muestra todas.
	 * @param int $start Indica desde que registro se desea obtener a partir del conjunto de resultados productos de la búsqueda.
	 * @param int $limit Indica hasta que registro se desea obtener a partir del conjunto de resultados productos de la busqueda.
	 * @param string $query Valor que se buscará en la consulta, en caso de ser NULL, traera todos los registros, de lo contrario buscará coincidencias con la descripcion de query.
	 * @param string $order_by Indica por que campo se ordenan los resultados.
	 * @param string $order Indica si se ordenan los registros de manera Ascendente ASC, o descendente DESC.
	 * @return array con objetos que contien las especificaciones de las instancias encontradas.
	 **/
	public static function Buscar($activa = NULL, $query = NULL, $order_by = NULL, $order = NULL, $start = NULL, $limit = NULL)
	{
		global $POS_CONFIG;

		if ($activa !== NULL && is_bool($activa) === false) {
			Logger::error("Buscar() verifique el valor especificado en activa, se esperaba boolean, se encontro : (" . gettype($activa) . ") {$activa}");
			return null;
		}

		if ($order !== NULL && !($order === "ASC" || $order === "DESC")) {
			Logger::error("Buscar() verifique el valor especificado en order, se esperaba ASC || DESC, se encontro : (" . gettype($order) . ") {$order}");
			return null;
		}

		if ($order_by === NULL) {
			$order_by = "instance_id";
		}

		if ($limit !== NULL && !(is_numeric($limit) && $limit >= 0)) {
			Logger::error("Buscar() verifique el valor especificado en limit, se esperaba un int >= 0, se encontro : (" . gettype($limit) . ") {$limit}");
			return null;
		}

		if ($start !== NULL && !(is_numeric($start) && $start >= 0)) {
			Logger::error("Buscar() verifique el valor especificado en start, se esperaba un int >= 0, se encontro : (" . gettype($start) . ") {$start}");
			return null;
		}

		if ($start !== NULL && $limit === NULL) {
			Logger::error("Buscar() esta especificando un valor de start, pero no especifica un limit, solo el valor limit se puede usar sin start.");
			return null;
		}

		if (!($start === NULL && $limit === NULL) && ($start > $limit)) {
			Logger::error("Buscar() el valor de start debe ser <= que el valor de limit, se encontro start = {$start}, limit = {$limit}");
			return null;
		}

		$sql = "SELECT * FROM instances "
			 . ($activa !== NULL || $query !== NULL ? "WHERE " . ($activa !== NULL ? "activa = " . (int) $activa . " " . ($query !== NULL ? "AND " : "") : "") . ($query !== NULL ? " descripcion LIKE '%{$query}%' OR instance_token LIKE '%{$query}%' " : "") : "")
			 . "ORDER BY {$order_by} {$order} "
			 . ($limit === NULL ? "" : ($start !== NULL ? " LIMIT {$start}, {$limit}" : "LIMIT {$limit}"));

		$res = $POS_CONFIG["CORE_CONN"]->GetAssoc($sql, false, false, false);

		if (empty($res)){
			return NULL;
		}

		$a = array();

		foreach ($res as $v) {

			$sql = "SHOW DATABASES LIKE 'pos_instance_" . $v['instance_id'] . "'";
			$r = $POS_CONFIG["CORE_CONN"]->GetRow($sql);

			if (!empty($r)) {
				$v["pos_instance"] = "1";
			} else {
				$v["pos_instance"] = "0";
			}

			array_push($a, $v);
		}

		//verificamos que exista una instalacion de pos_instance 

		return $a;
	}

	/**
	 * Detalles($instance_id)
	 *
	 * Regresa un arreglo asociativo que contiene informacion sobre una instancia en especifico.
	 *
	 * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 * @param int instance_id identificador de la instancia que vamos a consultar
	 * @return array instance arreglo asociativo que contiene informacion sobre la instancia
	 **/
	public static function Detalles($instance_id) 
	{
		global $POS_CONFIG;

		if (!is_numeric($instance_id)) {
			Logger::error("Detalles() el valor de instance_id debe ser numerico, se encontro (" . gettype($instance_id) . ") {$instance_id}");
			return null;
		}

		$sql = "select * from instances where instance_id = ?;";

		try {
			$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql, array($instance_id));
		} catch (ADODB_Exception $ado_e) {
			Logger::error($ado_e);
			return null;
		} catch (Exception $e) {
			Logger::error($e);
			return null;
		}

		if (empty($res)){
			return NULL;
		}

		$sql = "select * from instance_request where instance_id = ?;";

		try {
			$request = $POS_CONFIG["CORE_CONN"]->GetRow($sql, array($instance_id));
		} catch (ADODB_Exception $ado_e) {
			Logger::error($ado_e);
			return null;
		} catch (Exception $e) {
			Logger::error($e);
			return null;
		}

		$res['request'] = $request;

		//varificamos si tiene una instalacion de pos_instance
		$sql = "SHOW DATABASES LIKE 'pos_instance_" . $instance_id . "'";
		$r = $POS_CONFIG["CORE_CONN"]->GetRow($sql);

		if (!empty($r)) {
			$res["pos_instance"] = "1";
		} else {
			$res["pos_instance"] = "0";
		}

		return $res;
	}

	public static function BuscarRespaldos($IDinstancia = null) {
		//Función que regresa en forma de arreglo todos los elementos en la carpeta de respaldo con un ID de instancia determinado (opcional)  CON SU FECHA COMO INDICE
		$CarpetaRespaldos = (POS_PATH_TO_SERVER_ROOT . "/../static_content/db_backups/");
		$Directorio = dir($CarpetaRespaldos);
		$Retorno = array();
		$Contador = 0; //Cuenta cuantos elementos válidos ha encontrado
		while ($Archivo = $Directorio->read()) {
			if (strlen($Archivo) > 2 && (substr($Archivo, strlen($Archivo) - 4, 4) == ".sql")) {
				if (is_null($IDinstancia)) {//Si no se especifico el indice de la instancia
					array_push($Retorno, array("fecha" => fileatime($CarpetaRespaldos . $Archivo))); //Se manda un arreglo al arreglo de retorno
					$Contador++;
				} else { //Si se especifico el indice de la instancia
					if (substr($Archivo, 24, 2) == $IDinstancia) {
						array_push($Retorno, array("fecha" => fileatime($CarpetaRespaldos . $Archivo))); //Se manda un arreglo al arreglo de retorno
						$Contador++;
					}
				}
			}
		}
		if ($Contador > 0) {//Si encuentra más de un archivo válido en la caperta de respaldos
			return $Retorno;
		}
	}

	
	public static function BuscarRespaldosComponents($IDinstancia) {//Función que devuelve el componente necesario en HTML para crear el formulario con las opciones de respaldos en base a los archivos
		//TODO:Este metodo debera de recibir por fuerza un Id de una instancia                
		$CarpetaRespaldos = (POS_PATH_TO_SERVER_ROOT . "/../static_content/db_backups/");
		$Directorio = dir($CarpetaRespaldos);
		$Retorno=array();
		$Contador = 1; //Cuenta cuantos elementos válidos ha encontrado
		while ($Archivo = $Directorio->read()) {
			if (strlen($Archivo) > 2 && (substr($Archivo, strlen($Archivo) - 4, 4) == ".sql")) {
				$TArchivo = substr($Archivo, 0,10);//filemtime($CarpetaRespaldos . $Archivo);
				if (!is_null($IDinstancia)) {
					if (substr($Archivo, 24, 2) == $IDinstancia) 
						{
						  array_push($Retorno, $TArchivo); //Ingresa los elementos en el array                      
						}
				}
				else
				{
					  return null;//Si no se especifica el ID de la instancia, Regresa NULL
				}
			}
		}

		if ($Contador > 0) {//Si encuentra más de un archivo válido en la caperta de respaldos
			return $Retorno;
		}
		else
		{
			  return array(null);//No se encontraron ficheros validos
		}
	}

	public static function BuscarRequests($id = null) {

		global $POS_CONFIG;

		$vals = false;

		if (is_null($id)) {
			$sql = "select * from instance_request order by fecha desc";
		} else {
			$sql = "select * from instance_request where id_request = ?";
			$vals = array($id);
		}


		$res = $POS_CONFIG["CORE_CONN"]->GetAssoc($sql, $vals, false, false);

		if (empty($res))
			return NULL;

		$a = array();

		foreach ($res as $v) {
			array_push($a, $v);
		}

		return $a;
	}

	public static function Respaldar_Instancias($instance_ids) {

		$ids_string = " WHERE instance_id = ";

		//$ids = json_decode($instance_ids);
		$ids = $instance_ids;
		for ($i = 0; $i < count($ids); $i++) {

			if ($i == 0)
				$ids_string .= "" . $ids[$i];
			else
				$ids_string .= " OR instance_id = " . $ids[$i];
		}

		Logger::log("Backing up Instances.....");

		$result = "";
		$out = "";
		$destiny_file = str_replace("server", "static_content/db_backups", POS_PATH_TO_SERVER_ROOT);

		if (is_writable($destiny_file) !== true) {
			Logger::log("Verifique que tenga los permisos necesarios para la carpeta de respaldos (0775)");
			throw new AccessDeniedException ("Verifique que tenga los permisos necesarios para la carpeta de respaldos (0775)");
		}

		global $POS_CONFIG;

		$sql = "SELECT * FROM instances $ids_string;";
		$rs = $POS_CONFIG["CORE_CONN"]->Execute($sql);

		$instancias = $rs->GetArray();

		foreach ($instancias as $ins) {
			$file_name = time() . '_pos_instance_' . $ins['instance_id'] . '.sql';
			$db_user = $ins['db_user'];
			$usr_pass = $ins['db_password'];
			$db_host = $ins['db_host'];
			$db_name = $ins['db_name'];
			$out = self::backup_pos_instance($ins['instance_id'], $db_host, $db_user, $db_name, $usr_pass, $destiny_file, $file_name);

			if (!is_null($out))
				$result.= $out . "\n";
		}

		if (strlen($result) > 0)
			return $result;
		else
			return null;
	}

	public static function Restaurar_Instancias($instance_ids) {

		$ids_string = " WHERE instance_id = ";

		//$ids = json_decode($instance_ids);
		$ids = $instance_ids;

		for ($i = 0; $i < count($ids); $i++) {

			if ($i == 0)
				$ids_string .= "" . $ids[$i];
			else
				$ids_string .= " OR instance_id = " . $ids[$i];
		}

		Logger::log("Restoring up Instances.....");

		$result = "";
		$out = "";
		$final_path = str_replace("server", "static_content/db_backups", POS_PATH_TO_SERVER_ROOT);

		global $POS_CONFIG;

		$sql = "SELECT * FROM instances $ids_string;";


		$rs = $POS_CONFIG["CORE_CONN"]->Execute($sql);
		$instancias = $rs->GetArray();

		foreach ($instancias as $ins) {
			$file_name = 'pos_instance_' . $ins['instance_id'] . '_' . date("d-m-Y H:i:s") . '.sql';
			$db_user = $ins['db_user'];
			$usr_pass = $ins['db_password'];
			$db_host = $ins['db_host'];
			$db_name = $ins['db_name'];

			$dbs_instance = trim(shell_exec("ls -lat -m1 " . $final_path . "| grep " . $ins['instance_id'] . ".sql"));
			Logger::log("Respaldos encontrados: " . $dbs_instance);

			/* dbs_instance almacena una cadena con un listado donde se encuentran archivos que tengan la teminacion
			  con el id de la instancia y .sql, ademas de que la lista viene ordenada de mas reciente a antiguo
			  la lista seria como lo siguiente:
			  1353617611_pos_instance_82.sql 1353608687_pos_instance_82.sql 1353608206_pos_instance_82.sql 1353608191_pos_instance_82.sql
			  en found se coloca un array y en cada posicion el nombre de cada respaldo
			 */
			$found = preg_split("/[\s,]+/", $dbs_instance, -1, PREG_SPLIT_NO_EMPTY);
			//Logger::log("No archivos: ".count($found));
			if (count($found) < 1) {
				Logger::log("Error al restaurar la instancia " . $ins['instance_id'] . ", no hay un respaldo existente");
				$result .= "Error al restaurar la instancia " . $ins['instance_id'] . ", no hay un respaldo existente";
				continue;
			}

			//se genera una nueva conexion a la bd schema para sacar el no_registros de cada bd
			$instance_con["INSTANCE_CONN"] = null;

			try {

				$instance_con["INSTANCE_CONN"] = ADONewConnection($ins["db_driver"]);
				$instance_con["INSTANCE_CONN"]->debug = $ins["db_debug"];
				$instance_con["INSTANCE_CONN"]->PConnect($db_host, $db_user, $usr_pass, "information_schema");

				if (!$instance_con["INSTANCE_CONN"]) {
					Logger::error("Imposible conectarme a la base de datos information_schema");
					die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
				}
			} catch (ADODB_Exception $ado_e) {

				Logger::error($ado_e);
				die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
			} catch (Exception $e) {
				Logger::error($e);
				die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
			}

			if ($instance_con["INSTANCE_CONN"] === NULL) {
				Logger::error("Imposible conectarse con la base de datos information_schema");
				die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
			}

			$instance_db_con = $instance_con["INSTANCE_CONN"];

			//fin con
			//antes de eliminar las tablas y restaurar se revisa cuantos registros hay en toda la BD
			$num_regs_db = 0;

			$no_rows = $instance_db_con->Execute('SELECT SUM( TABLE_ROWS ) FROM  `TABLES` WHERE TABLE_SCHEMA = "' . $db_name . '"');
			while ($row = $no_rows->FetchRow()) {//row = nombre de la tabla
				$num_regs_db += $row[0];
			}


			//se eliminan las tablas				
			self::Eliminar_Tablas_BD($ins['instance_id'], $db_host, $db_user, $usr_pass, $db_name);
			//se restaura el ultimo respaldo
			$out2 = self::restore_pos_instance($ins['instance_id'], $db_host, $db_user, $db_name, $usr_pass, $final_path . "/" . $found[0], $ins['db_driver'], $ins['db_debug']);
			Logger::warn("No registros en la BD ANTES de eliminar tablas: " . $num_regs_db);
			if (!is_null($out2))
				$result.= $out2 . "\n";
		}//fin foreach que recorre las instancias

		if (strlen($result) > 0)
			return $result;
		else
			return null;
	}

	public static function Actualizar_Todas_Instancias($instance_ids) {

		$ids_string = " WHERE instance_id = ";

		//$ids = json_decode($instance_ids);
		$ids = $instance_ids;

		for ($i = 0; $i < count($ids); $i++) {

			if ($i == 0)
				$ids_string .= "" . $ids[$i];
			else
				$ids_string .= " OR instance_id = " . $ids[$i];
		}

		$result = "";
		$out = "";
		$file_name_cons = 'db-backup-' . time() . '.sql';
		$destiny_file = str_replace("server", "static_content/db_backups", POS_PATH_TO_SERVER_ROOT);

		global $POS_CONFIG;

		$sql = "SELECT * FROM instances $ids_string;";


		$rs = $POS_CONFIG["CORE_CONN"]->Execute($sql);
		$instancias = $rs->GetArray();

		foreach ($instancias as $ins) {
			$file_name = 'instance_' . $ins['instance_id'] . '-' . $file_name_cons;
			$out = self::backup_only_data($ins['instance_id'], $ins['db_host'], $ins['db_user'], $ins['db_password'], $ins['db_name'], $tables = '*', $backup_values = true, $return_as_string = false, $destiny_file, $file_name);
			if (!is_null($out)) {
				$result.= $out . "\n";
				continue; //ya no seguir con el proceso
			}

			$out = self::Eliminar_Tablas_BD($ins['instance_id'], $ins['db_host'], $ins['db_user'], $ins['db_password'], $ins['db_name']);

			if (!is_null($out))
				$result.= $out . "\n";

			$out = self::Insertar_Estructura_Tablas_A_BD($ins['instance_id'], $ins['db_host'], $ins['db_user'], $ins['db_password'], $ins['db_name']);

			if (!is_null($out))
				$result.= $out . "\n";

			$out = self::Insertar_Datos_Desde_Respaldo($ins['instance_id'], $ins['db_host'], $ins['db_user'], $ins['db_password'], $ins['db_name'], $destiny_file . $file_name);

			if (!is_null($out))
				$result.= $out . "\n";
		}

		if (strlen($result) > 0)
			return $result;
		else
			return null;
	}

	public static function Eliminar_Tablas_BD($instance_id, $host, $user, $pass, $name) {
		//conexion a la instancia
		$sql = "SELECT * FROM instances WHERE ( instance_id = {$instance_id} ) LIMIT 1;";

		global $POS_CONFIG;
		$rs = $POS_CONFIG["CORE_CONN"]->GetRow($sql);


		if (count($rs) === 0) {
			Logger::warn("La instancia con el id {" . $instance_id . "} no exite !");
			die(header("HTTP/1.1 404 NOT FOUND"));
		}
		$instance_con["INSTANCE_CONN"] = null;

		try {

			$instance_con["INSTANCE_CONN"] = ADONewConnection($rs["db_driver"]);
			$instance_con["INSTANCE_CONN"]->debug = $rs["db_debug"];
			$instance_con["INSTANCE_CONN"]->PConnect($host, $user, $pass, $name);

			if (!$instance_con["INSTANCE_CONN"]) {

				Logger::error("Imposible conectarme a la base de datos de la instancia {$instance_id}.");
				die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
			}
		} catch (ADODB_Exception $ado_e) {

			Logger::error($ado_e);
			die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
		} catch (Exception $e) {
			Logger::error($e);
			die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
		}

		if ($instance_con["INSTANCE_CONN"] === NULL) {
			Logger::error("Imposible conectarse con la base de datos de la instancia {$instance_id}");
			die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
		}

		$instance_db_con = $instance_con["INSTANCE_CONN"];
		//fin con

		$instance_db_con->Execute("SET foreign_key_checks = 0"); //deshabilitar llave foraneas

		$tables = array();
		$result = $instance_db_con->Execute('SHOW TABLES');

		//se eliminan las tablas
		while ($row = $result->FetchRow()) {//row = nombre de la tabla
			$rss = $instance_db_con->Execute("DROP TABLE IF EXISTS {$name}." . $row[0] . " CASCADE;");
		}

		Logger::log("Exito al eliminar las tablas");

		return null;
	}

	public static function Insertar_Estructura_Tablas_A_BD($instance_id, $host, $user, $pass, $name) {
		$out = "";
		//conexion a la instancia
		$sql = "SELECT * FROM instances WHERE ( instance_id = {$instance_id} ) LIMIT 1;";

		global $POS_CONFIG;
		$rs = $POS_CONFIG["CORE_CONN"]->GetRow($sql);

		if (count($rs) === 0) {
			Logger::error("La instancia con el id {" . $instance_id . "} no exite !");
			die(header("HTTP/1.1 404 NOT FOUND"));
		}

		$instance_con["INSTANCE_CONN"] = null;

		try {

			$instance_con["INSTANCE_CONN"] = ADONewConnection($rs["db_driver"]);
			$instance_con["INSTANCE_CONN"]->debug = $rs["db_debug"];
			$instance_con["INSTANCE_CONN"]->PConnect($host, $user, $pass, $name);

			if (!$instance_con["INSTANCE_CONN"]) {

				Logger::error("Imposible conectarme a la base de datos de la instancia {$instance_id}.");
				die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
			}
		} catch (ADODB_Exception $ado_e) {

			Logger::error($ado_e);
			die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
		} catch (Exception $e) {
			Logger::error($e);
			die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
		}

		if ($instance_con["INSTANCE_CONN"] === NULL) {
			Logger::error("Imposible conectarse con la base de datos de la instancia {$instance_id}");
			die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
		}

		$instance_db_con = $instance_con["INSTANCE_CONN"];
		//fin con

		//insertar tablas
		$instalation_script = file_get_contents(POS_PATH_TO_SERVER_ROOT . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "private" . DIRECTORY_SEPARATOR . "pos_instance.sql");
		$queries = explode(";", $instalation_script);
		try {

			for ($i = 0; $i < sizeof($queries); $i++) {
				if (strlen(trim($queries[$i])) == 0)
					continue;
				$rs = $instance_db_con->Execute($queries[$i] . ";");
				if ($rs)
					;
				else {
					Logger::error("Error al ejecuar la consulta: {$queries[i]}");
					$out.= "Error al ejecutar la consulta: {$queries[i]}" . "\n";
				}
			}
		} catch (ADODB_Exception $e) {
			Logger::error($e->msg);
			return $e->msg;
		}

		if (strlen($out) > 0)
			return $out;

		return null;
	}

	public static function Insertar_Datos_Desde_Respaldo($instance_id, $host, $user, $pass, $name, $source_file) {

		$out = "";
		//conexion a la instancia
		$sql = "SELECT * FROM instances WHERE ( instance_id = {$instance_id} ) LIMIT 1;";

		global $POS_CONFIG;
		$rs = $POS_CONFIG["CORE_CONN"]->GetRow($sql);

		if (count($rs) === 0) {
			Logger::warn("La instancia con el id {" . $instance_id . "} no exite !");
			die(header("HTTP/1.1 404 NOT FOUND"));
		}

		$instance_con["INSTANCE_CONN"] = null;

		try {

			$instance_con["INSTANCE_CONN"] = ADONewConnection($rs["db_driver"]);
			$instance_con["INSTANCE_CONN"]->debug = $rs["db_debug"];
			$instance_con["INSTANCE_CONN"]->PConnect($host, $user, $pass, $name);

			if (!$instance_con["INSTANCE_CONN"]) {

				Logger::error("Imposible conectarme a la base de datos de la instancia {$instance_id}.");
				die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
			}
		} catch (ADODB_Exception $ado_e) {

			Logger::error($ado_e);
			die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
		} catch (Exception $e) {
			Logger::error($e);
			die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
		}

		if ($instance_con["INSTANCE_CONN"] === NULL) {
			Logger::error("Imposible conectarse con la base de datos de la instancia {$instance_id}");
			die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
		}

		$instance_db_con = $instance_con["INSTANCE_CONN"];
		//fin con
		//llenar los datos respaldados
		$data_script = file_get_contents($source_file);
		$queries = explode(";\n", $data_script);
		try {

			for ($i = 0; $i < sizeof($queries); $i++) {
				if (strlen(trim($queries[$i])) == 0)
					continue;
				$rs = $instance_db_con->Execute($queries[$i] . ";");
				if ($rs)
					;
				else {
					Logger::error("Consulta: {$queries[$i]} ; Error! ");
					$out.= "Consulta: {$queries[$i]} ; Error! " . "\n";
				}
			}
		} catch (ADODB_Exception $e) {
			Logger::error($e->msg);
			return $e->msg;
		}

		if (strlen($out) > 0)
			return $out;

		return null;
	}

	public static function backup_pos_instance($instance_id, $db_host, $db_user, $db_name, $usr_pass, $destiny_file, $file_name) {
		Logger::log("Backing up Instance $instance_id");
		$cmd = "mysqldump --opt --host=" . $db_host . " --user=" . $db_user . " --password=" . $usr_pass . " " . $db_name . " > " . $destiny_file . "/" . $file_name;
		$res = shell_exec($cmd);

		return (!file_exists($destiny_file . "/" . $file_name) ) ? "Error al respaldar la instancia " . $instance_id . " comando ejecutado: " . $cmd : NULL;
	}

	public static function restore_pos_instance($instance_id, $db_host, $db_user, $db_name, $usr_pass, $full_path, $driver, $debug) {
		$cmd = "mysql --host=" . $db_host . " --user=" . $db_user . " --password=" . $usr_pass . " " . $db_name . " < " . $full_path;

		$res = shell_exec($cmd);

		//se redefinie la conexion ¬¬
		$instance_con["INSTANCE_CONN"] = null;

		try {

			$instance_con["INSTANCE_CONN"] = ADONewConnection($driver);
			$instance_con["INSTANCE_CONN"]->debug = $debug;
			$instance_con["INSTANCE_CONN"]->PConnect($db_host, $db_user, $usr_pass, "information_schema");

			if (!$instance_con["INSTANCE_CONN"]) {
				Logger::error("Imposible conectarme a la base de datos information_schema");
				die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
			}
		} catch (ADODB_Exception $ado_e) {

			Logger::error($ado_e);
			die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
		} catch (Exception $e) {
			Logger::error($e);
			die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
		}

		if ($instance_con["INSTANCE_CONN"] === NULL) {
			Logger::error("Imposible conectarse con la base de datos information_schema");
			die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
		}

		$instance_db_con = $instance_con["INSTANCE_CONN"];
		$num_regs_db_despues = 0;
		//fin redefine conexion
		$no_rows = $instance_db_con->Execute('SELECT SUM( TABLE_ROWS ) FROM  `TABLES` WHERE TABLE_SCHEMA = "' . $db_name . '"');
		while ($row = $no_rows->FetchRow()) {//row = nombre de la tabla
			$num_regs_db_despues += $row[0];
		}

		return ( $num_regs_db_despues == 0) ? "Error al restaurar la instancia " . $instance_id . "Archivo: " . $full_path: NULL;
	}
  
	public static function backup_only_data($instance_id, $host, $user, $pass, $name, $tables = '*', $backup_values = true, $return_as_string = false, $destiny_file, $file_name) {

		//conexion a la instancia
		$sql = "SELECT * FROM instances WHERE ( instance_id = {$instance_id} ) LIMIT 1;";

		global $POS_CONFIG;
		$rs = $POS_CONFIG["CORE_CONN"]->GetRow($sql);

		if (count($rs) === 0) {
			Logger::error("La instancia con el id {" . $instance_id . "} no exite !");
			die(header("HTTP/1.1 404 NOT FOUND"));
		}
		$instance_con["INSTANCE_CONN"] = null;

		try {

			$instance_con["INSTANCE_CONN"] = ADONewConnection($rs["db_driver"]);
			$instance_con["INSTANCE_CONN"]->debug = $rs["db_debug"];
			$instance_con["INSTANCE_CONN"]->PConnect($host, $user, $pass, $name);

			if (!$instance_con["INSTANCE_CONN"]) {

				Logger::error("Imposible conectarme a la base de datos de la instancia {$instance_id}.");
				die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
			}
		} catch (ADODB_Exception $ado_e) {

			Logger::error($ado_e);
			die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
		} catch (Exception $e) {
			Logger::error($e);
			die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
		}

		if ($instance_con["INSTANCE_CONN"] === NULL) {
			Logger::error("Imposible conectarse con la base de datos de la instancia {$instance_id}");
			die(header("HTTP/1.1 500 INTERNAL SERVER ERROR"));
		}

		$instance_db_con = $instance_con["INSTANCE_CONN"];
		//fin con
		//get all of the tables
		if ($tables == '*') {
			$tables = array();
			//$result = mysql_query('SHOW TABLES');
			$sql = "SHOW TABLES";
			$ress = $instance_db_con->Execute($sql);
			while ($row = $ress->FetchRow())
				$tables[] = $row[0];
		} else {
			$tables = is_array($tables) ? $tables : explode(',', $tables);
		}

		$return = "";

		//cycle through
		foreach ($tables as $table) {
			$sql2 = 'SELECT * FROM ' . $table;
			$result = $instance_db_con->Execute($sql2);
			$num_fields = $result->FieldCount();

			$sql3 = 'SHOW COLUMNS FROM ' . $table;
			$cols = $instance_db_con->Execute($sql3);
			$cols_str = " (";
			while ($rw = $cols->FetchRow())
				$cols_str .= "`" . $rw[0] . "`, ";

			$cols2 = $instance_db_con->GetArray($sql3);

			$cols_str = substr($cols_str, 0, -2);
			$cols_str .= " ) ";
			$cmd = "";
			if ($backup_values) {
				for ($i = 0; $i < $num_fields; $i++) {
					while ($row = $result->FetchRow()) {
						$cmd .= 'INSERT INTO ' . $table . $cols_str . ' VALUES(';
						for ($j = 0; $j < $num_fields; $j++) {
							$row[$j] = addslashes($row[$j]);
							$row[$j] = @ereg_replace("\n", "\\n", $row[$j]);
							$value = $row[$j];

							if (strlen(trim($value)) > 0) {
								$cmd.= '"' . $row[$j] . '"';
							} else {
								$null_column = $cols2[$j]['Field'];
								if ($j == ($num_fields - 1))//es el ultimo campo
									$cmd = str_replace(", `" . $null_column . "` ", '', $cmd); //no se concatena ya que se hace la susuticion y se devuelve la cadena entera
								else
									$cmd = str_replace("`" . $null_column . "`, ", '', $cmd); //no se concatena ya que se hace la susuticion y se devuelve la cadena entera
							}

							if ($j < ($num_fields - 1)) {
								if (strlen(trim($value)) > 0)
									$cmd.= ',';
							}
						}
						$cmd.= ");\n";
						$cmd = str_replace(',)', ')', $cmd); //no se concatena ya que se hace la susuticion y se devuelve la cadena entera
						$return .= $cmd;
						$cmd = "";
					}
				}
			}

			$return.="\n";
		}

		if ($return_as_string)
			return $return;

		$fname = $destiny_file . $file_name;
		try {
			$handle = fopen($fname, 'w+');
			fwrite($handle, $return);
			fclose($handle);
		} catch (Exception $e) {
			Logger::error($e->getMessage());
			return $e->getMessage();
		}

		return null; //cuando regresa null todo bien
	}

//fin back_up tables

	public static function formatfilesize($data) {
		// bytes
		if ($data < 1024) {
			return $data . " bytes";
		}

		// kilobytes
		else if ($data < 1024000) {
			return round(( $data / 1024), 1) . "k";
		}

		// megabytes
		else {
			return round(( $data / 1024000), 1) . " MB";
		}
	}

	/**
	 * requesDemo($userEmail)
	 *
	 * Crear una nueva instancia(Instalacion de Caffeina POS) con vigencia de 30 dias
	 *
	 * @author Alan Gonzalez Hernandez<alan@caffeina.mx>, Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 * @param string userEmail email del usuario que solicita la instalacion de una instancia demo
	 * @return object response response->success indica si termino con exito o fracaso (boolean), response->error en caso de que exista algun error aqui se indica la informaci&oacute;n
	 **/
	public static function requestDemo($userEmail) 
	{
		global $POS_CONFIG;

		Logger::log("Somebody requested trial instance");

		$response = array();

		//busquemos si ese email es valido
		$userEmail = str_replace('&#95;', '_', $userEmail);

		if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
			$response["success"]= false;
			$response["error"] = "email invalido, verifique su informaci&oacute;n";
			Logger::error($response["error"]);
			return $response;
		}

		//busquemos ese email en la bd
		$sql = "select id_request from instance_request where email = ? ";
		$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql, array($userEmail));

		if (!empty($res)) {
			//ya solicito la instancia
			$response["success"] = false;
			$response["error"] = "Lo sentimos, usted ya ha solicitado una instancia previamente";
			Logger::warn($response["error"]);
			return $response;
		}

		//generemos el token a enviar
		$time = time();

		$token = md5($time . "caffeinaSoftware");

		Logger::log("token will be " . $token);

		//insertemos nuevo request
		$sql = "INSERT INTO `instance_request` (`id_request`, `email`, `fecha`, `ip`, `token`) VALUES ( NULL, ?, ?, ?, ?);";

		$res = $POS_CONFIG["CORE_CONN"]->Execute($sql, array($userEmail, $time, $_SERVER["REMOTE_ADDR"], $token));

		$cuerpo = "Bienvenido a su cuenta de POS ERP\n\n"
				. "Por favor siga el siguiente enlace para continuar con su inscripcion:"
				. "\n\nhttp://pos2.labs2.caffeina.mx/?t=by_email&key=" . $token;

		//enviar el correo electronico
		POSController::EnviarMail($cuerpo, $userEmail, "Bienvenido a POS ERP");

		$response["success"] = true;

		return $response;
	}

	/**
	 * validateDemo($token)
	 *
	 * Crear una nueva instancia(Instalacion de Caffeina POS) con vigencia de 30 dias
	 *
	 * @author Alan Gonzalez Hernandez<alan@caffeina.mx>, Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 * @param string token token de la supuesta instancia que validaremos
	 * @return array arreglo sociativo que contiene informacion sobre la respeusta response->success indica si termino con exito o fracaso (boolean), response->reason en caso de que exista algun error aqui se indica la informaci&oacute;n
	 **/
	public static function validateDemo($token) 
	{
		global $POS_CONFIG;

		Logger::log("Somebody requested validate: token: " . $token);

		//busquemos ese token en la bd
		$sql = "select id_request, date_validated, email from instance_request where token = ? ";

		$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql, array($token));

		if (empty($res)) {
			//ya solicito la instancia
			Logger::error("Este token no existe !");
			return array("success" => false, "reason" => "No existe esta llave de solicitud.");
		}

		if (!is_null($res["date_validated"])) {
			Logger::warn("este ya fue validado");
			return array("success" => false, "reason" => "Esta llave de solicitud ya ha sido creada. Para acceder a ella haga click <a href=\"http://pos2.labs2.caffeina.mx/front_ends/" . $token . "/\">aqui</a>.");
		}

		$startTime = time();

		$iid = self::Nueva($token, $res["email"] . " requested this instance as a demo");

		Logger::log("Sending email....");

		$cuerpo = "Su nueva instancia de POS ERP ha sido creada con exito !\n\n";
		$cuerpo .= "Puede acceder a su cuenta en la siguiente direccion:";
		$cuerpo .= "\n\nhttp://pos2.labs2.caffeina.mx/front_ends/" . $token . "/";
		$cuerpo .= "\n\nHemos creado una cuenta de aministrador para usted, el usuario es: `1` y su contraseña es `123` sin las comillas.";

		//enviar el correo electronico
		POSController::EnviarMail($cuerpo, $res["email"], "Su cuenta POS ERP esta lista");

		$sql = "UPDATE  `instance_request`  SET  `date_validated` =  ?, `date_installed` = ?  WHERE `id_request` = ?;";
		$POS_CONFIG["CORE_CONN"]->Execute($sql, array($startTime, time(), $res["id_request"]));

		Logger::log("Done with installation.");

		return array("success" => true, "reason" => "Su instancia se ha creado con exito.");
	}

	/**
	 * Editar($intance_id, $activa, $descripcion, $token)
	 *
	 * Permite la edicion de ciertos valores de la instancia como son el token, la descripcion y su activaci&oacute;n y desactivaci&oacute;n.
	 *
	 * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 * @param string instance_id id de la instancia que vamos a modificar
	 * @param string activa bandera para especificar si la instancia esta activa o inactiva
	 * @param string descripcion nueva descripcion
	 * @param string token nuevo valor del token
	 * @return string cadena en formato de json que contiene  sociativo que contiene informacion sobre la respuesta response->success indica si termino con exito o fracaso (boolean), response->reason en caso de que exista algun error aqui se indica la informaci&oacute;n
	 **/
	public static function Editar($intance_id = NULL, $activa = NULL, $descripcion = NULL, $token = NULL, $status)
	{
		global $POS_CONFIG;

		//validaciones de recepcion de parametros
		{
			//verificamos que al menos tenga un valor para editar
			if($activa === NULL && $descripcion === NULL && $token === NULL && $status = NULL){
				Logger::warn("debe de especifical al menos un valor para editar");
				return json_encode(array("success"=>"false", "reason"=>"debe de especifical al menos un valor para editar"));
			}

			//verificamos al existencia de la instancia
			$instance = self::BuscarPorId($intance_id);

			if (empty($instance)) {
				Logger::error("La instancia que desea modificar no existe!!");
				return json_encode(array("success"=>"false", "reason"=>"La instancia que desea modificar no existe!!"));
			}
		}

		//verificamos si la instancia esta desactivada, en caso de estarlo solo la podemos activar
		if ($instance["activa"] === "0") {
			if ($activa === "1") {
				//antes de activarla verificamos que exista una instalacion de pos_instance
				$sql = "SHOW DATABASES LIKE 'pos_instance_{$intance_id}'";
				$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql);

				if (empty($res)) {
					Logger::error("Error, no se puede reactivar la instancia ya que la instalacion de pos_instance ha sido eliminada");
					return json_encode(array("success"=>"false", "reason"=>"Error, no se puede reactivar la instancia ya que la instalacion de pos_instance ha sido eliminada"));
				}

				//activamos al instancia
				$sql = "UPDATE instances SET activa = ? where instance_id = ? ";
				$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql, array($activa, $intance_id));

				if (!empty($res)) {
					Logger::error("Error al reactivar la instancia");
					return json_encode(array("success"=>"false", "reason"=>"Error al reactivar la instancia"));
				}
				//la instancia se reactivo correctamente (quitar este return si se desea modificar otros parametros)
				return json_encode(array("success"=>"true"));
			}else{
				//la instancia esta desactivada y no se piensa reactivar :s
				return json_encode(array("success"=>"false", "reason"=>"La instancia esta desactivada, no puede modificar ningun valor hasta no ser activada"));
			}
		}

		if(!empty($status) && ($status === "prueba" || $status === "renta" || $status === "prospecto" || $status === "moroso")) {
			//actualizamos la descripcion
			$sql = "UPDATE instances SET status = ? WHERE instance_id = ?";
			$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql, array($status, $intance_id));

			if (!empty($res)) {
				Logger::error("Error al modificar el status");
				return json_encode(array("success"=>"false", "reason"=>"Error al modificar el status"));
			}
		}

		if(!empty($descripcion)) {
			//actualizamos la descripcion
			$sql = "UPDATE instances SET descripcion = ? WHERE instance_id = ?";
			$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql, array($descripcion, $intance_id));

			if (!empty($res)) {
				Logger::error("Error al modificar la descripcion");
				return json_encode(array("success"=>"false", "reason"=>"Error al modificar la descripcion"));
			}
		}

		//busquemos si ese token ya existe
		{
			$sql = "SELECT * FROM instances WHERE instance_token = ? AND instance_id NOT IN ( ? )";
			$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql, array($token, $intance_id));

			if (!empty($res)) {
				Logger::error("Error al modificar el token, otra instancia ya cuenta con ese token");
				return json_encode(array("success"=>"false", "reason"=>"Error al modificar el token, otra instancia ya cuenta con ese token"));
			}
		}

		if(!empty($token)) {

			//quitamos espacios en blanco del token y verificamos su longitud, minimo 5 caracteres
			$token = trim($token);

			if (strlen($token) < 5) {
				Logger::error("Error al modificar el token, el tamaño de la cadena debe de ser de al menos 5 caracteres alfanuméricos");
				return json_encode(array("success"=>"false", "reason"=>"Error al modificar el token, el tamaño de la cadena debe de ser de al menos 5 caracteres alfanuméricos"));
			}

			//actualizamos la descripcion
			$sql = "UPDATE instances SET instance_token = ? WHERE instance_id = ?";
			$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql, array($token, $intance_id));

			if (!empty($res)) {
				Logger::error("Error al modificar el token");
				return json_encode(array("success"=>"false", "reason"=>"Error al modificar el token"));
			}

			//buscamos si esta instancia se creo a partir de un instance_request, de ser asi modificamos el registro
			$sql = "SELECT * FROM instance_request WHERE instance_id = ?";
			$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql, array($intance_id));

			if (!empty($res)) {
				//si hay un request relacionado
				$sql = "UPDATE instance_request SET token = ? WHERE instance_id = ?";
				$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql, array($token,$intance_id));

				if (!empty($res)) {
					Logger::error("Error al modificar el token del request");
					return json_encode(array("success"=>"false", "reason"=>"Error al modificar el token del request"));
				}
			}
		}

		if($activa === "0") {
			//actualizamos la descripcion
			$sql = "UPDATE instances SET activa = ? WHERE instance_id = ?";
			$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql, array($activa, $intance_id));

			if (!empty($res)) {
				Logger::error("Error al desactivar la instancia");
				return json_encode(array("success"=>"false", "reason"=>"Error al desactivar la instancia"));
			}
		}

		return json_encode(array("success"=>"true"));
	}

	/**
	 * Eliminar($intance_id)
	 *
	 * Permite la eliminacion de la instalacion de la bd pos_instance
	 *
	 * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 * @param string instance_id id de la instancia que vamos a modificar
	 * @return string cadena en formato de json que contiene informacion sobre la respuesta response->success indica si termino con exito o fracaso (boolean), response->reason en caso de que exista algun error aqui se indica la informaci&oacute;n
	 **/
	public static function Eliminar($instance_id = NULL)
	{
		global $POS_CONFIG;

		if($instance_id === NULL){
			Logger::error("Error, debe especificar el id de una instancia a eliminar");
			throw new InvalidDataException ("Error, debe especificar el id de una instancia a eliminar");
		}

		$db_name = "pos_instance_" . $instance_id;

		//antes de activarla verificamos que exista una instalacion de pos_instance
		{
			$sql = "SHOW DATABASES LIKE '$db_name'";
			$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql);

			if (empty($res)) {
				Logger::error("No se puede eliminar la BD pos_instance asociada ya que la instalacion ha previamente sido eliminada o no se ha realizado ninguna instalaci&oacute;n");
				throw new InvalidDatabaseOperationException ("Error, no se puede eliminar la BD pos_instance asociada ya que la instalacion ha previamente sido eliminada o no se ha realizado ninguna instalaci&oacute;n");
			}
		}

		//Eliminamos el usuario de la BD
		{
			$sql = "REVOKE ALL ON $db_name . * FROM $db_name@localhost";
			try{
				$POS_CONFIG["CORE_CONN"]->GetRow($sql);
			}catch(Exception $e){
				Logger::warn("Error al eliminar los permisos del usuario pos_instance_{$instance_id} de la BD");				
			}

			$sql = "DROP USER $db_name@localhost";
			try{
				$POS_CONFIG["CORE_CONN"]->GetRow($sql);
			}catch(Exception $e){
				Logger::warn("Error al eliminar el usuario pos_instance_{$instance_id} de la BD");
			}
		}

		//Eliminamos la BD pos_instance
		{
			$sql = "DROP DATABASE $db_name";
			try{
				$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql);
			}catch(Exception $e){
				Logger::error("Error al eliminar la base de datos pos_instance_{$instance_id}");
				throw new InvalidDatabaseOperationException ("Error al eliminar la base de datos pos_instance_{$instance_id}");
			}
		}

		//eliminamos la instancia
		{
			//actualizamos la descripcion
			$sql = "DELETE FROM instances WHERE instance_id = ?";
			$res = $POS_CONFIG["CORE_CONN"]->GetRow($sql, array($instance_id));

			if (!empty($res)) {
				Logger::error("Error al desactivar la instancia");
				throw new InvalidDatabaseOperationException ("Error al desactivar la instancia");
			}
		}

		//verificamos si hay un request relacionado con esta instancia y actualizamos el id de la instancia
		$sql = "UPDATE instance_request SET instance_id = ? WHERE instance_id = ?";

		try {
			Logger::log("Actualizando tabla instance_request para elimnar relaciones con instances");
			$POS_CONFIG["CORE_CONN"]->GetRow($sql, array(NULL, $instance_id));
		} catch (ADODB_Exception $e) {
			Logger::warn($e->msg);
		}

		Logger::log("Se ha elimiando correctamente la instancia {$instance_id}");
	}

	/**
	 * desactivarInstanciasPrueba()
	 *
	 * Permite la desactivacion de las instancias que ya estan fuera de los 30 dias de prueba y pone las instancias en status "prospecto"
	 *
	 * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 *
	 **/
	public static function desactivarInstanciasPrueba()
	{
		global $POS_CONFIG;
		
		//actualizamos la descripcion
		$sql = "UPDATE instances SET activa = '0', status = 'prospecto' "
			 . "WHERE status = 'prueba' AND instance_id IN "
			 . "("
			 . "    SELECT instance_id FROM instance_request "
			 . "    WHERE ( date_installed  + ( 30 * 24 * 60 * 60 )  ) >= UNIX_TIMESTAMP( NOW( ) ) AND instance_id <> 'NULL' "
			 . ")";

		try{
			$POS_CONFIG["CORE_CONN"]->GetRow($sql);
		} catch (ADODB_Exception $e) {
			Logger::error("Error en desactivarInstanciasPrueba : " . $e->msg);
		}
	}

}