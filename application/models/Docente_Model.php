<?php

require_once('Grocery_crud_model.php');
class Docente_Model extends Grocery_crud_model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_docentes() {
        return $this->db->get('docente')->result();
    }
}