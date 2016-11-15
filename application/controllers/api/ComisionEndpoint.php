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
        if ($id != null) {
            $comicion = $this->ComicionDAO->query(['id' => $id], [], [])[0];
            $this->response(['data' => $comicion]);
        } else {
            $params = $this->parse_params();
            $comiciones = $this->ComicionDAO->query($params['filters'], $params['sorts'], $params['includes'], $params['page'], $params['size']);
            $this->response(['data' => $comiciones]);
        }
    }

    public function comisiones_post()
    {
        $json = $this->post('data');
        $entity = $this->json_to_entity($json);
        $result = $this->ComicionDAO->insert($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
    }

    public function comisiones_put()
    {
        $json = $this->put('data');
        $entity = $this->json_to_entity($json);
        $result = $this->ComicionDAO->update($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
    }

    public function comisiones_delete($id)
    {
        $comicion = $this->ComicionDAO->query(['id' => $id], [], [])[0];
        if($comicion == null)
            $this->response(['error' => 'Comision inexistente'], 404);
        $result = $this->ComicionDAO->delete($comicion);
        if (is_array($result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }

    }
}