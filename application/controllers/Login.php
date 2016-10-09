<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
	}

		     //Registrar el usuario en
	function index()
	{
		$this->data['title'] = "Login";

			// Validar la entrada del formulario
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{
			// Comprobar para ver si el usuario se está conectando
			// Comprobar si hay " recuérdame "

			$remember = (bool) $this->input->post('remember');
			$this->load->model('Login_Model');


			if ($this->Login_Model->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				// Si el inicio de sesión se realiza correctamente
				// Redirigirlos volver a la página principal

				$this->session->set_flashdata('message', $this->Login_Model->messages());
				redirect('planilla', 'refresh');
			}
			else
			{
				// Si la entrada era un- éxito
				// Redirigirlos volver a la página de inicio de sesión

				$this->session->set_flashdata('message', $this->Login_Model->errors());
				redirect('login', 'refresh'); 
				//  se redirecciona en lugar de puntos de vista de carga para la compatibilidad con bibliotecas MY_Controller			
			}
		}
		else
		{
			// El usuario no está registrando en la que aparezca la página de inicio de sesión
			// Establecer el mensaje de error de datos flash si hay uno

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);
			
			if ($this->ion_auth->logged_in())
				//si esta logeado entonces no se podra ir de nuevo al login...
				redirect('planilla', 'refresh');
			else
				$this->_render_page('login', $this->data);

		}
	}

	//log the user out
	function salir()
	{
		$this->data['title'] = "Logout";

		//log the user out
		$logout = $this->ion_auth->logout();

		//redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('login', 'refresh');
	}


	function _render_page($view, $data=null, $render=false)
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $render);

		if (!$render) return $view_html;
	}

}
