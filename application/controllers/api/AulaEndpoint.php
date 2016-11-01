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

    /**
     * @param $id
     */
    public function aula_get($id = null)
    {
        if ($id != null) {
            $aula = $this->AulaDAO->query(['id' => $id], [], [])[0];
            $this->response(['data' => $aula]);
        } else {
            $params = $this->parse_params();
            $aula = $this->AulaDAO->query($params['filters'], $params['sorts'], $params['includes'], $params['page'], $params['size']);
            $this->response(['data' => $aula]);
        }
    }

    public function aula_post()
    {
        $json = $this->post('data');
        $entity = $this->json_to_entity($json);
        $result = $this->AulaDAO->insert($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
    }

    public function aula_put()
    {
        $json = $this->put('data');
        $entity = $this->json_to_entity($json);
        $result = $this->AulaDAO->update($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
    }

    public function aula_delete($id)
    {
        $aula = $this->AulaDAO->query(['id' => $id], [], [])[0];
        if($aula == null)
            $this->response(['error' => 'Recurso inexistente'], 404);
        $result = $this->AulaDAO->delete($aula);
        if (is_array($result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }

    }
}