<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require_once APPPATH . 'controllers/api/RelationEndpoint.php';

class AccionRolEndpoint extends RelationEndpoint
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct('AccionRol');
        $this->load->model('AccionRolDAO');
        $this->AccionRolDAO->set_debug_enabled(false);
    }

    protected function getDAO()
    {
        return $this->AccionRolDAO;
    }

    /**
     * @param $id
     */
    public function accionrol_get($id = null)
    {
        $this->base_get($id);
    }

    public function accionrol_post()
    {
        $this->base_post();
    }

    public function accionrol_put()
    {
        $this->base_put();
    }

    public function accionrol_delete($id = null)
    {
        $this->base_delete($id);
    }
}