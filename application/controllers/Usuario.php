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
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->library('grocery_CRUD');
    }


	 public function index()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('usuario');
		$crud->set_subject('Usuario');

		$crud->set_relation_n_n('grupos', 'usuario_grupo', 'grupo', 'usuario_id', 'grupo_id', 'nombre');

		//las columnas de la vista principal
		$crud->columns('nombre_usuario','email','estado','grupos');

		// para editar

		$user_id = $this->session->userdata('user_id');


		if ($user_id ==$this->uri->segment(4)){
			$crud->edit_fields('nombre', 'apellido','telefono','grupos');
		}
		else{
		$crud->edit_fields('nombre', 'apellido','telefono','estado','grupos');
		}
		// campos obligatorios
		$crud->required_fields ('nombre','apellido','contraseña' , 'email','confirmar_contraseña' );

		//para añadir
		$crud->add_fields('nombre', 'apellido', 'email','grupos', 'telefono','contraseña','confirmar_contraseña');

        //validaciones
        $crud->set_rules('contraseña', 'Constraseña', 'required|matches[confirmar_contraseña]');
        $crud->set_rules('telefono', 'Telefono','numeric|min_length[6]');

		// cambiar el tipo
		$crud->change_field_type ( 'contraseña' , 'password' );
		$crud->change_field_type ( 'confirmar_contraseña' , 'password' );

		//no mostrar en ver usuario
		$crud->unset_read_fields('nombre', 'apellido','id','contraseña','estado','confirmar_contraseña', 'recordarme_codigo');
		//validacion: verifica que no halla dos emails
		$crud->set_rules('email', 'Email', 'required|valid_email|callback_email_check');

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
		$username = $post_array['nombre'] . ' ' . $post_array['apellido'];
		$password = $post_array['contraseña'];
		$email = $post_array['email'];
		$groups  = $post_array['grupos'];
		$data = array(
		'telefono' => $post_array['telefono'],
		'nombre' => $post_array['nombre'],
		'apellido' => $post_array['apellido']
		);
	
		return $this->ion_auth_model->register($username, $password, $email, $data,$groups );
	}

	
	function edit_user_callback($post_array, $primary_key = null) {
		$username = $post_array['nombre'] . ' ' . $post_array['apellido'];
		$groups   = $post_array['grupos'];
		$data = array(
		'nombre_usuario' => $username,
		'telefono' => $post_array['telefono'],
		'nombre' => $post_array['nombre'],
		'apellido' => $post_array['apellido'],
		'estado' => $post_array['estado']
		);
		$grupo =1;
		$user_id = $this->session->userdata('user_id');
		if ($primary_key==$user_id  ){
				$data = array(
				'nombre_usuario' => $username,
				'telefono' => $post_array['telefono'],
				'nombre' => $post_array['nombre'],
				'apellido' => $post_array['apellido']
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

    public  function cambiar_contrasena(){
        $this->data['body'] = 'cambiar_contrasena';
        $this->data['data'] = "";
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in())
        {
            redirect('login/index', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false)
        {
            //display the form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id'   => 'old',
                'type' => 'password',
            );
            $this->data['new_password'] = array(
                'name' => 'new',
                'id'   => 'new',
                'type' => 'password',
                'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id'   => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );
            $this->data['user_id'] = array(
                'name'  => 'user_id',
                'id'    => 'user_id',
                'type'  => 'hidden',
                'value' => $user->id,
            );

            //render
            $this->load->view('templates/base',  $this->data);

          //  $this->_render_page('cambiar_contrasena', $this->data);
        }
        else
        {
            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change)
            {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
               // $this->logout();
                redirect('usuario/cambiar_contrasena', 'refresh');

            }
            else
            {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('usuario/cambiar_contrasena', 'refresh');
            }
        }

    }
    function _render_page($view, $data=null, $render=false)
    {
        $this->viewdata = (empty($data)) ? $this->data: $data;
        $view_html = $this->load->view($view, $this->viewdata, $render);
        if (!$render) return $view_html;
    }
	

}
