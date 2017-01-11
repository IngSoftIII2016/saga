<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require_once APPPATH . '/controllers/api/BaseEndpoint.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class AutenticacionEndpont extends BaseEndpoint
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct('Usuario');
        $this->load->model('Login_Model');
        $this->load->model('UsuarioDAO');
        $this->load->model('AccionDAO');
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

        //obtengo el usuario por el email
        $usuario = $this->getDAO()->query(['email' => $json['email']]);

        if (count($usuario) !== 1) {
            $this->response(['message' => 'Usuario inexistente'], 500);
        } else {

            //genera contraseña aleatoria
            $pass = get_random_password();

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
            $this->email->message('<h2>Este mensaje es egenerado automaticamente</h2><hr><br> Contraseña: ' , $pass);
            $this->email->send();
        }
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

}