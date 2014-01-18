<?php
require_once("interfaces/Impuestos.interface.php");
/**
  *
  *
  *
  **/
	
  class ImpuestosController implements IImpuestos{

      /**
 	 *
 	 *Crear un nuevo impuesto. Falta revisar bien lo de contabilidad, para saber como se van a ligar los impuestos con las cuentas, pero omitiendo las ligas con las cuentas seria esto.
 	 *
 	 * @param activo bool Determina si el impuesto est� activo, (0) No, (1) Si, Default 1
 	 * @param aplica string Determina el alcance del impuesto, "compra", "venta", "ambos".
 	 * @param codigo string Determina el c�digo asociado al impuesto
 	 * @param importe float Determina el monto(importe) asociado a este impuesto.
Antes: monto_porcentaje;
Para impuestos de tipo porcentaje, introduzca valor % entre 0-1
 	 * @param incluido_precio bool Determina si el impuesto se incluye en el precio, (0) No, (1) Si
 	 * @param nombre string Nombre del impuesto
 	 * @param tipo int El metodo de calculo del importe del impuesto. Porcentaje (0), Importe fijo (1), ninguno (2), saldo pendiente (3)
 	 * @return id_impuesto int Id del impuesto insertado.
 	 **/
         public static function Nuevo
	(
		$activo, 
		$aplica, 
		$codigo, 
		$importe, 
		$incluido_precio, 
		$nombre, 
		$descripcion = null, 
		$tipo = ""
	)
	{  


		$ni = new Impuesto();
		$ni->setImporte( $importe );
		$ni->setNombre( $nombre );
		$ni->setCodigo( $codigo );
		$ni->setIncluidoPrecio( $incluido_precio );
		$ni->setAplica( $aplica );
		$ni->setTipo( $tipo );
		$ni->setNombre( $nombre );
		$ni->setActivo( $activo );
		$ni->setDescripcion( $descripcion );

		try{
			ImpuestoDAO::save($ni);
				
		}catch(Exception $e){
			throw new InvalidDatabaseOperationException($e);
		}

  		Logger::log("Nuevo impuesto..." . $ni->getIdImpuesto() . " creado" );
		return array( "id_impuesto" => $ni->getIdImpuesto() );
	}
	
	/**
	*
	*Edita la informacion de un impuesto
	*
 	 **/
	public static function Editar
	(
		$id_impuesto, 
		$monto_porcentaje = null, 
		$nombre = null, 
		$tipo = null
	)
	{  
  
  
	}
	
	/**
	*
	*Listas los impuestos
	*
 	 * @param query string Valor que se buscara en la consulta
 	 * @return resultados json Lista de impuestos
 	 * @return numero_de_resultados int 
 	 **/
	public static function Lista
	(
		$query = null
	)
	{  
  		$i =ImpuestoDAO::getAll();
		
		return array(
			"resultados" => $i,
			"numero_de_resultados" => sizeof($i)
		);
  
	}
  }
