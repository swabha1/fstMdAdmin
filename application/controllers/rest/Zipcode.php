<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
class Zipcode extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        //$this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        //$this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        //$this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }
    
     public function zipcode_post(){
        $this->load->library('form_validation');
                // Validate The Logi User
                $this->form_validation->set_rules('zipcode', 'Zip/Area Code',  'trim|required'); 
               
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
        		}else
                {
                   
                    $q = $this->db->query("Select * from `zipcode` where zipcode='".$this->post('zipcode')."' Limit 1");
                    if ($q->num_rows() > 0)
                    {
                        $row = $q->row();  
                            $this->response(array(
                            RESPONCE => true,
                                        DATA => $row
                                       
                                    ), REST_Controller::HTTP_OK); 
                            
                        
                    }
                    else
                    {
                        $row = $q->row(); 
                        $this->response(array(
                                       RESPONCE => false,
                                        MESSAGE => "Sorry! Delivery not available to this Zip/Area code."
                                    ), REST_Controller::HTTP_OK); 
                    }
                   
                    
                }
    } 
}
?>