<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require_once APPPATH . '/controllers/api/BaseEndpoint.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class AuthEndpoint extends BaseEndpoint
{

    protected static $secret_key = 'Riv1s9x80DA94@';

    function __construct()
    {
        // Construct the parent class
        parent::__construct('Usuario');
        $this->load->model('UsuarioDAO');
        $this->load->model('AccionDAO');
        $this->load->model('AccionRolDAO');

        $this->load->library(array('ion_auth', 'form_validation', 'saga'));
    }

    protected function getDAO()
    {
        return $this->UsuarioDAO;
    }

    private function encriptar($contraseña) {
        return password_hash($contraseña, PASSWORD_DEFAULT);
    }

    private function comprobar_hash($contraseña, $pass) {
        return password_verify ($contraseña , $pass);
    }

    public function login_post()
    {
        $json = $this->post('data');

        try {
            $email = $json['email']; // cambiar la propiedad json a email
            $password = $json['password']; // cambiar la propiedad json a pass
            $usuario = $this->getDAO()->query(['email' => $email], [], ['rol']);

            if (count($usuario) !== 1) {
                $this->response(format_error('Usuario Inexistente',
                    'El correo electronico ingresado no corresponde a ningun usuario registrado'), 401);
            } else
                if (!$this->comprobar_hash($password, $usuario[0]->password)) {
                $this->response(format_error('Contraseña invalida', 'La contraseña ingresada es incorrecta'), 401);
            } else if ($usuario[0]->estado == 0) {
                $this->response(format_error('Usuario inactivo', 'Su usuario ha sido inhabilitado temporalmente'), 401);
            } else {
                $usuario = $usuario[0];
                //var_dump($usuario);
                $usuario->rol->acciones = [];
                $ars = $this->AccionRolDAO->query(['rol.id' => $usuario->rol->id], [], ['accion'], [], -1);
                foreach ($ars as $ar)
                    $usuario->rol->acciones[] = $ar->accion;
                $usuario->password = null;
                $time = time();
                // 43200 seg = 12 horas
                $token = array(
                    'exp' => $time + (43200),
                    'aud' => self::Aud(),
                    'data' => $usuario
                );

                $jwt = JWT::encode($token, self::$secret_key);

                $this->response(['body' => ['token' => $jwt]], 200);
            }
        } catch (Exception $e) {
            $this->response(format_error('Error al construir token', $e->getMessage()), 500);
        }
    }

    public function reset_pass_post() {
        $this->load->library("email");
        $json = $this->post('data');

        //obtengo el usuario por el email
        $usuario = $this->getDAO()->query(['email' => $json['email']], [] , ['rol']);
        var_dump($usuario[0]);

        if (count($usuario) !== 1) {
            $this->response(['message' => 'Usuario inexistente'], 500);
        } else {

            //genera contraseña aleatoria
            $pass = $this->saga->get_random_password();

            //encripto el pass y se lo seteo al usuario
            $usuario[0]->password = $this->encriptar($pass);

            //actualiso los datos
            $this->getDAO()->update($usuario[0]);

            //mando un correo
            $this->saga->mandar_correo($pass, $json);
        }
    }

    function change_pass_post() {
        $json = $this->post('data');
        $oldpassword = $json['oldpassword'];
        $newpassword = $json['newpassword'];
        //obtengo el usuario por el email
        $usuario = $this->getDAO()->query(['email' => $json['email']], [] , ['rol']);
        if (count($usuario) !== 1) {
            $this->response(['message' => 'Usuario inexistente'], 500);
        } else {
            if (!$this->comprobar_hash($oldpassword, $usuario[0]->password)) {
                //encripto el pass y se lo seteo al usuario
                $usuario[0]->password = $this->encriptar($newpassword);

                //actualiso los datos
                $this->getDAO()->update($usuario[0]);
            } else {
                $this->response(['message' => 'Contraseña Actual Incorrecta'], 500);
            }
        }
    }


    function get_random_password($chars_min = 6, $chars_max = 8, $use_upper_case = true, $include_numbers = true, $include_special_chars = true)
    {
        $length = rand($chars_min, $chars_max);
        $selection = 'aeuoyibcdfghjklmnpqrstvwxz';
        if ($include_numbers) {
            $selection .= "1234567890";
        }
        if ($include_special_chars) {
            $selection .= "@#$?";
        }

        $password = "";
        for ($i = 0; $i < $length; $i++) {
            $current_letter = $use_upper_case ? (rand(0, 1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];
            $password .= $current_letter;
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

}