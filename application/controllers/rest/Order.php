<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
class Order extends REST_Controller {

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
    
   function send_order_post(){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                $this->form_validation->set_rules('payment_type', 'Payment Type',  'trim|required');  
                $this->form_validation->set_rules('data', 'data',  'trim|required');
                $this->form_validation->set_rules('delivery_id', 'Delivery',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
                    
        		}else
                {
                     $ld = $this->db->query("select user_delivery_address.*, zipcode.delivery_charge from user_delivery_address
                    inner join zipcode on zipcode.zipcode = user_delivery_address.delivery_zipcode
                     where user_delivery_address.delivery_id = '".$this->input->post("delivery_id")."' limit 1");
                    $location = $ld->row(); 
                    
                    $user_id = $this->input->post("user_id");
                    $payment_type = $this->input->post("payment_type");
                    $payment_ref = $this->input->post("payment_ref");
                    $payment_paypal_amount = $this->input->post("payment_paypal_amount"); 
                    $offer_coupon = $this->input->post("offer_coupon");
                    
                    $insert_array = array("user_id"=>$user_id,  
                    "delivery_id"=>$this->input->post("delivery_id"), 
                    "payment_type" => $payment_type,
                    "payment_ref" => $payment_ref,  
"order_date" => date("Y-m-d"),
                    "payment_paypal_amount" => $payment_paypal_amount,
                    "delivery_charge" => $location->delivery_charge,
                    "delivery_address" => $location->delivery_address,
                    "zipcode_id" => $location->delivery_zipcode,
                    "offer_coupon" => $offer_coupon
                    );
                    $this->load->model("common_model");
                    $id = $this->common_model->data_insert("sale",$insert_array);
                    
                    $data_post = $this->input->post("data");
                    $data_array = json_decode($data_post);
                    $total_price = 0;
                    
                    $total_items = array();
                    foreach($data_array as $dt){ 
                        $total_price = $total_price + ($dt->qty * $dt->price); 
                        $total_items[$dt->product_id] = $dt->product_id;    
                        $array = array("product_id"=>$dt->product_id,
                        "qty"=>$dt->qty,
                        "unit"=>$dt->unit,
                        "unit_value"=>$dt->unit_value,
                        "sale_id"=>$id,
                         "price"=>($dt->price - (($dt->price * $dt->discount)/100))
                        );
                        $this->common_model->data_insert("sale_items",$array);
                         
                    }
                     $total_price = $total_price + $location->delivery_charge;
                    $this->db->query("Update sale set total_amount = '".$total_price."', total_items = '".count($total_items)."' where sale_id = '".$id."'");
                    
                    
                    
                    $this->response(array(
                            RESPONCE => true,
                                        DATA => addslashes( "<p>Your order No #".$id." is send successfully \n  
                    Please keep <strong>".$total_price."</strong> on delivery
                    Thanks for being with Us.</p>" )
                                    ), REST_Controller::HTTP_OK); 
                    
                } 
        }
        
           function send_order_prescription_post(){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');  
                $this->form_validation->set_rules('delivery_id', 'Delivery',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
                    
        		}else
                {
                    $ld = $this->db->query("select user_delivery_address.*, zipcode.delivery_charge from user_delivery_address
                    inner join zipcode on zipcode.zipcode = user_delivery_address.delivery_zipcode
                    where user_delivery_address.delivery_id = '".$this->input->post("delivery_id")."' limit 1");
                    $location = $ld->row(); 
                    
                    $user_id = $this->input->post("user_id"); 
                                        
                    $insert_array = array("user_id"=>$user_id,  
                    "delivery_id"=>$location->delivery_id,
                    "delivery_charge" => $location->delivery_charge
                    );
                    $this->load->model("common_model");
                    $id = $this->common_model->data_insert("sale",$insert_array);
                    
                    
                    $insert_array = array("user_id"=>$user_id,"delivery_id"=>$location->delivery_id, 
                    "sale_id"=>$id 
                    ); 
                    
                    $file_name1 = "";
                    if(isset($_FILES["prescription_img1"]) && $_FILES['prescription_img1']['size'] > 0){
                        $path = './uploads/prescription';
                        
                        if(!file_exists($path)){
                            mkdir($path);
                        }
                        $this->load->library("imagecomponent");
                            
                            $file_name_temp = md5(uniqid())."_".$_FILES['prescription_img1']['name'];
                            $file_name1 = $this->imagecomponent->upload_image_and_thumbnail('prescription_img1',680,200,$path ,'crop',false,$file_name_temp);
                          $insert_array["prescription_img1"] = $file_name1;
                          
                    }
                    
                    $file_name2 = "";
                    if(isset($_FILES["prescription_img2"]) && $_FILES['prescription_img1']['size'] > 0){
                        $path = './uploads/prescription';
                        
                        if(!file_exists($path)){
                            mkdir($path);
                        }
                        $this->load->library("imagecomponent");
                            
                            $file_name_temp = md5(uniqid())."_".$_FILES['prescription_img2']['name'];
                            $file_name2 = $this->imagecomponent->upload_image_and_thumbnail('prescription_img2',680,200,$path ,'crop',false,$file_name_temp);
                          $insert_array["prescription_img2"] = $file_name2;
                          
                    }
                    
                     $file_name3 = "";
                    if(isset($_FILES["prescription_img3"]) && $_FILES['prescription_img1']['size'] > 0){
                        $path = './uploads/prescription';
                        
                        if(!file_exists($path)){
                            mkdir($path);
                        }
                        $this->load->library("imagecomponent");
                            
                            $file_name_temp = md5(uniqid())."_".$_FILES['prescription_img3']['name'];
                            $file_name3 = $this->imagecomponent->upload_image_and_thumbnail('prescription_img3',680,200,$path ,'crop',false,$file_name_temp);
                          $insert_array["prescription_img3"] = $file_name3;
                          
                    }
                    
                    
                    $this->common_model->data_insert("sale_prescription",$insert_array); 
                    
                    $this->response(array(
                            RESPONCE => true,
                            DATA => addslashes( "<p>Your Prescription has been send successfully \n  
                                                Wait for Admin confirm order. Admin Replay via Phone or Email. \n 
                                                Thanks for being with Us.</p>" )
                                    ), REST_Controller::HTTP_OK); 
                    
                } 
        }
         
        function my_orders_post(){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		   $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
                    
        		}else
                {
                    $data = $this->product_model->get_sale_by_user($this->input->post("user_id"));
                     $this->response(array(
                                        RESPONCE => true,
                                        DATA => $data), REST_Controller::HTTP_OK);
                    
                    
                } 
        }
        
        function order_details_post(){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('sale_id', 'Sale ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
                    
        		}else
                { 
                    $data = $this->product_model->get_sale_order_items($this->input->post("sale_id"));
                    $this->response(array(
                                        RESPONCE => true,
                                        DATA => $data), REST_Controller::HTTP_OK);
                } 
        }
        
         function cancel_order_post(){
            $this->load->library('form_validation');
                $this->form_validation->set_rules('sale_id', 'Sale ID',  'trim|required');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		   $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
                    
        		}else
                {
                    $this->db->query("Update sale set status = 3 where user_id = '".$this->input->post("user_id")."' and  sale_id = '".$this->input->post("sale_id")."' ");    
                     
                    
                     $this->response(array(
                                        RESPONCE => true,
                                        DATA => "Your order cancel successfully"), REST_Controller::HTTP_OK);
                } 
        }
        
        function my_prescription_post(){ 
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		   $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
                    
        		}else
                {
                    $data = $this->product_model->get_prescription_by_user($this->input->post("user_id"));
                     $this->response(array(
                                        RESPONCE => true,
                                        DATA => $data), REST_Controller::HTTP_OK); 
                } 
        } 
        
        function prescription_items_post(){
                $this->load->library('form_validation');  
                $this->form_validation->set_rules('sale_id', 'Sale Id',  'trim|required'); 
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
                    
        		}else
                { 
                    $data = $this->product_model->get_prescription_order_item($this->input->post("sale_id"));
                     $this->response(array(
                                        RESPONCE => true,
                                        DATA => $data), REST_Controller::HTTP_OK); 
                     
                } 
        } 
     
}
?>