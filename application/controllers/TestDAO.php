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
        $this->load->model('Example_DAO_Model');
        var_dump($this->Example_DAO_Model->query([],[]));
    }

    public function horarios_tarde() {
        $this->load->model('Example_DAO_Model');
        var_dump($this->Example_DAO_Model->query(
            [
                'horario.hora_inicio >' => '14:00:00',
                'horario.aula.nombre' => 'Aula 1'
            ],
            [
                'horario.hora_inicio' => '+'
            ]));
    }

    public function horarios_order() {
        $this->load->model('Example_DAO_Model');
        var_dump($this->Example_DAO_Model->query([],['horario.hora_inicio' => '']));
    }

    public function horarios_id($id) {
        $this->load->model('Example_DAO_Model');
        var_dump($this->Example_DAO_Model->get_by_id($id));
    }
}