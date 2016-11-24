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
        $this->base_get($id);
	}

	public function edificios_post()
	{
        $this->base_post();
	}

	public function edificios_put()
	{
        $this->base_put();
	}

	public function edificios_delete($id)
	{
        $this->base_delete($id);
	}
}