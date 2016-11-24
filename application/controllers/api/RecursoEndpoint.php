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
class RecursoEndpoint extends BaseEndpoint
{

	function __construct()
	{

		// Construct the parent class
		parent::__construct('Recurso');
		$this->load->model('RecursoDAO');

	}

	protected  function getDAO()
    {
        return $this->RecursoDAO;
    }

    /**
	 * @param $id
	 */
	public function recursos_get($id = null)
	{
        $this->base_get($id);
	}

	public function recursos_post()
	{
        $this->base_post();
	}

	public function recursos_put()
	{
        $this->base_put();
	}

	public function recursos_delete($id)
	{
        $this->base_delete($id);
	}
}