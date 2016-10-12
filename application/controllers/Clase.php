<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Clase extends CI_Controller
{
	public function __construct()
	{   parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }
    public function agregar_comentario_ajax() {
    	$this->load->model('Clase_model');
    	$id = $this->input->post ( 'idclase' );
 		$comentario = $this->input->post ( 'comentarioclase' );	
		if($this->Clase_model->agregar_comentario($id, $comentario)){
			echo "1";
			die ();
		}
		else {
			echo "Acceso denegado";
			die ();
		}
    }
    
    public function cambiar_clase() {
    	date_default_timezone_set ( "America/Argentina/Buenos_Aires" );
    	$this->load->model('Clase_model');
    	$idclase = $this->input->post ( 'idclase' );
    	$fecha= $this->input->post ( 'fecha' );
    	$fecha = date('Y-d-m',strtotime($fecha));
    	$hora_inicio= $this->input->post ( 'horainicio' );
    	$hora_fin= $this->input->post ( 'horafin' );
    	$idaula= $this->input->post ( 'idaula' );
    	if($this->Clase_model->agregar_comentario($idclase, $fecha, $hora_inicio, $hora_fin, $idaula)){
    		echo "1";
    		die ();
    	}
    	else {
    		echo "Acceso denegado";
    		die ();
    	}
    }
}