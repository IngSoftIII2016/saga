<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 08/09/16
 * Time: 22:41
 */
class AulasController extends CI_Controller {

    public function index($fecha = null) {
        $this->load->model('Clase_model');
        if(is_null($fecha)) $fecha = new DateTime(); //arreglar
        $aulas = $this->aulas_edificio(1); //campus
        $clases = $this->Clase_model->get_clases_dia($fecha->format("Y-m-d"));
        $data['fecha'] = $fecha;
        $data['aulas'] = $aulas;
        $data['clases'] = $clases;

        $this->load->view('aulas_diario', $data);
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