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
class PeriodoEndpoint extends BaseEndpoint
{

	function __construct()
	{

		// Construct the parent class
		parent::__construct('Periodo');
		$this->load->model('PeriodoDAO');

	}

	protected  function getDAO()
    {
        return $this->PeriodoDAO;
    }

    /**
	 * @param $id
	 */
	public function periodos_get($id = null)
	{
		if ($id != null) {
			$periodo = $this->PeriodoDAO->query(['id' => $id], [], [])[0];
			$this->response(['data' => $periodo]);
		} else {
			$params = $this->parse_params();
			$periodos = $this->PeriodoDAO->query($params['filters'], $params['sorts'], $params['includes'], $params['page'], $params['size']);
			$this->response(['data' => $periodos]);
		}
	}

	public function periodos_post()
	{
		$json = $this->post('data');
		$entity = $this->json_to_entity($json);
		$result = $this->PeriodoDAO->insert($entity);
		if (array_key_exists('error', $result)) {
			$this->response($result, 500);
		}else {
			$this->response(['data' => $result]);
		}
	}

	public function periodos_put()
	{
		$json = $this->put('data');
		$entity = $this->json_to_entity($json);
		$result = $this->PeriodoDAO->update($entity);
		if (array_key_exists('error', $result)) {
			$this->response($result, 500);
		}else {
			$this->response(['data' => $result]);
		}
	}

	public function periodos_delete($id)
	{
		$periodo = $this->PeriodoDAO->query(['id' => $id], [], [])[0];
		if($periodo == null)
			$this->response(['error' => 'Periodo inexistente'], 404);
			$result = $this->PeriodoDAO->delete($periodo);
			if (is_array($result)) {
				$this->response($result, 500);
			}else {
				$this->response(['data' => $result]);
			}

	}


}