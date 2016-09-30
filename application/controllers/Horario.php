<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 27/09/16
 * Time: 19:07
 */
class Horario extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->model('Periodo_Model');
        $p = $this->Periodo_Model->get_periodo_actual();
        $this->cargar(array('Periodo_id' => $p->id));
    }

    public function filtrar() {
        $this->cargar($this->input->post());
    }

    private function cargar($filtros){
        $this->load->model('Horario_model');
        $this->load->model('Aula_model');
        $this->load->model('Asignatura_Model');
        $this->load->model('Carrera_Model');
        $this->load->model('Docente_Model');
        $this->load->model('Periodo_Model');
        $data['dias'] = $this->Horario_model->get_dias();
        $data['aulas'] = $this->Aula_model->get_aulas_join_edificio();
        $data['asignaturas'] = $this->Asignatura_Model->get_asignaturas();
        $data['carreras'] = $this->Carrera_Model->get_carreras();
        $data['docentes'] = $this->Docente_Model->get_docentes();
        $data['periodos'] = $this->Periodo_Model->get_periodos();
        $data['action_url'] = base_url('horario/filtrar');
        $data['filtros'] = $filtros;
        $data['horarios'] = $this->Horario_model->get_horarios($filtros);
        $out['body'] = 'horario/list';
        $out['data'] = $data;
        $this->load->view('templates/base', $out);
    }


    public function insert(){
        $this->load->model('Horario_model');
        $this->Horario_model->from_array($this->input->post());
        $this->Horario_model->insert();

    }

}