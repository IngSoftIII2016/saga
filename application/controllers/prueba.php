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
		
		$this->load->model('Evento_Model');
		var_dump($this->Evento_Model->aula_disponible_evento(2, '2016-10-03', '08:00', '9:00'));
		//return $this->Evento_Model->agregar_evento($aula, $fecha, $hora_inicio, $hora_fin, $motivo);
		//var_dump($this->Clase_model->aula_disponible(10, '2016-09-25', '15:00', '18:00'));
	}
}