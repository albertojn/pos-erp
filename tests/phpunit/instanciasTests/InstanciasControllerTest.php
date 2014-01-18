<?php

	require_once("../../server/bootstrap.php");

	if (!defined("BYPASS_INSTANCE_CHECK")) {
		define("BYPASS_INSTANCE_CHECK", true);
	}

class InstanciasControllerTest extends PHPUnit_Framework_TestCase {

	private $id_instancia;
	private $token;

	public function testNuevaInstancia() {
		global $id_instancia;
		$id_instancia = InstanciasController::Nueva(null, "Instacia para unit testing" );
		$this->assertInternalType('int', $id_instancia);
	}

	public function testBuscarInstanciaID() {
		global $id_instancia, $token;

		$instancia = InstanciasController::BuscarPorId($id_instancia);
		$response = is_array($instancia);

		$this->assertTrue($response);

		if ($response == true) {
			$token = $instancia["instance_token"];
		} else {
			$token = INSTANCE_TOKEN;
		}
	}

	public function testBuscarInstanciaToken() {
		global $token;
		$this->assertTrue(is_array(InstanciasController::BuscarPorToken($token)));
	}

	public function testEliminarInstancia() {
		global $id_instancia;
		$this->assertNull(InstanciasController::Eliminar($id_instancia));
		$this->assertNull(InstanciasController::BuscarPorId($id_instancia));
	}

	public function testComprobarPermisos() {
		$this->assertTrue(is_writable(POS_PATH_TO_SERVER_ROOT . "/../static_content/db_backups/"));
	}

	public function testRespaldarBD() {
		$numero_respaldos_original = count(glob(POS_PATH_TO_SERVER_ROOT . "/../static_content/db_backups/{*}",GLOB_BRACE));
		$this->assertNull(InstanciasController::Respaldar_Instancias(array(IID)));
		$numero_respaldos_modificado = count(glob(POS_PATH_TO_SERVER_ROOT . "/../static_content/db_backups/{*}",GLOB_BRACE));
		$this->assertGreaterThan($numero_respaldos_original, $numero_respaldos_modificado);
	}

	public function testRestarurarBD() {
		$this->assertNull(InstanciasController::Restaurar_Instancias(array(IID)));
	}

	public function testComprobarArchivos() {
		$CarpetaRespaldos = (POS_PATH_TO_SERVER_ROOT . "/../static_content/db_backups/");
		$nArchivos = 0;
		$directorio = dir($CarpetaRespaldos);
		$d1 = date("d",time());
		//Dia Actual
		$d2 = null;
		$m1 = date("m",time());
		//Mes actual
		$m2 = null;
		$a1 = date("y",time());
		//Año actual
		$a2 = null;

		while ($archivo = $directorio->read()) {
			//Cada nombre de archivo debe medir 30 caracteres
			if (strlen($archivo)>2) {
				$d2 = date("d",fileatime($CarpetaRespaldos.$archivo));
				$m2 = date("m",fileatime($CarpetaRespaldos.$archivo));
				$a2 = date("y",fileatime($CarpetaRespaldos.$archivo));
				if ((substr($archivo, 10,14) == "_pos_instance_") && (substr($archivo, strlen($archivo)-4,4) == ".sql")) {
					$nArchivos++;
				}

				if ($d1>($d2+7) || $m1 > $m2 || $a1 > $a2 && ((substr($archivo, 10,14) == "_pos_instance_") && (substr($archivo, strlen($archivo)-3,3) == "sql"))) {
					//Comprueba que se borró correctamente el archivo viejo
					$this->assertTrue(unlink($CarpetaRespaldos.$archivo));
				}
			}
		}
		$directorio->close();
	}
}