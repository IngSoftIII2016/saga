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
class Evento extends REST_Controller
{

    function __construct()
    {

        // Construct the parent class
        parent::__construct();
        $this->load->model('Evento_Model');

    }

    /**
     * @param $id
     */
    public function eventos_get($id = null)
    {
        if ($id != null) {
            $clase = $this->Evento_Model->get_evento($id);
            $this->response(['data' => $clase]);
        } else {
            $clases = $this->Evento_Model->get_eventos();
            $this->response(['data' => $clases]);
        }
    }

    public function eventos_post()
    {
        $json = $this->post('data');
        $aula = $json['Aula_id'];
        $fecha = $json['fecha'];
        $hora_inicio = $json['hora_inicio'];
        $hora_fin = $json['hora_fin'];
        $motivo = $json['motivo'];
        if ($this->Evento_Model->agregar_evento($aula, $fecha, $hora_inicio, $hora_fin, $motivo)) {
            $this->response($json);
        } else {
            $this->response(['error' => 'no se puede insertar el evento, el aula se encuentra ocupada'], 500);
        }
    }

    public function eventos_put()
    {
        $json = $this->put('data');
        $id = $json['id'];
        $aula = $json['Aula_id'];
        $fecha = $json['fecha'];
        $hora_inicio = $json['hora_inicio'];
        $hora_fin = $json['hora_fin'];
        $motivo = $json['motivo'];
        if ($this->Evento_Model->modificar($id, $aula, $fecha, $hora_inicio, $hora_fin, $motivo)) {
            $this->response($json, 202);
        } else {
            $this->response(['error' => 'no se puede modificar el evento, el aula se encuentra ocupada'], 500);
        }
    }

    public function eventos_delete($id)
    {
        if ($id != null) {
            $this->Evento_Model->borrar($id);
            $this->response(['data' => ['id' => $id] ], 202);
        } else {
            $this->response(['errors' => 'no se pudo borrar el evento'], 500);
        }

    }


}