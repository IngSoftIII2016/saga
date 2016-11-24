<?php
require_once APPPATH . '/controllers/api/BaseEndpoint.php';

class AulaEndpoint extends BaseEndpoint
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct('Aula');
        $this->load->model('AulaDAO');
    }

    protected  function getDAO()
    {
        return $this->AulaDAO;
    }

    /**
     * @param $id
     */
    public function aulas_get($id = null)
    {
        $this->base_get($id);
    }

    public function aulas_post()
    {
        $this->base_post();
    }

    public function aulas_put()
    {
        $this->base_put();
    }

    public function aulas_delete($id)
    {
        $this->base_delete($id);
    }
}