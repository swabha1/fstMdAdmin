<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
class Categories extends REST_Controller {

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
    
     public function list_medical_categories_post(){
        $categories_list =  $this->category_model->get_medical_product_categories();
            if($categories_list){
                $this->response(array(
                RESPONCE => true,"data"=>$categories_list), REST_Controller::HTTP_OK);
           } 
    } 
     public function list_prescriptions_categories_post(){
        $categories_prescriptions_list =  $this->category_model->get_prescriptions_categories();
            if($categories_prescriptions_list){
                $this->response(array(
                RESPONCE => true,"data"=>$categories_prescriptions_list), REST_Controller::HTTP_OK);
           } 
    } 
}
?>