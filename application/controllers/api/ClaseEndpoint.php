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
class ClaseEndpoint extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

    }

    public function index($id){
        var_dump($id);
    }


    /**
     * @param $id
     */
    public function clases_get ($id=null)
    {
        $params = $this->get();
        $this->load->model('Clase_model');
        if($id!=null)
            $clases = $this->Clase_model->get_clase($id);
        elseif(count(array_keys($params)) > 0)
            $clases = $this->Clase_model->get_by_filters($params);
        else
            $clases = $this->Clase_model->get_by_filters();

        $this->response(['data' => $clases]);
    }


    


}
