<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class Gestion_sesion
{
    private $ci;
    protected $headers;
    protected static $encrypt = ['HS256'];
    protected static $aud = null;


    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->headers = apache_request_headers();
        $this->ci->load->model('UsuarioDAO');
        $this->ci->load->model('UsuarioGrupoDAO');
        $this->ci->load->model('GrupoDAO');
        $this->ci->load->library('bcrypt');


    }

    function index()
    {

        $url = $_SERVER["REQUEST_URI"];
        if (strtolower($url) != strtolower("/saga/api/UsuarioEndPoint/login")) {

            if (!isset($this->ci->headers["authorization"]) || empty($this->ci->headers["authorization"])) {
                $this->ci->response(['error' => 'No esta autenticado', 'status' => 401], 401);

            } else {
                //////////////////////// DESENCRIPTACION///////////////////////////////////////
                $secret_key = 'Riv1s9x80DA94@';
                $token = str_replace('"', '', $this->ci->headers["authorization"]);
                try {

                    $tokenDesencriptado = JWT::decode($token, $secret_key, array('HS256'));
                } catch (Exception  $e) {
                    $this->ci->response(['error' => $e->getMessage(), 'status' => 403], 403);
                }

                /////////////////////////VERIFICACION DE USUARIO Y CONTRASEÑA///////////////////////////////////////
                $usuario = $this->ci->UsuarioDAO->query(['nombre_usuario' => $tokenDesencriptado->data->usuario]);

                if (count($usuario) !== 1) {
                    $this->ci->response(['message' => 'Usuario inexistente'], 500);
                } else {
                    //Comparar la contraseña de recibida con la contraseña de la base
                    if (!$this->ci->bcrypt->verify($tokenDesencriptado->data->contraseña , $usuario[0]->contraseña))
                        $this->ci->response(['message' => 'Contraseña invalida'], 500);
                }
                if ($usuario[0]->estado == 0)
                    $this->ci->response(['message' => 'Usuario inactivo'], 500);

                /////////////////////////VERIFICACION DE DIRECCION IP///////////////////////////////////////
                if ($tokenDesencriptado->aud !== self::Aud())
                    $this->ci->response(['message' => 'Invalid user logged in.', 'status' => 401], 401);
                //////////////////////////////////////////////////////////////////
			
				/*

                //Falta ver si el usuario no es administrador
                //para comprobar el acceso permitido para el bedel.

                $controlador = $_SERVER["PATH_INFO"];
                $controladores_permitidos = array('/api/aulas','/api/edificios/1','/api/eventos','/api/clases');

                if(!in_array($controlador,$controladores_permitidos)){
					$this->ci->response(['message' => 'Debe poseer permiso de administrador'], 401);

                }
          */
								
				
            }
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

    function getData($token)
    {
        return JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        )->data;
    }


}
