<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require_once APPPATH . '/controllers/api/BaseEndpoint.php';

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
class UsuarioEndpoint extends BaseEndpoint {

    function __construct()
    {
        // Construct the parent class
		parent::__construct('Usuario');
		$this->load->model('Login_Model');
		$this->load->model('UsuarioDAO');       
		$this->load->library(array('ion_auth','form_validation'));

    }

    protected  function getDAO()
    {
        return $this->UsuarioDAO;
    }

    public function index($id)
    {
        var_dump($id);
    }



    public function login_post ()
    {
        $json = $this->post('data');
        $usuario = $json['usuario'];
        $contraseña = $json['contraseña'];
        //$recordar= $json['recordar'];

        if ($this->Login_Model->login($usuario, $contraseña, true)) {
			$key = 'mi-secret-key';
			$token = array(
                "id" => $contraseña,
				"name" => $usuario,
				"iat" => time(),
				"exp" => time()+ 300
			);
			$jwt = JWT::encode($token, $key, 'HS256');
			$this->response(array('status' => 200, 'body'=> array('token'=> $jwt )));
        }else
            $this->response(array('status' => 'failed'));
    }

    public function logout_delete ()
    {
        $this->ion_auth->logout();
        $this->response(array('status' => TRUE,'message' => 'ci_session deleted'));

    }
	
	public function usuarios_get($id = null)
	{
        $this->base_get($id);
	}

	public function usuarios_post()
	{
        $this->base_post();
	}

	public function usuarios_put()
	{
        $this->base_put();
	}

	public function usuarios_delete($id)
	{
        $this->base_delete($id);
	}
}