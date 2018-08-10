<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
class Offer extends REST_Controller {

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
                 $offer_list =  $this->offer_model->get_offer();
                
                $this->response(array(
                RESPONCE => true,"data"=>$offer_list), REST_Controller::HTTP_OK);
                
        } 
         
      public function offer_check_post(){
         $this->load->library('form_validation');
                // Validate The Logi User
                $this->form_validation->set_rules('offer_coupon', 'Offer Coupon',  'trim|required');
                $this->form_validation->set_rules('user_id', 'user id', 'trim|required');
               
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
        		}else
                {
                   
                    $user_found = $this->db->query("Select * from `users` where user_id='".$this->post('user_id')."' Limit 1");
                     if ($user_found->num_rows() > 0)
                   {
                            $q = $this->db->query("Select * from `offer` where offer_coupon='".$this->post('offer_coupon')."' Limit 1");
                             $row = $q->row(); 
                            if ($q->num_rows() > 0)
                            {  
                                 $user_check = $this->db->query("Select * from `sale` where offer_coupon='".$this->post('offer_coupon')."' and user_id='".$this->post('user_id')."' Limit 1");
                                 if($user_check->num_rows() > 0)
                                {
                                    $this->response(array(
                                                RESPONCE => false,
                                                MESSAGE => "This coupon code alredy used."
                                            ), REST_Controller::HTTP_OK); 
                                    
                                }  
                                else
                                {
                                       
                                            
                                      $this->response(array(
                                        RESPONCE => true,"data"=>array(
                                        "offer_id"=>$row->offer_id,
                                        "offer_title"=>$row->offer_title, 
                                        "offer_coupon"=>$row->offer_coupon,
                                        "offer_discount"=>$row->offer_discount)), REST_Controller::HTTP_OK);
                                }
                            }
                            else
                            {
                                $this->response(array(
                                                RESPONCE => false,
                                                MESSAGE => "Invalide Offer Code"
                                            ), REST_Controller::HTTP_OK); 
                            }   
                   } else
                            {
                                $this->response(array(
                                                RESPONCE => false,
                                                MESSAGE => "User Not found in our system"
                                            ), REST_Controller::HTTP_OK); 
                            }   
                    
                }
    }
}
?>