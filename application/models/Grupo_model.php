<?php

/**
 * Created by PhpStorm.
 * User: Elias
 */
require_once('Grocery_crud_model.php');
class Grupo_model extends Grocery_crud_model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_grupo($id) {
        $this->db->where('grupo.id', $id);
        return $this->db->get('grupo')->result();
    }
}