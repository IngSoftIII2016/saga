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
class TipoRecursoEndpoint extends BaseEndpoint
{

	function __construct()
	{

		// Construct the parent class
		parent::__construct('TipoRecurso');
		$this->load->model('TipoRecursoDAO');

	}

	/**
	 * @param $id
	 */
	public function tiporecursos_get($id = null)
	{
		if ($id != null) {
			$recurso = $this->TipoRecursoDAO->query(['id' => $id], [], [])[0];
			$this->response(['data' => $recurso]);
		} else {
			$params = $this->parse_params();
			$recursos = $this->TipoRecursoDAO->query($params['filters'], $params['sorts'], $params['includes'], $params['page'], $params['size']);
			$this->response(['data' => $recursos]);
		}
	}

	public function tiporecursos_post()
	{
		$json = $this->post('data');
		$entity = $this->json_to_entity($json);
		$result = $this->TipoRecursoDAO->insert($entity);
		if (array_key_exists('error', $result)) {
			$this->response($result, 500);
		}else {
			$this->response(['data' => $result]);
		}
	}

	public function tiporecursos_put()
	{
		$json = $this->put('data');
		$entity = $this->json_to_entity($json);
		$result = $this->TipoRecursoDAO->update($entity);
		if (array_key_exists('error', $result)) {
			$this->response($result, 500);
		}else {
			$this->response(['data' => $result]);
		}
	}

	public function tiporecursos_delete($id)
	{
		$recurso = $this->TipoRecursoDAO->query(['id' => $id], [], [])[0];
		if($recurso == null)
			$this->response(['error' => 'Tipo de recurso inexistente'], 404);
			$result = $this->TipoRecursoDAO->delete($recurso);
			if (is_array($result)) {
				$this->response($result, 500);
			}else {
				$this->response(['data' => $result]);
			}

	}


}