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
/*        if ($id != null) {
            $asignatura = $this->AsignaturaDAO->query(['id' => $id], [], [])[0];
            $this->response(['data' => $asignatura]);
        } else {
            $params = $this->parse_params();
            $asignaturas = $this->AsignaturaDAO->query($params['filters'], $params['sorts'], $params['includes'], $params['page'], $params['size']);
            $this->response(['data' => $asignaturas]);
        }
*/
        $this->base_get($id);
    }

    public function asignaturas_post()
    {
        /*
        $json = $this->post('data');
        $entity = $this->json_to_entity($json);
        $result = $this->AsignaturaDAO->insert($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
        */
        $this->base_post();
    }

    public function asignaturas_put()
    {
        /*
        $json = $this->put('data');
        $entity = $this->json_to_entity($json);
        $result = $this->AsignaturaDAO->update($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
        */
        $this->base_put();
    }

    public function asignaturas_delete($id)
    {
        /*
        $asignatura = $this->AsignaturaDAO->query(['id' => $id], [], [])[0];
        if($asignatura == null)
            $this->response(['error' => 'Asignatura inexistente'], 404);
        $result = $this->AsignaturaDAO->delete($asignatura);
        if (is_array($result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
        */
        $this->base_delete($id);
    }
}