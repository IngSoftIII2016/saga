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

        try {
            $email = $json['usuario'];
            $contraseña = $json['contraseña'];
            $usuario = $this->getDAO()->query(['email' => $email]);

            if (count($usuario) !== 1) {
                $this->response(['message' => 'Usuario inexistente'], 500);
            } else if (!$this->bcrypt->verify($contraseña, $usuario[0]->contraseña)) {
                $this->response(['message' => 'Contraseña invalida'], 500);
            } else if ($usuario[0]->estado == 0) {
                $this->response(['message' => 'Usuario inactivo'], 500);
            } else {
                $time = time();
                // 43200 seg = 12 horas
                $token = array(
                    'exp' => $time + (43200),
                    'aud' => self::Aud(),
                    'data' => $json
                );

                $jwt = JWT::encode($token, self::$secret_key);

                $this->response(['body' => ['token' => $jwt, 'usuario' => $usuario[0]->nombre_usuario , 'nombre_apellido'=>$usuario[0]->nombre.' '.$usuario[0]->apellido]], 200);
            }
        } catch (Exception $e) {
            $this->response(['message' => $json], 500);
        }
    }

    public function reset_pass_post() {
        $this->load->library("email");
        $json = $this->post('data');

        $usuario = $this->getDAO()->query(['email' => $email]);


        if (count($usuario) !== 1) {
            $this->response(['message' => 'Usuario inexistente'], 500);
        } else {
            $pass = get_random_password();
            $usuario[0]->email = $this->encriptar($pass);

            //configuracion para gmail
            $configGmail = array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => 465,
                'smtp_user' => 'noreplysagaingiii',
                'smtp_pass' => 'ing3SAGA',
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'newline' => "\r\n"
            );

            //cargamos la configuración para enviar con gmail
            $this->email->initialize($configGmail);

            $this->email->from('Administracion y Gestion de Aulas UNRN');
            $this->email->to($usuario[0]->email);
            $this->email->subject('Contraseña Nueva');
            $this->email->message('<h2>Este mensaje es egenerado automaticamente</h2><hr><br> Contraseña: ' , $pass);
            $this->email->send();
        }
    }

    function get_random_password($chars_min=6, $chars_max=8, $use_upper_case=true, $include_numbers=true, $include_special_chars=true)
    {
        $length = rand($chars_min, $chars_max);
        $selection = 'aeuoyibcdfghjklmnpqrstvwxz';
        if($include_numbers) {
            $selection .= "1234567890";
        }
        if($include_special_chars) {
            $selection .= "@#$?";
        }

        $password = "";
        for($i=0; $i<$length; $i++) {
            $current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];
            $password .=  $current_letter;
        }

        return $password;
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
        $json['contraseña']= $this->encriptar($json['contrasenia']);
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