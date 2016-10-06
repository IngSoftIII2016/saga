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
}