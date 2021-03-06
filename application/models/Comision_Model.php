<?php
require_once('Grocery_crud_model.php');

class Comision_Model extends Grocery_crud_model
{
    public $id;
    public $nombre;
    public $Periodo_id;
    public $Docente_id;
    public $Asignatura_id;

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function from_array($array) {
        $this->id = $array['id'];
        $this->nombre = $array['nombre'];
        $this->Periodo_id = $array['Periodo_id'];
        $this->Docente_id = $array['Docente_id'];
        $this->Asignatura_id = $array['Asignatura_id'];
    }

    public function to_array() {
        $array['id'] = $this->id;
        $array['nombre'] = $this->nombre;
        $array['Periodo_id'] = $this->Periodo_id ;
        $array['Docente_id'] = $this->Docente_id;
        $array['Asignatura_id'] = $this->Asignatura_id;
    }

    public function get_comisiones()  {
        $this->db->select('co.*, a.nombre AS asignatura');
        $this->db->from('comision AS co');
        $this->db->join('asignatura AS a', 'co.Asignatura_id = a.id');
        return $this->db->get()->result();
    }

    public function get_all() {
        return $this->db->get('comision')->result();
    }
}