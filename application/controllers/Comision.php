<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 27/09/16
 * Time: 19:07
 */
class Comision extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
}