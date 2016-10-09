<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();

        $this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		$this->load->library('session');

        $this->load->library('grocery_CRUD');
    }


	 public function index()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('usuario');
		$crud->set_subject('Usuario');

		$crud->set_relation_n_n('grupos', 'usuario_grupo', 'grupo', 'user_id', 'group_id', 'name');

		//las columnas de la vista principal
		$crud->columns('username','email','active','grupos');

		// para editar
		
		$user_id = $this->session->userdata('user_id');

		 
		if ($user_id ==$this->uri->segment(4)){
			$crud->edit_fields('first_name', 'last_name','phone','grupos');
		}
		else{
		$crud->edit_fields('first_name', 'last_name','phone','active','grupos');
		}
		// campos obligatorios
		$crud->required_fields ('first_name','last_name','password' , 'email', 'active' ,'password_confirm' );
		//reasignacion de nombres
		$crud->display_as('username','Usuario');
		$crud->display_as('password','Contraseña');
		$crud->display_as('active','Estado');
		$crud->display_as('first_name','Nombre');
		$crud->display_as('last_name','Apellido');
		$crud->display_as('phone','Telefono');
		$crud->display_as('password','Contraseña');
		$crud->display_as('password_confirm','Confirmar contraseña');
		//validaciones
		$crud->set_rules('password', 'Password', 'required|matches[password_confirm]');
		$crud->set_rules('email', 'E-mail', 'required|valid_email');
		$crud->set_rules('phone', 'telefono', 'numeric|min_length[6]');
		
		//para añadir

		$crud->add_fields('first_name', 'last_name', 'email','grupos', 'phone','password','password_confirm');

		// cambiar el tipo
		$crud->change_field_type ( 'password' , 'password' );
		$crud->change_field_type ( 'password_confirm' , 'password' );

		//no mostrar en ver usuario
		$crud->unset_read_fields('first_name', 'last_name','id','ip_address','salt','activation_code','forgotten_password_code','password_confirm','active','remember_code','last_login','created_on','password','forgotten_password_time','company');
		//validacion: verifica que no halla dos emails
		$crud->set_rules('email', 'E-mail', 'callback_email_check');

		//callbacks
		$crud->callback_insert (array($this, 'create_user_callback'));
		$crud->callback_update(array($this, 'edit_user_callback'));    
		$crud->callback_before_delete(array($this,'cek_before_delete'));
		
		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/")));
		
		$output = $crud->render();
        $this->load->view('vacia.php',$output);

    }
	
	
	
	// Verifica que no halla dos emails iguales
	public function email_check($str) {
		if ( $this->ion_auth_model->identity_column == 'email' && $this->ion_auth_model->email_check($str, $str['email']) == true) {
			$this->form_validation->set_message('email_check',  'El email ya se encuentra registrado');
			return false;
		} else {
			
			return true;
		}
	}

	function create_user_callback($post_array, $primary_key = null) {
		$username = $post_array['first_name'] . ' ' . $post_array['last_name'];
		$password = $post_array['password'];
		$email = $post_array['email'];
		$groups  = $post_array['grupos'];
		$data = array(
		'phone' => $post_array['phone'],
		'first_name' => $post_array['first_name'],
		'last_name' => $post_array['last_name']
		);
	
		return $this->ion_auth_model->register($username, $password, $email, $data,$groups );
	}

	
	function edit_user_callback($post_array, $primary_key = null) {
		$username = $post_array['first_name'] . ' ' . $post_array['last_name'];
		$groups   = $post_array['grupos'];
		$data = array(
		'username' => $username,
		'phone' => $post_array['phone'],
		'first_name' => $post_array['first_name'],
		'last_name' => $post_array['last_name'],
		'active' => $post_array['active']
		);
		$grupo =1;
		$user_id = $this->session->userdata('user_id');
		if ($primary_key==$user_id  ){
				$data = array(
				'username' => $username,
				'phone' => $post_array['phone'],
				'first_name' => $post_array['first_name'],
				'last_name' => $post_array['last_name']
				);
			if (!in_array($grupo,$groups)){
				return false;
			}
		}
	
		$this->ion_auth_model->update($primary_key, $data);
		if ($groups){
		$this->ion_auth_model->remove_from_group('', $primary_key);
		$this->ion_auth_model->add_to_group($groups, $primary_key);
		}
		return true;
		
	}
	
	function cek_before_delete($primary_key) {
         $user_id = $this->session->userdata('user_id');

        if ($primary_key ==  $user_id ) {
            return false;
        } else {
            return true;
        }
    }
	 

	

}
