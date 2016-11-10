<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/controllers/api/UsuarioEndpoint.php';

class Acceso extends CI_Controller
{
	protected $entity;
	
    public function login() {
        $this->entity = new UsuarioEndpoint();
       echo json_encode($this->entity->usuarios_get());
    }

    
}