<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

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
class Clase extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

    }

    public function index($id){
        var_dump($id);
    }



    public function index_get($id)
    {
        $this->response(['data' => $this->get()]);
        die();

        if(isset($id)){
            $this->load->model('Clase_model');
            $clase = $this->Clase_model->get_clase($id);
            $this->response(['data' => $clase]);
        }else {
            $this->load->model('Clase_model');
            $clases = $this->Clase_model->get_clases();
            $this->response(['data' => $clases]);
        }
    }


    
    

}
