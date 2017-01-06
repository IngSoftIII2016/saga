<?php
require_once APPPATH . '/controllers/api/BaseEndpoint.php';

class RolEndpoint extends BaseEndpoint
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct('Rol');
        $this->load->model('RolDAO');
    }

    protected  function getDAO()
    {
        return $this->RolDAO;
    }

    /**
     * @param $id
     */
    public function roles_get($id = null)
    {
        $this->base_get($id);
    }

    public function roles_post()
    {
        $this->base_post();
    }

    public function roles_put()
    {
        $this->base_put();
    }

    public function roles_delete($id)
    {
        $this->base_delete($id);
    }
}