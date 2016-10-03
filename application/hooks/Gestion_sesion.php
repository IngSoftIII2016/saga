<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Gestion_sesion {
	private $ci;
 public function __construct()
 {
 $this->ci =& get_instance();
 !$this->ci->load->library(array('ion_auth','form_validation')) ? $this->ci->load->library(array('ion_auth','form_validation')) : false;
 }

   function index(){

	 if(!$this->ci->ion_auth->logged_in() && $this->ci->uri->segment(1) != 'login')
        {
        	redirect(base_url('login'));
        }
	  
   }
}
