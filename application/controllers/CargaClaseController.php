<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CargaClaseController extends CI_Controller {

    function index() {
        echo "hello world";
    }

    function colisiones($id) {
        $this->load->model('Horario_model');
        $this->Horario_model->load($id);
        var_dump($this->Horario_model->get_colisiones(2));

    }
/*
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
*/
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

    public function clases() {
        $this->load->model('Clase_model');
        $clases = $this->Clase_model->get_clases();
        echo json_encode($clases);
    }

    public function aulas() {
        $this->load->model('Aula_model');
        $aulas = $this->Aula_model->get_aulas();
        echo json_encode($aulas);
    }
    public function edificios() {
        $this->load->model('Edificio_model');
        $edificios = $this->Edificio_model->get_edificios();
        echo json_encode($edificios);
    }
    public function horarios() {
        $this->load->model('Horario_model');
        $horarios = $this->Horario_model->get_horarios(array());
        echo json_encode($horarios);
    }
    public function comisiones() {
        $this->load->model('Comision_Model');
        $comisiones = $this->Comision_Model->get_all();
        echo json_encode($comisiones);
    }
    public function asignaturas() {
        $this->load->model('Asignatura_Model');
        $asignaturas = $this->Asignatura_Model->get_asignaturas();
        echo json_encode($asignaturas);
    }
}