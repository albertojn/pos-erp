<?php
require_once("../../server/bootstrap.php");

class POSControllerTest extends PHPUnit_Framework_TestCase
{
    private $configuracion;

    protected function setUp()
    {
        SesionController::Iniciar(123, 1, true);
        $this->configuracion = new Configuracion(array(
            'descripcion' => 'productos_visibles_en_vc'
        ));
    }

    public function testCrearConfiguracion()
    {
        $count1 = count(ConfiguracionDAO::getAll());
        POSController::ClientesVistasConfiguracion(true);
        $count2 = count(ConfiguracionDAO::getAll());

        $this->assertEquals($count2, $count1 + 1);
    }

    public function testActualizarConfiguracion()
    {
        POSController::ClientesVistasConfiguracion(true);
        $count1 = count(ConfiguracionDAO::getAll());
        POSController::ClientesVistasConfiguracion(false);
        $count2 = count(ConfiguracionDAO::getAll());

        $this->assertEquals($count1, $count2);
    }

    public function testUsuarioActual()
    {
        POSController::ClientesVistasConfiguracion(true);
        $configuraciones = ConfiguracionDAO::search($this->configuracion);

        $configuracion = $configuraciones[0];
        $sesion = SesionController::Actual();

        $this->assertEquals($sesion['id_usuario'], $configuracion->getIdUsuario());
    }

    protected function tearDown()
    {
        $configuraciones = ConfiguracionDAO::search($this->configuracion);
        $configuracion = $configuraciones[0];
        ConfiguracionDAO::delete($configuracion);
    }
}
?>