<?php
class GrillaController extends CI_Controller {
	
	function index() {
		//$this->load->model("Clase_Model");
		//echo $this->math_model->get_clases();
		for($i = 1; $i <= 14; $i ++) {
			if($i%2==0){
			$datos ['aulas'] [$i] = array (
					'materia' => 'Teoria de la comunicación',
					'profesor' => 'Rodriguez Marino Paula',
					'horario' => array (15,18,15,6) 
			);
			} else {
				$datos ['aulas'] [$i] = array (
						'materia' => 'Teoria de la comunicación',
						'profesor' => 'Rodriguez Marino Paula',
						'horario' => array (15,17,15,4)
				);
			}
		}
		$this->load->view ( 'planilla', $datos);
	}
	
	
	
}