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
class EventoEndpoint extends BaseEndpoint
{

    function __construct()
    {

        // Construct the parent class
        parent::__construct('Evento');
        $this->load->model('EventoDAO');

    }

    /**
     * @param $id
     */
    public function eventos_get($id = null)
    {
        if ($id != null) {
            $evento = $this->EventoDAO->query(['id' => $id], [], ['aula'])[0];
            $this->response(['data' => $evento]);
        } else {
            $eventos = $this->EventoDAO->query([], [], ['aula']);
            $this->response(['data' => $eventos]);
        }
    }

    public function eventos_post()
    {
        $json = $this->post('data');
        $entity = $this->json_to_entity($json);
        $result = $this->EventoDAO->insert($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
    }

    public function eventos_put()
    {
        $json = $this->put('data');
        $entity = $this->json_to_entity($json);
        $result = $this->EventoDAO->update($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
    }

    public function eventos_delete($id)
    {
        $json = $this->delete('data');
        $entity = $this->json_to_entity($json);
        $result = $this->EventoDAO->delete($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }

    }


}