<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 08/09/16
 * Time: 22:41
 */
class prueba extends CI_Controller {
	
	public function index() {
		$this->load->model('Clase_model');
		//$this->Evento_Model->insertar(13, '2016-09-24', '15:00', '18:00', 'motivo');
		$this->load->model('Evento_Model');
		//return $this->Evento_Model->agregar_evento($aula, $fecha, $hora_inicio, $hora_fin, $motivo);
		var_dump($this->Clase_model->aula_disponible(10, '2016-09-25', '15:00', '18:15'));
	}
}