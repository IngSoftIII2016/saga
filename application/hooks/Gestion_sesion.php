<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Gestion_sesion {
	private $ci;
 public function __construct()
 {
 $this->ci =& get_instance();
 !$this->ci->load->library(array('ion_auth','form_validation')) ? $this->ci->load->library(array('ion_auth','form_validation')) : false;
 }

   function index(){
	   
	 if(!$this->ci->ion_auth->logged_in() && $this->ci->uri->segment(1) != 'login'){
        	redirect(base_url('login'));
        }
		 elseif ($this->ci->ion_auth->logged_in() ){
				$user = $this->ci->ion_auth->user()->row();
				$user_active = $user->active;
		
				if ($user_active==0){
					$this->ci->session->set_flashdata('message', $this->ci->ion_auth->messages());
					$logout = $this->ci->ion_auth->logout();
					redirect('login', 'refresh');
				}	

				if(!$this->ci->ion_auth->is_admin()) {
				    //El acceso permitido para el bedel.
					$controlador = $this->ci->router->class;
					$controladores_permitidos = array('planilla','horario','login');

			    if(!in_array($controlador,$controladores_permitidos)){
					$message='Usted debe ser administrador para acceder a esta pagina. <a href="'.$this->ci->config->config['base_url'].'" >Ir a la planilla</a>';
					return show_error($message,500, $heading = 'Restricción de acceso'); 
				 }
			}
		}
	  
   }
}
