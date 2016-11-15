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
class LocalidadEndpoint extends BaseEndpoint
{

	function __construct()
	{
		// Construct the parent class
		parent::__construct('Localidad');
		$this->load->model('LocalidadDAO');

	}

	protected  function getDAO()
    {
        return $this->LocalidadDAO;
    }

    /**
	 * @param $id
	 */
	public function localidades_get($id = null)
	{
		if ($id != null) {
			$localidad = $this->LocalidadDAO->query(['id' => $id], [], [])[0];
			$this->response(['data' => $localidad]);
		} else {
			$params = $this->parse_params();
			$localidades = $this->LocalidadDAO->query($params['filters'], $params['sorts'], $params['includes'], $params['page'], $params['size']);
			$this->response(['data' => $localidades]);
		}
	}

	public function localidades_post()
	{
		$json = $this->post('data');
		$entity = $this->json_to_entity($json);
		$result = $this->LocalidadDAO->insert($entity);
		if (array_key_exists('error', $result)) {
			$this->response($result, 500);
		}else {
			$this->response(['data' => $result]);
		}
	}

	public function localidades_put()
	{
		$json = $this->put('data');
		$entity = $this->json_to_entity($json);
		$result = $this->LocalidadDAO->update($entity);
		if (array_key_exists('error', $result)) {
			$this->response($result, 500);
		}else {
			$this->response(['data' => $result]);
		}
	}

	public function localidades_delete($id)
	{
		$localidad = $this->LocalidadDAO->query(['id' => $id], [], [])[0];
		if($localidad == null)
			$this->response(['error' => 'Localidad inexistente'], 404);
			$result = $this->LocalidadDAO->delete($localidad);
			if (is_array($result)) {
				$this->response($result, 500);
			}else {
				$this->response(['data' => $result]);
			}

	}


}