<?php
namespace Controllers;

use \Core\Controller;
use \Models\Usuarios;

class HomeController extends Controller {

	public function index() {
		
		$array = array(
			'api:' => 'v1.0',
			'nome:' => 'agendamob_api'
		);

		$this->returnJson($array);

	}

	public function testando() {
		echo "FUNCIONOU!";
	}

	public function visualizar_usuarios($id) {
		echo "ID: ".$id;
	}

}