<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require_once APPPATH . '/controllers/api/BaseEndpoint.php';

class AsignaturaEndpoint extends BaseEndpoint
{
    function __construct()
    {
        parent::__construct('Asignatura');
        $this->load->model('AsignaturaDAO');
    }

    protected function getDAO()
    {
        return $this->AsignaturaDAO;
    }

    /**
     * @param $id
     */
    public function asignaturas_get($id = null)
    {
        $this->base_get($id);
    }

    public function asignaturas_post()
    {
        $this->base_post();
    }

    public function asignaturas_put()
    {
        $this->base_put();
    }

    public function asignaturas_delete($id)
    {
        $this->base_delete($id);
    }
}