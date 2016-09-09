<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 08/09/16
 * Time: 22:41
 */
class AulasController extends CI_Controller {

    public function index() {
		$this->cargar(new DateTime());
		
    }
	public function cargar($fecha){
		date_default_timezone_set ( "America/Argentina/Buenos_Aires" );
		
        $this->load->model('Clase_model');
        $aulas = $this->aulas_edificio(1); //campus
        $clases = $this->Clase_model->get_clases_dia($fecha->format("Y-m-d"));
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

    private function aulas_edificio($edificio_id) {
        $this->load->model('Aula_model');
        return $this->Aula_model->get_aulas_edificio($edificio_id);
    }

}