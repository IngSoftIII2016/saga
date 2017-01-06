<?php
require_once APPPATH . '/controllers/api/BaseEndpoint.php';

class AccionEndpoint extends BaseEndpoint
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct('Accion');
        $this->load->model('AccionDAO');
    }

    protected  function getDAO()
    {
        return $this->AccionDAO;
    }

    /**
     * @param $id
     */
    public function acciones_get($id = null)
    {
        $this->base_get($id);
    }

    public function acciones_post()
    {
        $this->base_post();
    }

    public function acciones_put()
    {
        $this->base_put();
    }

    public function acciones_delete($id)
    {
        $this->base_delete($id);
    }
}