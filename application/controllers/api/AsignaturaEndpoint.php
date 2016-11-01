<?php
require_once APPPATH . '/controllers/api/BaseEndpoint.php';

class AsignaturaEndpoint extends BaseEndpoint
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct('Asignatura');
        $this->load->model('AsignaturaDAO');
    }

    /**
     * @param $id
     */
    public function asignatura_get($id = null)
    {
        if ($id != null) {
            $asignatura = $this->AsignaturaDAO->query(['id' => $id], [], [])[0];
            $this->response(['data' => $asignatura]);
        } else {
            $params = $this->parse_params();
            $asignatura = $this->AsignaturaDAO->query($params['filters'], $params['sorts'], $params['includes'], $params['page'], $params['size']);
            $this->response(['data' => $asignatura]);
        }
    }

    public function asignatura_post()
    {
        $json = $this->post('data');
        $entity = $this->json_to_entity($json);
        $result = $this->AsignaturaDAO->insert($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
    }

    public function asignatura_put()
    {
        $json = $this->put('data');
        $entity = $this->json_to_entity($json);
        $result = $this->AsignaturaDAO->update($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
    }

    public function asignatura_delete($id)
    {
        $asignatura = $this->AsignaturaDAO->query(['id' => $id], [], [])[0];
        if($asignatura == null)
            $this->response(['error' => 'Recurso inexistente'], 404);
        $result = $this->AsignaturaDAO->delete($asignatura);
        if (is_array($result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }

    }
}