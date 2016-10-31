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
class ClaseEndpoint extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('ClaseDAO');

    }

    public function clases_get($id = null)
    {
        if ($id != null) {
            $evento = $this->ClaseDAO->query(['id' => $id], [], ['aula'])[0];
            $this->response(['data' => $evento]);
        } else {
            $params = $this->parse_params();
            $eventos = $this->ClaseDAO->query($params['filters'], $params['sorts'], $params['includes'], $params['page'], $params['size']);
            $this->response(['data' => $eventos]);
        }
    }

    public function clases_post()
    {
        $json = $this->post('data');
        $entity = $this->json_to_entity($json);
        $result = $this->ClaseDAO->insert($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
    }

    public function clases_put()
    {
        $json = $this->put('data');
        $entity = $this->json_to_entity($json);
        $result = $this->ClaseDAO->update($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
    }

    public function clases_delete($id)
    {
        $json = $this->delete('data');
        $entity = $this->json_to_entity($json);
        $result = $this->ClaseDAO->delete($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }

    }





}
