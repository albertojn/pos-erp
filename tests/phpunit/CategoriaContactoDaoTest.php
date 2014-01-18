<?php
require_once("../../server/bootstrap.php");

class CategoriaContactoDAOTest extends PHPUnit_Framework_TestCase {
	protected function setUp() {
		SesionController::Iniciar(123, 1, true);
		CategoriaContactoDAO::save(new CategoriaContacto(array(
			'id' => 1,
			'nombre' => 'padre',
			'descripcion' => 'Uno',
			'activa' => 1
		)));
		CategoriaContactoDAO::save(new CategoriaContacto(array(
			'id' => 2,
			'id_padre' => 1,
			'nombre' => 'hijo',
			'descripcion' => 'Dos',
			'activa' => 1
		)));
	}

	public function testHacerCiclo() {
		$padre = CategoriaContactoDAO::getByPK(1);
		$padre->setIdPadre(2);
		$this->guardar($padre);

		$padre = CategoriaContactoDAO::getByPK(1);
		$this->assertNotEquals($padre->getIdPadre(), 2);
	}

	public function testSinCiclo() {
		CategoriaContactoDAO::save(new CategoriaContacto(array(
			'id' => 3,
			'nombre' => 'nuevo_padre',
			'descripcion' => 'Tres',
			'activa' => 1
		)));

		$hijo = CategoriaContactoDAO::getByPK(2);
		$hijo->setIdPadre(3);
		$this->guardar($hijo);

		$hijo = CategoriaContactoDAO::getByPK(2);
		$this->assertEquals($hijo->getIdPadre(), 3);
	}

	private function guardar($categoria) {
		$id = $categoria->getId();
		$id_padre = $categoria->getIdPadre();
		if (CategoriaContactoDAO::ChecarRecursion($id, $id_padre)) {
			CategoriaContactoDAO::save($categoria);
		}
	}

	public function testNombreSinPadres() {
		$categoria = CategoriaContactoDAO::getByPK(1);
		$nombre_completo = CategoriaContactoDAO::NombreCompleto($categoria->getId());
		$this->assertEquals($nombre_completo, 'padre');
	}

	public function testNombreConPadre() {
		$categoria = CategoriaContactoDAO::getByPK(2);
		$nombre_completo = CategoriaContactoDAO::NombreCompleto($categoria->getId());
		$this->assertEquals($nombre_completo, 'padre/hijo');
	}

	protected function tearDown() {
		$categorias = CategoriaContactoDAO::getAll();
		foreach ($categorias as $categoria) {
			CategoriaContactoDAO::delete($categoria);
		}
	}
}