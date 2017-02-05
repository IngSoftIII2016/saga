<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require_once APPPATH . '/controllers/api/BaseEndpoint.php';

class ParametrosEndpoint extends BaseEndpoint
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct('Parametro');
        $this->load->model('ParametrosDAO');
    }

    protected  function getDAO()
    {
        return $this->ParametrosDAO;
    }

    public function parametros_get($id = null)
    {
        $this->base_get($id);
    }

    public function parametros_post()
    {
        $this->base_post();
    }

    public function parametros_put()
    {
        $this->base_put();
    }

    public function parametros_delete($id)
    {
        $this->base_delete($id);
    }

    public function parametros_valor_post()
    {
        $json = $this->post('data');
        $clave = $this->getDAO()->query(['clave' => $json['clave']]);

        if (count($clave) !== 1) {
            $this->response(['message' => 'Clave inexistente'], 500);
        } else {
            $parametro = $clave[0];

            $this->response(['data' => ['valor' => $parametro->valor]], 200);
        }
    }
}