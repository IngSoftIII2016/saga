<?php
require_once APPPATH . '/controllers/api/BaseEndpoint.php';

class ComisionEndpoint extends BaseEndpoint
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct('Comision');
        $this->load->model('ComisionDAO');
    }

    protected  function getDAO()
    {
        return $this->ComisionDAO;
    }

    /**
     * @param $id
     */
    public function comisiones_get($id = null)
    {
        $this->base_get($id);
    }

    public function comisiones_post()
    {
        $this->base_post();
    }

    public function comisiones_put()
    {

        $this->base_put();
    }

    public function comisiones_delete($id)
    {
        $this->base_delete($id);
    }
}