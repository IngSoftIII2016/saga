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
		$this->headers = apache_request_headers();
	}

	protected  function getDAO()
    {
        return $this->DocenteDAO;
    }

    /**
	 * @param $id
	 */
	public function docentes_get($id = null)
	{
        $this->base_get($id);
	}

	public function docentes_post()
	{
        $this->base_post();
	}

	public function docentes_put()
	{
        $this->base_put();
	}

	public function docentes_delete($id)
	{
        $this->base_delete($id);
	}
}