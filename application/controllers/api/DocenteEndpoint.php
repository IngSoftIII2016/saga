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
class DocenteEndpoint extends BaseEndpoint
{

	function __construct()
	{

		// Construct the parent class
		parent::__construct('Docente');
		$this->load->model('DocenteDAO');

	}

	/**
	 * @param $id
	 */
	public function docentes_get($id = null)
	{
		if ($id != null) {
			$docente = $this->DocenteDAO->query(['id' => $id], [], [])[0];
			$this->response(['data' => $docente]);
		} else {
			$params = $this->parse_params();
			$docentes = $this->DocenteDAO->query($params['filters'], $params['sorts'], $params['includes'], $params['page'], $params['size']);
			$this->response(['data' => $docentes]);
		}
	}

	public function docentes_post()
	{
		$json = $this->post('data');
		$entity = $this->json_to_entity($json);
		$result = $this->DocenteDAO->insert($entity);
		if (array_key_exists('error', $result)) {
			$this->response($result, 500);
		}else {
			$this->response(['data' => $result]);
		}
	}

	public function docentes_put()
	{
		$json = $this->put('data');
		$entity = $this->json_to_entity($json);
		$result = $this->DocenteDAO->update($entity);
		if (array_key_exists('error', $result)) {
			$this->response($result, 500);
		}else {
			$this->response(['data' => $result]);
		}
	}

	public function docentes_delete($id)
	{
		$docente = $this->DocenteDAO->query(['id' => $id], [], [])[0];
		if($docente == null)
			$this->response(['error' => 'Docente inexistente'], 404);
			$result = $this->DocenteDAO->delete($docente);
			if (is_array($result)) {
				$this->response($result, 500);
			}else {
				$this->response(['data' => $result]);
			}

	}


}