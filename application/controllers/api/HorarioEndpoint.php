<?php

/**
 * Created by PhpStorm.
 * User: Juan Pablo Aveggio
 * Date: 30/10/16
 * Time: 18:33
 */
require_once APPPATH . '/controllers/api/BaseEndpoint.php';

class HorarioEndpoint extends BaseEndpoint
{
    public function __construct()
    {
        parent::__construct('Horario');
        $this->load->model('HorarioDAO');
    }
    protected  function getDAO()
    {
        return $this->HorarioDAO;
    }

    public function horarios_get($id = null) {
        $this->base_get($id);
    }

    public function horarios_post() {
        $this->base_post();
    }

    public function horarios_put() {
        $this->base_put();
    }

    public function horarios_delete($id) {
        $this->base_delete($id);
    }
}