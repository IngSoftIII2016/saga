<?php

class Planilla extends CI_Controller {
	public function index() {
		$this->cargar ( new DateTime () );
	}
	public function calendario_ajax() {
		$fecha = DateTime::createFromFormat ( "d-m-Y", $this->input->post ( "fecha" ) );
		$this->cargar_ajax ( $fecha, $this->input->post ( "fecha_calendario" ) );
	}
	public function cargar($fecha) {
		date_default_timezone_set ( "America/Argentina/Buenos_Aires" );
		$this->load->model ( 'Clase_model' );
		$this->load->model ( 'Edificio_model' );
		$this->load->model ( 'Evento_Model' );
		
		$aulas = $this->aulas_edificio ( 1 ); // campus
		$clases = $this->Clase_model->get_clases_dia ( $fecha->format ( "Y-m-d" ) );
		$data ['calendario'] = $fecha;
		$data ['fecha'] = $fecha;
		$data ['fecha_formateada'] = $this->formatear_fecha ( $fecha );
		$data ['aulas'] = $aulas;
		$data ['clases'] = $clases;
		$data ['edificios'] = $this->Edificio_model->get_edificios();
		$data ['eventos'] = $this->Evento_Model->get_eventos_dia ( $fecha->format ( "Y-m-d" ) );
		$this->load->view ( 'aulas_diario', $data );
	}
	public function cargar_ajax($fecha = null) {
		if ($fecha == null) {
			$fecha = new DateTime ();
			$calendario=$fecha->format("d/m/Y");
		}
		else {
			$calendario=$fecha->format("d/m/Y");;
		}
		date_default_timezone_set ( "America/Argentina/Buenos_Aires" );
		$this->load->model ( 'Clase_model' );
		$this->load->model ( 'Edificio_model' );
		$this->load->model ( 'Evento_Model' );
		
		$aulas = $this->aulas_edificio ( 1 ); // campus
		$clases = $this->Clase_model->get_clases_dia ( $fecha->format ( "Y-m-d" ) );
		$data ['calendario'] = $calendario;
		$data ['fecha'] = $fecha;
		$data ['fecha_formateada'] = $this->formatear_fecha ( $fecha );
		$data ['aulas'] = $aulas;
		$data ['clases'] = $clases;
		$data ['edificios'] = $this->Edificio_model->get_edificios ();
		$data ['eventos'] = $this->Evento_Model->get_eventos_dia ( $fecha->format ( "Y-m-d" ) );
		$this->load->view ( 'planilla', $data );
	}
	public function horario_ajax() {
		$fecha = DateTime::createFromFormat ( "d-m-Y", $this->input->post ( "fecha" ) );
		$operacion = $this->input->post ( "operacion" );
		$i = DateInterval::createFromDateString ( '1 day' );
		if ($operacion == '+')
			$fecha->add ( $i );
		else
			$fecha->sub ( $i );
		$this->cargar_ajax ( $fecha);
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
		return $dias [$fecha->format ( "w" )] . ' ' . $fecha->format ( 'd/m/Y' );
	}
	public function get_clase_dia($fecha) {
		$this->load->model ( 'Clase_model' );
		echo json_encode ( $this->Clase_model->get_clases_dia ( $fecha ) );
	}
	public function aulas_campus() {
		echo json_encode ( $this->aulas_edificio ( 1 ) );
	}
	private function aulas_edificio($edificio_id) {
		$this->load->model ( 'Aula_model' );
		return $this->Aula_model->get_aulas_by_edificio ( $edificio_id );
	}
}