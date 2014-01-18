<?php
require_once("../../server/bootstrap.php");

class CategoriasUdmTest extends PHPUnit_Framework_TestCase {
    public static $categoria_peso;

	public static function setUpBeforeClass() {
        SesionController::Iniciar(123, 1, true);
        self::$categoria_peso = new CategoriaUnidadMedida(array(
            'descripcion' => 'Peso',
            'activa' => true
        ));
        CategoriaUnidadMedidaDAOBase::save(
            self::$categoria_peso
        );
        CategoriaUnidadMedidaDAOBase::save(
            new CategoriaUnidadMedida(array(
                'descripcion' => 'Tiempo',
                'activa' => false
            ))
        );
        CategoriaUnidadMedidaDAOBase::save(
            new CategoriaUnidadMedida(array(
                'descripcion' => 'Distancia',
                'activa' => true
            ))
        );
        CategoriaUnidadMedidaDAOBase::save(
            new CategoriaUnidadMedida(array(
                'descripcion' => 'Omo',
                'activa' => false
            ))
        );
    }

    // - - Buscar - - //
    public function testBuscarTodos() {
        $this->buscar($activa=null, $query=null, $qty=4);
    }

    public function testBuscarActivos() {
        $this->buscar($activa=true, $query=null, $qty=2);
    }

    public function testBuscarInactivos() {
        $this->buscar($activa=false, $query=null, $qty=2);
    }

    public function testBuscarDescripcionCoincideUna() {
        $this->buscar($activa=null, $query='Peso', $qty=1);
    }

    public function testBuscarDescripcionCoincidenVarias() {
        $this->buscar($activa=null, $query='e', $qty=2);
    }

    public function testBuscarDescripcionNoCoincide() {
        $this->buscar($activa=null, $query='X', $qty=0);
    }

    public function testBuscarActivosCoincideUna() {
        $this->buscar($activa=true, $query='Peso', $qty=1);
    }

    public function testBuscarActivosCoincidenVarias() {
        $this->buscar($activa=true, $query='s', $qty=2);
    }

    public function testBuscarActivosNoCoincide() {
        $this->buscar($activa=true, $query='X', $qty=0);
    }

    public function testBuscarInactivosCoincideUna() {
        $this->buscar($activa=false, $query='Omo', $qty=1);
    }

    public function testBuscarInactivosCoincidenVarias() {
        $this->buscar($activa=false, $query='m', $qty=2);
    }

    public function testBuscarInactivosNoCoincide() {
        $this->buscar($activa=false, $query='X', $qty=0);
    }

    private function buscar($activa, $query, $qty) {
        $resultado = ProductosController::BuscarCategoriaUdm($activa=$activa, $descripcion=$query);
        $this->assertEquals($qty, count($resultado['resultados']));
    }

    // - - Crear - - //
    /**
    * @expectedException InvalidArgumentException
    */
    public function testNuevaDescripcionVacia() {
        ProductosController::NuevaCategoriaUdm('');
    }

    public function testNueva() {
        $resultado = ProductosController::NuevaCategoriaUdm('Nueva');
        $categoria = CategoriaUnidadMedidaDAO::getByPK($resultado['id_categoria_unidad_medida']);
        $this->assertNotNull($categoria);
    }

    /**
    * @expectedException BusinessLogicException
    */
    public function testNuevaDescripcionExisteActiva() {
        ProductosController::NuevaCategoriaUdm('Peso');
    }

    /**
    * @expectedException BusinessLogicException
    */
    public function testNuevaDescripcionExisteInactiva() {
        ProductosController::NuevaCategoriaUdm('Tiempo');
    }

    // - - Mostrar - - //
    public function testDetalles() {
        $categoria = self::$categoria_peso;
        $resultado = ProductosController::DetallesCategoriaUdm($categoria->getIdCategoriaUnidadMedida());
        $this->assertNotNull($resultado['categoria_unidad_medida']);
    }

    /**
    * @expectedException InvalidDatabaseOperationException
    */
    public function testDetallesNoExiste() {
        $resultado = ProductosController::DetallesCategoriaUdm(90);
    }

    // - - Editar - - //
    /**
    * @expectedException InvalidDatabaseOperationException
    */
    public function testEditarNoExiste() {
        ProductosController::EditarCategoriaUdm(90);
    }

    public function testEditarStatus() {
        $categoria = self::$categoria_peso;
        $descripcion = $categoria->getDescripcion();

        $activa = false;
        do {
            ProductosController::EditarCategoriaUdm($categoria->getIdCategoriaUnidadMedida(), $activa);
            $categoria = CategoriaUnidadMedidaDAO::getByPK($categoria->getIdCategoriaUnidadMedida());
            $this->assertEquals($categoria->getActiva(), (int) $activa);
            $this->assertEquals($categoria->getDescripcion(), $descripcion);
            $activa = !$activa;
        } while ($activa);
    }

    public function testEditarDescripcion() {
        $categoria = self::$categoria_peso;
        $status = $categoria->getActiva();

        ProductosController::EditarCategoriaUdm($categoria->getIdCategoriaUnidadMedida(), null, 'Masa');
        $categoria = CategoriaUnidadMedidaDAO::getByPK($categoria->getIdCategoriaUnidadMedida());
        $this->assertEquals($categoria->getDescripcion(), 'Masa');
        $this->assertEquals($categoria->getActiva(), (int) $status);
    }

    public function testEditarTodo() {
        $categoria = self::$categoria_peso;
        ProductosController::EditarCategoriaUdm($categoria->getIdCategoriaUnidadMedida(), false, 'Peso');
        $categoria = CategoriaUnidadMedidaDAO::getByPK($categoria->getIdCategoriaUnidadMedida());
        $this->assertEquals($categoria->getDescripcion(), 'Peso');
        $this->assertEquals($categoria->getActiva(), 0);
    }

    public static function tearDownAfterClass() {
        $categorias = CategoriaUnidadMedidaDAO::getAll();
        foreach ($categorias as $categoria) {
            CategoriaUnidadMedidaDAO::delete($categoria);
        }
    }
}
