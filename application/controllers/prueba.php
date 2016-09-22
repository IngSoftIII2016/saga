<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 08/09/16
 * Time: 22:41
 */
class prueba extends CI_Controller {
	
	public function index() {
		$this->load->model('Evento_Model');
		$fecha = new DateTime();
		$clases = $this->Evento_Model->get_eventos_dia($fecha->format("Y-m-d"));
		var_dump($clases);
	}
}