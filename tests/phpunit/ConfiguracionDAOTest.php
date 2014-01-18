<?php

require_once("../../server/bootstrap.php");

class ConfiguracionDAOTest extends PHPUnit_Framework_TestCase
{
    private $configuracion;
    private $registros;
    private $json;

    protected function setUp()
    {
        SesionController::Iniciar(123, 1, true);
        $this->configuracion = new Configuracion(array(
            'descripcion' => 'productos_visibles_en_vc'
        ));
        $this->json = array("nombre_producto", "descripcion");
    }

    private function crearYBuscar()
    {
        ConfiguracionDAO::GuardarConfigDeVC(true, 1, $this->json);
        $this->registros = ConfiguracionDAO::search($this->configuracion);
    }

    public function testCrearSiNoExiste()
    {
        $this->crearYBuscar();
        $this->assertEquals(count($this->registros), 1);
    }

    public function testActualizarSiYaExiste()
    {
        $this->crearYBuscar();
        $conf1 = $this->registros[0];

        ConfiguracionDAO::GuardarConfigDeVC(false, 1, $this->json);
        $this->registros = ConfiguracionDAO::search($this->configuracion);
        $conf2 = $this->registros[0];

        $this->assertEquals(count($this->registros), 1);
        $this->assertNotEquals($conf1->getValor(), $conf2->getValor());
    }

    public function testJsonValido()
    {
        $this->crearYBuscar();
        $configuracion = $this->registros[0];
        $json = $configuracion->getValor();
        $this->assertNotNull(json_decode($json));
    }

    public function testPropiedadesMostrarEnElJson()
    {
        $valor = $this->valor();
        $this->assertObjectHasAttribute('mostrar', $valor);
        $this->assertInternalType('bool', $valor->mostrar);
    }

    public function testNoHayConfiguracion()
    {
        $this->assertFalse(ConfiguracionDAO::MostrarProductos());
    }

    public function testMostrarEsFalse()
    {
        ConfiguracionDAO::GuardarConfigDeVC(false, 1, $this->json);
        $this->assertFalse(ConfiguracionDAO::MostrarProductos());
    }

    /**
    * @expectedException InvalidArgumentException
    */
    public function testCamposInvalidos()
    {
        $json = array("invalido");
        ConfiguracionDAO::GuardarConfigDeVC(true, 1, $json);
    }

    public function testPropiedadPropiedadesEnElJSON()
    {
        $valor = $this->valor();
        $this->assertObjectHasAttribute('propiedades', $valor);
        $this->assertInternalType('array', $valor->propiedades);
    }

    private function valor()
    {
        $this->crearYBuscar();
        $conf = $this->registros[0];
        return json_decode($conf->getValor());
    }

    protected function tearDown()
    {
        $configuraciones = ConfiguracionDAO::search($this->configuracion);
        if (count($configuraciones) > 0)
        {
            ConfiguracionDAO::delete($configuraciones[0]);
        }
    }
}
?>