<?php

require_once ('Estructura.php');
require_once("base/usuario.dao.base.php");
require_once("base/usuario.vo.base.php");
/** Page-level DocBlock .
  * 
  * @author Andres
  * @package docs
  * 
  */
/** Usuario Data Access Object (DAO).
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Usuario }. 
  * @author Andres
  * @access public
  * @package docs
  * 
  */
class UsuarioDAO extends UsuarioDAOBase
{

    /**
      * buscar usuario por usuario y contrasena
      *
      **/
    public static function findUser($user, $password)
    {

      global $conn;

      $sql = "SELECT * FROM usuario WHERE ( (id_usuario = ? OR correo_electronico = ? OR codigo_usuario = ? ) AND password = ? and activo = 1) LIMIT 1;";

      $params = array( $user, $user, $user, md5($password) );

      $rs = $conn->GetRow($sql, $params);

      if(count($rs) === 0)
      {
        return NULL;
      }

      
      return new Usuario($rs);
    }

	public static function buscarEmpleados( $query = null, $how_many = 5000, $activos = 1 ){
		
		if(is_null($query)){
			$sql = "select * from usuario where ( id_rol != 5";
			$sql .= " and id_clasificacion_proveedor IS NULL  ";
			$sql .= " and activo = ? ) ";
			
			
			$val = array();
			array_push($val , $activos);
			
			
		}else{
			$parts = explode(" ", $query);

			$sql = "select * from usuario where (";
			$val = array();
			$first = true;
			foreach ($parts as $p) {
				if($first){
					$first = false;

				}else{
					$sql .= " and ";
				}
				$sql .= "  nombre like ? ";
				array_push($val , "%" . $p . "%");
			}
			$sql .= " and id_rol != 5  ";
			$sql .= " and id_clasificacion_proveedor IS NULL  ";
			$sql .= " and activo = ? ) ";
			array_push($val , $activos);
		}
		

		
	

		global $conn;
		$rs = $conn->Execute($sql, $val);
		$ar = array( );
		foreach ($rs as $foo) {
			$bar =  new Usuario($foo);
    		array_push( $ar,$bar);
		}

		return $ar;
		
	}

	public static function buscarClientes( $query, $how_many = 5000 ){

		$parts = explode(" ", $query);

		$sql = "select usuario.*, direccion.*  from usuario , direccion  where ( (";
		$val = array();
		$first = true;
		foreach ($parts as $p) {
			if($first){
				$first = false;
				
			}else{
				$sql .= " and ";
			}
			$sql .= "  nombre like ? ";
			array_push($val , "%" . $p . "%");
		}

		$sql .= " or telefono_personal1 like ? ";
		array_push($val, $query);

		$sql .= " or telefono_personal2 like ? ";
		array_push($val, $query);

		$sql .= " or rfc like ? ";
		array_push($val, $query);

		$sql .= ") and id_rol = 5  and ( direccion.id_direccion = usuario.id_direccion ) ) ";

		global $conn;
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$rs = $conn->Execute($sql, $val);
		return $rs->GetRows();
	}

	public static function saldoCliente($id_cliente){
		global $conn;
		$limite_credito = UsuarioDAO::getByPK($id_cliente)->getLimiteCredito();
      	$sql = "SELECT SUM(venta.saldo) as saldo FROM venta WHERE venta.id_comprador_venta = {$id_cliente} AND venta.saldo > 0;";      	
		$rs = $conn->GetRow($sql);

		if(count($rs) === 0)
		{
		    return $limite_credito;
		}
		if($rs['saldo']== null)
			return $limite_credito;
			
		return $limite_credito - $rs['saldo'];				
	}
	
	
	
	public static function traerSeguimientos( Usuario $usuario ){
		$id = $usuario->getIdUsuario();
	}
}
