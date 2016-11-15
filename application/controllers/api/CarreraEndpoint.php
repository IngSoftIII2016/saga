<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require_once APPPATH . '/controllers/api/BaseEndpoint.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class CarreraEndpoint extends BaseEndpoint
{

	function __construct()
	{

		// Construct the parent class
		parent::__construct('Carrera');
		$this->load->model('CarreraDAO');

	}

	protected function getDAO()
    {
        return $this->CarreraDAO;
    }

    /**
	 * @param $id
	 */
	public function carreras_get($id = null)
	{
	    /*
		if ($id != null) {
			$carrera = $this->CarreraDAO->query(['id' => $id], [], [])[0];
			$this->response(['data' => $carrera]);
		} else {
			$params = $this->parse_params();
			$carreras = $this->CarreraDAO->query($params['filters'], $params['sorts'], $params['includes'], $params['page'], $params['size']);
			$this->response(['data' => $carreras]);
		}
	    */
        $this->base_get($id);
	}

	public function carreras_post()
	{
	    /*
		$json = $this->post('data');
		$entity = $this->json_to_entity($json);
		$result = $this->CarreraDAO->insert($entity);
		if (array_key_exists('error', $result)) {
			$this->response($result, 500);
		}else {
			$this->response(['data' => $result]);
		}
	    */
        $this->base_post();
	}

	public function carreras_put()
	{
	    /*
		$json = $this->put('data');
		$entity = $this->json_to_entity($json);
		$result = $this->CarreraDAO->update($entity);
		if (array_key_exists('error', $result)) {
			$this->response($result, 500);
		}else {
			$this->response(['data' => $result]);
		}
	    */
        $this->base_put();
	}

	public function carreras_delete($id)
	{
	    /*
		$carrera = $this->CarreraDAO->query(['id' => $id], [], [])[0];
		if($carrera == null)
			$this->response(['error' => 'Carrera inexistente'], 404);
			$result = $this->CarreraDAO->delete($carrera);
			if (is_array($result)) {
				$this->response($result, 500);
			}else {
				$this->response(['data' => $result]);
			}
	    */
        $this->base_delete($id);
	}


}