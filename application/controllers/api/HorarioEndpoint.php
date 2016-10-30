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

    public function horarios_get($id = null)
    {
        if ($id != null) {
            $horarios = $this->HorarioDAO->query(['id' => $id], [], ['aula.edificio', 'comision.asignatura'])[0];
            $this->response(['data' => $horarios]);
        } else {
            $horarios = $this->HorarioDAO->query([], [], ['aula.edificio', 'comision.asignatura']);
            $this->response(['data' => $horarios]);
        }
    }

    public function horario_get() {
        var_dump($this->get());
    }
}