<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class UsuarioEndpoint extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Login_Model');
		$this->load->library(array('ion_auth','form_validation'));

    }

    public function index($id){
        var_dump($id);
    }



    public function login_post ()
    {
        $json = $this->post('data');
        $usuario = $json['usuario'];
        $contraseña = $json['contraseña'];
        $recordar= $json['recordar'];

        if ($this->Login_Model->login($usuario, $contraseña, $recordar))
        {
            //$cookie=$this->input->cookie('ci_session');
            $this->response(array('status' => 'success'));
            //redirect(base_url('planilla'));
        }
        else
            $this->response(array('status' => 'failed'));
    }

    public function logout_delete ()
    {
        $this->ion_auth->logout();
        $this->response(array('status' => TRUE,'message' => 'ci_session deleted'));

    }



}