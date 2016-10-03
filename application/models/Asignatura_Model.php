<?php
require_once('Grocery_crud_model.php');

class Asignatura_Model extends Grocery_crud_model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_asignaturas() {
        return $this->db->get('asignatura')->result();
    }

    public function get_asignaturas_by_carrera($carrera_id) {
        $this->db->select('a.id AS id, a.nombre AS nombre, ac.anio AS anio, ac.regimen AS regimen');
        $this->db->from('asignatura_carrera AS ac');
        $this->db->join('asignatura AS a', 'ac.Asignatura_id = a.id', 'left');
        $this->db->where('ac.Carrera_id', $carrera_id);
    }
}