<?php

require_once('Grocery_crud_model.php');
class Carrera_Model extends Grocery_crud_model
{
    public function get_carreras() {
        return $this->db->get('carrera')->result();
    }

}