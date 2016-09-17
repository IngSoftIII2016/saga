<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 08/09/16
 * Time: 22:41
 */
class Planilla extends CI_Controller {

    public function index() {
		$this->cargar(new DateTime());
		
    }
	public function calendario(){
		$fecha = DateTime::createFromFormat("d-m-Y", $this->input->post ("fecha"));		
		$this->cargar($fecha, $this->input->post ("fecha_calendario"));
	}
	public function cargar($fecha, $calendario = null){
		date_default_timezone_set ( "America/Argentina/Buenos_Aires" );		

        $this->load->model('Clase_model');
        $this->load->model('Aula_model');

        $ids_aulas = array(1,2,3,4,5,11,6,7,8,9,10,12,13,14,15,16,17); // Harcode: Obtener desde la base

        $aulas = array();
        foreach($ids_aulas as $id)
            $aulas[] = $this->Aula_model->get_by_id($id);

        $clases = $this->Clase_model->get_clases_dia($fecha->format("Y-m-d"));
		$data['calendario']= $calendario;
        $data['fecha'] = $fecha;
		$data['fecha_formateada'] = $this->formatear_fecha($fecha);
        $data['aulas'] = $aulas;
        $data['clases'] = $clases;

        $this->load->view('aulas_diario', $data);
	}
	public function horario(){
		$fecha = DateTime::createFromFormat("d-m-Y", $this->input->post ("fecha"));
		$operacion = $this->input->post("operacion");
		$i = DateInterval::createFromDateString('1 day');
		if($operacion == '+')			
			$fecha->add($i);
		else 
			$fecha->sub($i);
		$this->cargar($fecha);
	}
	
	
	private function formatear_fecha($fecha) {
		$dias = array (
							"Domingo",
							"Lunes",
							"Martes",
							"Mi&eacute;rcoles",
							"Jueves",
							"Viernes",
							"S&aacute;bado" 
					);
		return $dias[$fecha->format("w")] . ' ' . $fecha->format('d/m/Y');
	}

    public function get_clase_dia($fecha) {
        $this->load->model('Clase_model');
        echo json_encode($this->Clase_model->get_clases_dia($fecha));
    }

    public function aulas_campus() {
        echo json_encode($this->aulas_edificio(1));
    }

}