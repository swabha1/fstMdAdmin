<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
class Product extends REST_Controller {

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
    
    public function list_post(){
                 $this->load->model("product_model");
                $cat_id = "";
                if($this->input->post("cat_id")){
                    $cat_id = $this->input->post("cat_id");
                }
              $search= $this->input->post("search");
                
                
                
                $this->response(array(
                RESPONCE => true,"data"=>$this->product_model->get_products(false,$cat_id,$search,$this->input->post("page"))), REST_Controller::HTTP_OK);
                
    } 
    
     public function suggest_post(){  
                $suggest = $this->product_model->get_suggest_products(); 
                $this->response(array(
                RESPONCE => true,"data"=>$suggest), REST_Controller::HTTP_OK);
                
    }
    
     public function suggest_details_page_post(){  
                $cat_id = $this->input->post("cat_id");
                $suggest_details = $this->product_model->get_suggest_details_page_products($cat_id); 
                $this->response(array(
                RESPONCE => true,"data"=>$suggest_details), REST_Controller::HTTP_OK);
                
        } 
     
}
?>