<?php

require_once ('Estructura.php');
require_once("base/extra_params_valores.dao.base.php");
require_once("base/extra_params_valores.vo.base.php");
/** Page-level DocBlock .
  * 
  * @author Anonymous
  * @package docs
  * 
  */
/** ExtraParamsValores Data Access Object (DAO).
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link ExtraParamsValores }. 
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */
class ExtraParamsValoresDAO extends ExtraParamsValoresDAOBase
{



	public static function setVals($tabla, $extra_params, $fk_id) {

		$es = new ExtraParamsEstructura(array("tabla" => $tabla));

		$extraParamsEstruct = ExtraParamsEstructuraDAO::search( $es );

		if (sizeof($extraParamsEstruct) == 0) {
			return false;
		}

		if (is_array($extra_params)) {
			$extra_params = (object)$extra_params;
		}

		if (is_null($extra_params)) {
			$extra_params = new StdClass;
		}

		for ($nc=0; $nc < sizeof($extraParamsEstruct); $nc++) {

			$campo = $extraParamsEstruct[$nc]->getCampo();

			if ( property_exists($extra_params, $campo)) {
				// Extra param se envio
				$v = ExtraParamsValoresDAO::search(
									new ExtraParamsValores(
										array(
											"id_extra_params_estructura" => $extraParamsEstruct[$nc]->getIdExtraParamsEstructura(),
											"id_pk_tabla"=>$fk_id
										)));

				if (sizeof($v) == 1) {
					$v = $v[0];
					$v->setVal( $extra_params->$campo );
				} else {
					$v = new ExtraParamsValores();
					$v->setVal($extra_params->$campo);
					$v->setIdPkTabla($fk_id);
					$v->setIdExtraParamsEstructura($extraParamsEstruct[$nc]->getIdExtraParamsEstructura());
				}

			} else {
				// Extra params existe pero no se envio
				$v = new ExtraParamsValores();
				$v->setVal(NULL);
				$v->setIdPkTabla($fk_id);
				$v->setIdExtraParamsEstructura($extraParamsEstruct[$nc]->getIdExtraParamsEstructura());
			}

			try{
				ExtraParamsValoresDAO::save( $v );
			} catch(Exception $e) {
				throw $e;
			}
		}
	}

	public static function getVals($tabla, $id_pk_tabla) {
		global $conn;
		$sql = "select
					epe.campo,
					epe.tipo,
					epe.enum,
					epe.longitud,
					epe.obligatorio,
					epe.caption, 
					epe.descripcion,
					epv.val
				from 
					extra_params_valores epv,
					extra_params_estructura epe
				where
					epv.id_pk_tabla = ?
					and epv.id_extra_params_estructura in (select id_extra_params_estructura from extra_params_estructura where tabla = ?)
					and epv.id_extra_params_estructura = epe.id_extra_params_estructura;";

		$val = array($id_pk_tabla, $tabla);
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$rs = $conn->Execute($sql, $val);
		return $rs->GetRows();
	}

	/*
	 *
	 * Cuando nuevos parametros extra se crean,
	 * los registros para usuarios anterirores deben
	 * actualizarse para contener los nuevos parametros extra.
	 *
	 * */
	public static function actualizarRegistros($tabla) {
		$estructura = ExtraParamsEstructuraDAO::search(new ExtraParamsEstructura(array( "tabla" => $tabla )));

		$usuarios = UsuarioDAO::getAll();

		for ($i = 0; $i < sizeof($usuarios); $i++ ) {
			$valores = self::getVals($tabla, $usuarios[$i]->getIdUsuario());

			for ($e = 0 ; $e < sizeof($estructura); $e++) {

				$found = false;
				for ($v = 0 ; $v < sizeof($valores); $v++) {
					if ($valores[$v]["campo"] == $estructura[$e]->getCampo()) {
						$found = true;
					}
				}

				if (!$found) {
					$toInsert = new ExtraParamsValores();
					$toInsert->setIdExtraParamsEstructura($estructura[$e]->getIdExtraParamsEstructura());
					$toInsert->setIdPkTabla($usuarios[$i]->getIdUsuario());
					$toInsert->setVal(null);

					ExtraParamsValoresDAO::save($toInsert);
				}
			}
		}
	
	}
}
