<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 24/11/16
 * Time: 05:12
 */

require_once APPPATH . '/controllers/api/RelationEndpoint.php';

class UsuarioGrupoEndpoint extends RelationEndpoint
{

    public function __construct()
    {
        parent::__construct('UsuarioGrupo');
        $this->load->model('UsuarioGrupoDAO');
    }

    protected function getDAO()
    {
        return $this->UsuarioGrupoDAO;
    }

    /**
     * @param $id
     */
    public function usuariogrupo_get($id = null)
    {
        $this->base_get($id);
    }

    public function usuariogrupo_post()
    {
        $this->base_post();
    }

    public function usuariogrupo_put()
    {
        $this->base_put();
    }

    public function usuariogrupo_delete()
    {
        $this->base_delete();
    }
}