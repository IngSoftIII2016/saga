<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 24/11/16
 * Time: 05:12
 */

require_once APPPATH . '/controllers/api/BaseEndpoint.php';

class UsuarioGrupoEndpoint extends BaseEndpoint
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
        $json = $this->delete('data');
        $entity = $this->json_to_entity($json);
        if($entity == null)
            $this->response(['error' => "$entity->get_table_name() inexistente"], 404);
        $result = $this->getDAO()->delete($entity);
        if (is_array($result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
    }
}