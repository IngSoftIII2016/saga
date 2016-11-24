<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require_once APPPATH . '/controllers/api/BaseEndpoint.php';

class AsignaturaCarreraEndpoint extends BaseEndpoint
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct('AsignaturaCarrera');
        $this->load->model('AsignaturaCarreraDAO');
        $this->AsignaturaCarreraDAO->set_debug_enabled(false);
    }

    protected function getDAO()
    {
        return $this->AsignaturaCarreraDAO;
    }

    /**
     * @param $id
     */
    public function asignaturacarrera_get($id = null)
    {
        $this->base_get($id);
    }

    public function asignaturacarrera_post()
    {
        $this->base_post();
    }

    public function asignaturacarrera_put()
    {
        $this->base_put();
    }

    public function asignaturacarrera_delete()
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