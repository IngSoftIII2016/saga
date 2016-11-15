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
class EdificioEndpoint extends BaseEndpoint
{

	function __construct()
	{

		// Construct the parent class
		parent::__construct('Edificio');
		$this->load->model('EdificioDAO');

	}

	protected  function getDAO()
    {
        return $this->EdificioDAO;
    }

    /**
	 * @param $id
	 */
	public function edificios_get($id = null)
	{
		if ($id != null) {
			$edificio = $this->EdificioDAO->query(['id' => $id], [], [])[0];
			$this->response(['data' => $edificio]);
		} else {
			$params = $this->parse_params();
			$edificios = $this->EdificioDAO->query($params['filters'], $params['sorts'], $params['includes'], $params['page'], $params['size']);
			$this->response(['data' => $edificios]);
		}
	}

	public function edificios_post()
	{
		$json = $this->post('data');
		$entity = $this->json_to_entity($json);
		$result = $this->EdificioDAO->insert($entity);
		if (array_key_exists('error', $result)) {
			$this->response($result, 500);
		}else {
			$this->response(['data' => $result]);
		}
	}

	public function edificios_put()
	{
		$json = $this->put('data');
		$entity = $this->json_to_entity($json);
		$result = $this->EdificioDAO->update($entity);
		if (array_key_exists('error', $result)) {
			$this->response($result, 500);
		}else {
			$this->response(['data' => $result]);
		}
	}

	public function edificios_delete($id)
	{
		$edificio = $this->EdificioDAO->query(['id' => $id], [], [])[0];
		if($edificio == null)
			$this->response(['error' => 'Edificio inexistente'], 404);
			$result = $this->EdificioDAO->delete($edificio);
			if (is_array($result)) {
				$this->response($result, 500);
			}else {
				$this->response(['data' => $result]);
			}

	}


}