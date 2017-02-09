<?php
if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');

class Saga
{
    public function get_random_password($chars_min = 6, $chars_max = 8, $use_upper_case = true, $include_numbers = true, $include_special_chars = true)
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

    public function mandar_correo($pass, $json) {
        $CI =& get_instance();

        $CI->load->library('email');
        //$CI->email->do_something();

        //$this->load->library("email");

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
        $CI->email->initialize($configGmail);

        $CI->email->from('UNRN - Administracion y Gestion de Aulas');
        $CI->email->to($json['email']);
        $CI->email->subject('Nueva contraseña de acceso');
        $CI->email->message('<h1>Sistema de Administracion y Gestion de Aulas UNRN</h1><h2>Su contraseña de acceso es: </h2><p><b>' . $pass . '</b></p>');
        $CI->email->send();
    }

    public function get_parametro($parametro) {
        $clave = $this->getDAO()->query(['clave' => $parametro]);

        if (count($clave) !== 1) {
            return "ERROR CON PARAMETRO";
        } else {
            $parametro = $clave[0];
            return $parametro->valor;
        }
    }
}