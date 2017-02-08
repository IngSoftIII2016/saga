<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require_once APPPATH . '/controllers/api/BaseEndpoint.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

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
class UsuarioEndpoint extends BaseEndpoint
{
    //protected static $secret_key = 'Riv1s9x80DA94@';

    function __construct()
    {
        // Construct the parent class
        parent::__construct('Usuario');
        $this->load->model('UsuarioDAO');
        $this->load->library(array('saga'));
    }

    protected function getDAO()
    {
        return $this->UsuarioDAO;
    }

    public function usuarios_get($id = null)
    {
        $this->base_get($id);
    }

    public function usuarios_post()
    {
        $json = $this->post('data');
        $json['password'] = $this->saga->get_random_password();
        $json['estado'] = 1;
        $entity = $this->json_to_entity($json);
        if (array_key_exists('error', $entity)) {
            $this->response($entity, 400);
            return;
        }
        $result = $this->getDAO()->insert($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
    }

    public function usuarios_put()
    {
        $this->base_put();
    }

    public function usuarios_delete($id)
    {
        $this->base_delete($id);
    }

    public function reset_pass() {

    }
}