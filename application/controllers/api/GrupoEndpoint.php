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
class GrupoEndpoint extends BaseEndpoint
{

	function __construct()
	{

		// Construct the parent class
		parent::__construct('Grupo');
		$this->load->model('GrupoDAO');

	}

	protected  function getDAO()
    {
        return $this->GrupoDAO;
    }

    /**
	 * @param $id
	 */
	public function grupos_get($id = null)
	{
		if ($id != null) {
			$grupo = $this->GrupoDAO->query(['id' => $id], [], [])[0];
			$this->response(['data' => $grupo]);
		} else {
			$params = $this->parse_params();
			$grupos = $this->GrupoDAO->query($params['filters'], $params['sorts'], $params['includes'], $params['page'], $params['size']);
			$this->response(['data' => $grupos]);
		}
	}

	public function grupos_post()
	{
		$json = $this->post('data');
		$entity = $this->json_to_entity($json);
		$result = $this->GrupoDAO->insert($entity);
		if (array_key_exists('error', $result)) {
			$this->response($result, 500);
		}else {
			$this->response(['data' => $result]);
		}
	}

	public function grupos_put()
	{
		$json = $this->put('data');
		$entity = $this->json_to_entity($json);
		$result = $this->GrupoDAO->update($entity);
		if (array_key_exists('error', $result)) {
			$this->response($result, 500);
		}else {
			$this->response(['data' => $result]);
		}
	}

	public function grupos_delete($id)
	{
		$grupo = $this->GrupoDAO->query(['id' => $id], [], [])[0];
		if($grupo == null)
			$this->response(['error' => 'Grupo inexistente'], 404);
			$result = $this->GrupoDAO->delete($grupo);
			if (is_array($result)) {
				$this->response($result, 500);
			}else {
				$this->response(['data' => $result]);
			}

	}


}