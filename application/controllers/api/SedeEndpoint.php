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
class SedeEndpoint extends BaseEndpoint
{

	function __construct()
	{

		// Construct the parent class
		parent::__construct('Sede');
		$this->load->model('SedeDAO');

	}

	protected  function getDAO()
    {
        return $this->SedeDAO;
    }

    /**
	 * @param $id
	 */
	public function sedes_get($id = null)
	{
		if ($id != null) {
			$sede = $this->SedeDAO->query(['id' => $id], [], [])[0];
			$this->response(['data' => $sede]);
		} else {
			$params = $this->parse_params();
			$sedes = $this->SedeDAO->query($params['filters'], $params['sorts'], $params['includes'], $params['page'], $params['size']);
			$this->response(['data' => $sedes]);
		}
	}

	public function sedes_post()
	{
		$json = $this->post('data');
		$entity = $this->json_to_entity($json);
		$result = $this->SedeDAO->insert($entity);
		if (array_key_exists('error', $result)) {
			$this->response($result, 500);
		}else {
			$this->response(['data' => $result]);
		}
	}

	public function sedes_put()
	{
		$json = $this->put('data');
		$entity = $this->json_to_entity($json);
		$result = $this->SedeDAO->update($entity);
		if (array_key_exists('error', $result)) {
			$this->response($result, 500);
		}else {
			$this->response(['data' => $result]);
		}
	}

	public function sedes_delete($id)
	{
		$sede = $this->SedeDAO->query(['id' => $id], [], [])[0];
		if($sede == null)
			$this->response(['error' => 'Sede inexistente'], 404);
			$result = $this->SedeDAO->delete($sede);
			if (is_array($result)) {
				$this->response($result, 500);
			}else {
				$this->response(['data' => $result]);
			}

	}


}