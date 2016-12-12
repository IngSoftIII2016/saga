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
    protected static $secret_key = 'Riv1s9x80DA94@';

    function __construct()
    {
        // Construct the parent class
        parent::__construct('Usuario');
        $this->load->model('Login_Model');
        $this->load->model('UsuarioDAO');
        $this->load->library('bcrypt');

        $this->load->library(array('ion_auth', 'form_validation'));
    }

    protected function getDAO()
    {
        return $this->UsuarioDAO;
    }

    public function index($id)
    {
        var_dump($id);
    }


    private function encriptar($contraseña)
    {
        $this->load->library('encrypt');
        return password_hash($contraseña, PASSWORD_DEFAULT);
    }

    public function login_post()
    {
        $json = $this->post('data');
        $nombre_usuario = $json['usuario'];
        $contraseña = $json['contraseña'];
        $usuario = $this->getDAO()->query(['nombre_usuario' => $nombre_usuario]);

        if (count($usuario) !== 1) {
            $this->response(['message' => 'Usuario inexistente'], 500);
        } else if (!$this->bcrypt->verify($contraseña, $usuario[0]->contraseña)) {
            $this->response(['message' => 'Contraseña invalida'], 500);
        } else if ($usuario[0]->estado == 0) {
            $this->response(['message' => 'Usuario inactivo'], 500);
        } else {
            $time = time();
			//604800 seg = semana
            $token = array(
                'exp' => $time + (604800),
                'aud' => self::Aud(),
                'data' => $json
            );

            $jwt = JWT::encode($token, self::$secret_key);

            $this->response(['body' => ['token' => $jwt, 'usuario' => $usuario[0]->nombre_usuario , 'nombre_apellido'=>$usuario[0]->nombre.' '.$usuario[0]->apellido]], 200);
        }
    }

    private static function Aud()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }


    public function usuarios_get($id = null)
    {
        $this->base_get($id);
    }

    public function usuarios_post()
    {
        $json = $this->post('data');
        $contraseña_encrypt= $this->encriptar($json['contrasenia']);
         $json['contraseña']=$contraseña_encrypt;
        $entity = $this->json_to_entity($json);
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
}