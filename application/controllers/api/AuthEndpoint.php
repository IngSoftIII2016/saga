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
        $this->load->model('Login_Model');
        $this->load->model('UsuarioDAO');
        $this->load->model('AccionDAO');
        $this->load->model('AccionRolDAO');
        $this->load->library('bcrypt');

        $this->load->library(array('ion_auth', 'form_validation'));
    }

    protected function getDAO()
    {
        return $this->UsuarioDAO;
    }

    public function login_post()
    {
        $json = $this->post('data');

        try {
            $email = $json['usuario']; // cambiar la propiedad json a email
            $contraseña = $json['contraseña']; // cambiar la propiedad json a pass
            $usuario = $this->getDAO()->query(['email' => $email], [], ['rol']);

            if (count($usuario) !== 1){
                $this->response(format_error('Usuario Inexistente', 'El correo electronico ingresado no corresponde a ningun usuario registrado'), 401);
            } else if (!$this->bcrypt->verify($contraseña, $usuario[0]->password)) {
                $this->response(format_error('Contraseña invalida', 'La contraseña ingresada es incorrecta'), 401);
//            } else if ($usuario[0]->estado == 0) {
  //              $this->response(format_error('Usuario inactivo', 'Su usuario ha sido inhabilitado temporalmente'), 401);
            } else {
                $usuario = $usuario[0];
                //var_dump($usuario);
                $usuario->rol->acciones = [];
                $ars = $this->AccionRolDAO->query(['rol.id' => $usuario->rol->id], [], ['accion']);
                foreach ($ars as $ar)
                    $usuario->rol->acciones[] = $ar->accion;
                $time = time();
                // 43200 seg = 12 horas
                $token = array(
                    'exp' => $time + (43200),
                    'aud' => self::Aud(),
                    'data' => $usuario
                );

                $jwt = JWT::encode($token, self::$secret_key);

                $this->response(['body' => ['token' => $jwt, 'usuario' => $usuario->nombre_usuario , 'nombre_apellido'=>$usuario->nombre.' '.$usuario->apellido]], 200);
            }
        } catch (Exception $e) {
            $this->response(format_error('Error al construir token', $e->getMessage()) , 500);
        }
    }

    public function reset_pass_post() {
        $this->load->library("email");
        $json = $this->post('data');

        //obtengo el usuario por el email
        $usuario = $this->getDAO()->query(['email' => $json['email']]);

        if (count($usuario) !== 1) {
            $this->response(['message' => 'Usuario inexistente'], 404);
        } else {

            //genera contraseña aleatoria
            $pass = $this->get_random_password();

            //encripto el pass y se lo seteo al usuario
            $usuario[0]->password = $this->encriptar($pass);

            //genero la entity del usuario
            $entity = $this->load->model(Usuario);

            //cargo los datos en la entity
            $entity->from_row($usuario[0]);

            //actualiso los datos
            $this->getDAO()->update($entity);

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
            $this->email->to($json['email']);
            $this->email->subject('Contraseña Nueva');
            $this->email->message('<h2>Este mensaje es generado automaticamente</h2><hr><br> Contraseña: ' , $pass);
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

    public function acciones_post()
    {
        $json = $this->post('data');

        try {
            $email = $json['usuario'];

           $acciones = $this->AccionDAO->$this->query(['rol.usuario.email' => $email]);


                $this->response(['body' => ['acciones' => $acciones ] ], 200);
            }

         catch (Exception $e) {
            $this->response(['message' => $json], 500);
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

}