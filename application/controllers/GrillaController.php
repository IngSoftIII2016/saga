<?php
class Grilla_Controler extends CI_Controller {
	
	function index() {
		$this->load->model("clasemodel");
		echo $this->math_model->get_clases();
	}
	
	
	
}