<?php
require_once APPPATH . '/controllers/api/BaseEndpoint.php';

class ComicionEndpoint extends BaseEndpoint
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct('Comicion');
        $this->load->model('ComicionDAO');
    }

    /**
     * @param $id
     */
    public function comiciones_get($id = null)
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

    public function comiciones_post()
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

    public function comiciones_put()
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

    public function comiciones_delete($id)
    {
        $comicion = $this->ComicionDAO->query(['id' => $id], [], [])[0];
        if($comicion == null)
            $this->response(['error' => 'Recurso inexistente'], 404);
        $result = $this->ComicionDAO->delete($comicion);
        if (is_array($result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }

    }
}