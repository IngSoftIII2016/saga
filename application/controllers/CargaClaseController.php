<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CargaClaseController extends CI_Controller {

    function index() {
        echo "hello world";
    }

    function insert() {
        $this->load->model('Horario_model');

        $horarios = $this->Horario_model->get_all();

        foreach($horarios as $h) {

           $this->Horario_model->insert_clases($h);
        }
    }

    function insert_id($id) {
        $this->load->model('Horario_model');

        $this->Horario_model->load($id);
        $this->Horario_model->insert_clases();
    }

    function insert_periodo_id($periodo_id){
        $this->load->model('Horario_model');

        $horarios = $this->Horario_model->get_by_periodo_id($periodo_id);
        var_dump($horarios);
        /*
        foreach($horarios as $horario) {
            echo json_encode($horario);
            $this->Horario_model->load($horario->id);
            $this->Horario_model->insert_clases();
        }
        */
    }


    function horario($id) {
        $this->load->model('Horario_model');
        $this->Horario_model->load($id);
        echo json_encode($this->Horario_model);
    }

    function horarios_periodo($periodo_id) {
        $this->load->model('Horario_model');
        $horarios = $this->Horario_model->get_by_periodo_id($periodo_id);
        echo json_encode($horarios);
    }
}