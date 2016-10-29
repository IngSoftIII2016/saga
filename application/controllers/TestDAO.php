<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 24/10/16
 * Time: 01:37
 */
class TestDAO extends CI_Controller
{
    public function horarios() {
        $this->load->model('HorarioDAO');
        echo json_encode($this->HorarioDAO->query()); // la tabla entera, sin relaciones
    }

    public function horarios_tarde() {
        $this->load->model('HorarioDAO');
        echo json_encode($this->HorarioDAO->query(
            [   // filtros
                'hora_inicio >' => '14:00:00',
                'aula.nombre' => 'Aula 2'
            ],
            [   // ordenamiento
                'hora_inicio' => '+'
            ],
            [ 'aula', 'comision' ] // include
        ));
    }

    public function horarios_test() {
        $this->load->model('HorarioDAO');
        //$this->Example_DAO_Model->set_debug_enabled('TRUE');
        echo json_encode($this->HorarioDAO->query(
            ['id' => '278'],
            []
        ));
    }

    public function horario_alta() {
        $this->load->model('HorarioDAO');

    }

    public function horarios_id($id) {
        $this->load->model('HorarioDAO');
        echo json_encode($this->HorarioDAO->get_by_id($id));
    }
}