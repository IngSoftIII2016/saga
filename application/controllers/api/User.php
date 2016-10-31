<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login() {
        $data = $this->input->post();
        echo json_encode(array('errors' => 'no logged!', 'data' => $data));
        /*
        $remember = $data['remember'];
        $user = $data['user'];
        $password = $data['password'];
        $this->load->model('Login_Model');

        if($this->Login_Model->login($user, $password, $remember)){
            $this->session->set_flashdata('message', $this->Login_Model->messages());
            echo json_encode(array('sucess'=> 'logged in!'));
        }else{
            echo json_encode(array('errors' => 'no logged!', 'data' => $data));
        }
        */
    }

}