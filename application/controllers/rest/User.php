<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
class User extends REST_Controller {

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
    public function login_post(){
        
                $this->load->library('form_validation');
                // Validate The Logi User
                $this->form_validation->set_rules('user_email', 'Email Id',  'trim|required|valid_email');
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
               
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
        		}else
                {
                   
                    $q = $this->db->query("Select * from `users` where user_email='".$this->post('user_email')."' and user_password='".md5($this->post('user_password'))."' Limit 1");
                    if ($q->num_rows() > 0)
                    {
                        $row = $q->row(); 
                        if($row->user_status == "0")
                        {
                            $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => "Your account currently inactive."
                                    ), REST_Controller::HTTP_OK); 
                            
                        }  
                        else
                        {
                            $this->response(array(
                                RESPONCE => true,"data"=>array(
                                "user_id"=>$row->user_id,
                                "user_type_id"=>$row->user_type_id,
                                "user_fullname"=>$row->user_fullname,
                                "user_email"=>$row->user_email,
                                "user_phone"=>$row->user_phone,
                                "user_bdate"=>$row->user_bdate,
                                "user_image"=>$row->user_image)), REST_Controller::HTTP_OK);
                        }
                    }
                    else
                    {
                        $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => "Invalide Username or Passwords"
                                    ), REST_Controller::HTTP_OK); 
                    }
                   
                    
                }
    }
    public function register_post(){
            $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('user_fullname', 'Full Name', 'trim|required'); 
                $this->form_validation->set_rules('user_email', 'Email Id',  'trim|required|valid_email|is_unique[users.user_email]');
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
                $this->form_validation->set_rules('user_phone', 'Phone', 'trim|required'); 
                $this->form_validation->set_message('is_unique', 'Email address is already register');
                
                if ($this->form_validation->run() == FALSE) 
        		{
                    $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
                                    
        		}else
                {
                     
                  $user_id =  $this->common_model->data_insert("users", array("user_fullname"=>$this->post("user_fullname"),
                                            "user_email"=>$this->post("user_email"),
                                            "user_phone"=>$this->post("user_phone"),
                                            "user_bdate"=>$this->post("user_bdate"),
                                            "user_password"=>md5($this->post("user_password")), 
                                            "user_status"=>"1"  
                                            ));
                  
                  $this->response(array(
                                    RESPONCE => true,
                                    "data"=> array(
                                    "user_id"=>$user_id, 
                                    "user_phone"=>$this->post("user_phone"),
                                    "user_fullname"=>$this->post("user_fullname"),
                                    "user_email"=>$this->post("user_email"),
                                    "user_bdate"=>$this->post("user_bdate"),
                                    "user_image"=>""))
                                    , REST_Controller::HTTP_OK);
                    
                  }     
    }
    public function forgotpassword_post(){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            if ($this->form_validation->run() == FALSE) 
      		{
            		    $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
                        
      		}else
            {
                   $request = $this->db->query("Select * from users where user_email = '".$this->post("email")."' limit 1");
                   if($request->num_rows() > 0){
                                
                                $user = $request->row();
                                $token = uniqid(uniqid());
                                 
                                $this->common_model->data_update("users",array("varified_token"=>$token),array("user_id"=>$user->user_id)); 
                                $this->load->library('email');
                                $this->email->from($this->config->item('default_email'), $this->config->item('email_host'));
                                $list = array($user->user_email);
                                $this->email->to($list);
                                $this->email->reply_to($this->config->item('default_email'), $this->config->item('email_host'));
                                $this->email->subject('Forgot password request');
                                $this->email->message("Hi ".$user->user_fullname." \n Your password forgot request is accepted plase visit following link to change your password. \n
                                ".site_url("users/modify_password/".$token)."
                                ");
                                if ( ! $this->email->send()){
                                    $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => "Something is wrong with system to send mail."
                                    ), REST_Controller::HTTP_OK);
    
                                }else{
                                    $this->response(array(
                                    RESPONCE => true,
                                    "data"=> "Recovery mail sent to your email address please verify link.")
                                    , REST_Controller::HTTP_OK);
    
                                }
                   }else{
                                       	$this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => "No user found with this email."
                                    ), REST_Controller::HTTP_OK);
                                           	    
    
                   }
                }
               
        }
        public function updateprofile_post(){ 
            $this->load->library('form_validation');
                /* add users table validation */
                
                $this->form_validation->set_rules('user_fullname', 'Full Name', 'trim|required');
                 $this->form_validation->set_rules('user_gender', 'Gender', 'trim|required');
                  $this->form_validation->set_rules('user_bdate', 'Birth Day', 'trim|required');
                $this->form_validation->set_rules('user_phone', 'Phone', 'trim|required');
                $this->form_validation->set_rules('user_address', 'Address', 'trim|required');
                $this->form_validation->set_rules('user_city', 'City', 'trim|required');
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
        		}else
                {
                        // Data in Database
                    $update_array = array(
                        "user_fullname"=>$this->post("user_fullname"),
                         "user_gender"=>$this->post("user_gender"), 
                           "user_phone"=>$this->post("user_phone"),
                            "user_address"=>$this->post("user_address"),
                        "user_city"=>$this->post("user_city"),
                        "user_bdate" => date("Y-m-d",strtotime($this->post("user_bdate")))
                    ); 
                     
                    $this->common_model->data_update("users", $update_array, array("user_id"=>$this->post("user_id")));
                 
                    $this->response(array(
                                    RESPONCE => true,
                                    "data"=> "Profile Updated Successfully")
                                    , REST_Controller::HTTP_OK);
                    
                  }   
        }
        public function updatepicture_post(){
            $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
                                    
        		}else
                {
                   
                    $file_name = "";
                    if(isset($_FILES["user_image"]) && $_FILES['user_image']['size'] > 0){
                        $path = './uploads/profile';
                        
                        if(!file_exists($path)){
                            mkdir($path);
                        }
                        $this->load->library("imagecomponent");
                            
                            $file_name_temp = md5(uniqid())."_".$_FILES['user_image']['name'];
                            $file_name = $this->imagecomponent->upload_image_and_thumbnail('user_image',680,200,$path ,'crop',false,$file_name_temp);
                          $update_array["user_image"] = $file_name;
                          $this->common_model->data_update("users", $update_array, array("user_id"=>$this->post("user_id")));
                          
                          $this->response(array(
                                    RESPONCE => true,
                                    "data"=> $file_name)
                                    , REST_Controller::HTTP_OK);
                    }else{
                        $this->response(array(
                                    RESPONCE => false,
                                    "data"=> "No file selected")
                                    , REST_Controller::HTTP_OK);
                    }                     
                 }   
        }
        public function changepass_post(){
            $this->load->model("users_model");
           
            $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('c_password', 'Current Password', 'trim|required');
                $this->form_validation->set_rules('n_password', 'New Password', 'trim|required');
                $this->form_validation->set_rules('r_password', 'Re Password', 'trim|required');
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
        		}else
                {
                    $user_data  = $this->users_model->get_user_by_id($this->input->post("user_id"));
                    if($user_data->user_password == md5($this->input->post("c_password"))){
                        $n_password = $this->input->post("n_password");
                        $r_password = $this->input->post("r_password");
                        
                        if($n_password == $r_password){
                           
                            $this->common_model->data_update("users",
                                array("user_password"=>md5($n_password)),array("user_id"=>$user_data->user_id));
                           
                                    $this->response(array(
                                    RESPONCE => true,
                                    "data"=> "Change Password Successfully")
                                    , REST_Controller::HTTP_OK);
                        }else{
                            $this->response(array(
                                    RESPONCE => false,
                                    "data"=> "New password do not match")
                                    , REST_Controller::HTTP_OK);
                        }
                        
                    }
                    else{
                         $this->response(array(
                                    RESPONCE => false,
                                    "data"=> "Current Password Do Not Match")
                                    , REST_Controller::HTTP_OK);
                    }
                  }   
        }
         
        function add_delivery_address_post(){
            $this->load->library('form_validation');
                $this->form_validation->set_rules('delivery_user_id', 'User ID',  'trim|required');
                 $this->form_validation->set_rules('delivery_zipcode', 'Zipcode', 'trim|required');
                $this->form_validation->set_rules('delivery_address', 'Address',  'trim|required');
                $this->form_validation->set_rules('delivery_landmark', 'Landmark',  'trim|required');
                $this->form_validation->set_rules('delivery_fullname', 'Full Name',  'trim|required');
                $this->form_validation->set_rules('delivery_mobilenumber', 'Mobile Number',  'trim|required');
                $this->form_validation->set_rules('delivery_city', 'City',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
                    
        		}else
                {
                    $delivery_user_id = $this->input->post("delivery_user_id");
                    $delivery_zipcode = $this->input->post("delivery_zipcode");
                    $delivery_address = $this->input->post("delivery_address");
                    $delivery_landmark = $this->input->post("delivery_landmark");
                    $delivery_fullname = $this->input->post("delivery_fullname");
                    $delivery_mobilenumber = $this->input->post("delivery_mobilenumber");
                    $delivery_city = $this->input->post("delivery_city");
                    
                    $array = array(
                    "delivery_user_id" => $delivery_user_id,
                    "delivery_zipcode" => $delivery_zipcode,
                    "delivery_address" => $delivery_address,
                    "delivery_landmark" => $delivery_landmark,
                    "delivery_fullname" => $delivery_fullname,
                    "delivery_mobilenumber" => $delivery_mobilenumber,
                    "delivery_city" => $delivery_city
                    );
                    
                    $this->db->insert("user_delivery_address",$array);
                    $insert_id = $this->db->insert_id();
                    $q = $this->db->query("Select * from user_delivery_address  
                    where delivery_id = '".$insert_id."'");
                    $data["responce"] = true;
                    $data["data"] = $q->row();
                     $this->response(array(
                                    RESPONCE => true,
                                    DATA =>$q->row())
                                    , REST_Controller::HTTP_OK);
                }
               
        } 
        
        function user_delivery_address_post(){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User',  'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		     $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
                    
        		}else
                {
                    $user_id = $this->input->post("user_id");
                    
        		$q = $this->db->query("Select user_delivery_address.*,
                    zipcode.delivery_charge from user_delivery_address 
                    inner join zipcode on zipcode.zipcode = user_delivery_address.delivery_zipcode
                    where user_delivery_address.delivery_user_id = '".$user_id."'");
                    
                     $this->response(array(
                                    RESPONCE => true,
                                    DATA =>$q->result())
                                    , REST_Controller::HTTP_OK);
                } 
        }
        
        
        public function edit_delivery_address_post(){
                $data = array(); 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('delivery_user_id', 'User ID',  'trim|required');
                $this->form_validation->set_rules('delivery_zipcode', 'Zipcode', 'trim|required');
                $this->form_validation->set_rules('delivery_address', 'Address',  'trim|required');
                $this->form_validation->set_rules('delivery_landmark', 'Landmark',  'trim|required');
                $this->form_validation->set_rules('delivery_fullname', 'Full Name',  'trim|required');
                $this->form_validation->set_rules('delivery_mobilenumber', 'Mobile Number',  'trim|required');
                $this->form_validation->set_rules('delivery_city', 'City',  'trim|required');
                $this->form_validation->set_rules('delivery_id', 'Delivery ID', 'trim|required');
                 
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
                    
        		}else
                {
            $insert_array=  array(        
                                         "delivery_user_id" => $this->input->post("delivery_user_id"),
                                        "delivery_zipcode" => $this->input->post("delivery_zipcode"),
                                        "delivery_address" => $this->input->post("delivery_address"),
                                        "delivery_landmark" => $this->input->post("delivery_landmark"),
                                        "delivery_fullname" => $this->input->post("delivery_fullname"),
                                        "delivery_mobilenumber" => $this->input->post("delivery_mobilenumber"),
                                        "delivery_city" => $this->input->post("delivery_city"));
                     
                    $this->load->model("common_model");
                     
                    
                   $this->common_model->data_update("user_delivery_address",$insert_array,array("delivery_id"=>$this->input->post("delivery_id")));
                    
                      
                   $this->response(array(
                                    RESPONCE => true,
                                    DATA =>"Your Address Update successfully...")
                                    , REST_Controller::HTTP_OK);
                  }   
        }
        
         public function delete_delivery_address_post()
    	{
    	    $this->load->library('form_validation');
                     $this->form_validation->set_rules('delivery_id', 'Delivery ID', 'trim|required');
           
            if ($this->form_validation->run() == FALSE)
            		{
            			   $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
            		}
           
    	   else{
    	        
                $this->db->delete("user_delivery_address",array("delivery_id"=>$this->input->post("delivery_id")));
                 
                 $this->response(array(
                                    RESPONCE => true,
                                    DATA =>"Your Address deleted successfully...")
                                    , REST_Controller::HTTP_OK); 
                  
            }
            echo json_encode($data);
        }
        
        public function register_fcm_post(){
            $data = array();
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
            $this->form_validation->set_rules('token', 'Token', 'trim|required');
            $this->form_validation->set_rules('device', 'Device', 'trim|required');
            if ($this->form_validation->run() == FALSE) 
        {
                
                  $this->response(array(
                                        RESPONCE => false,
                                        MESSAGE => strip_tags($this->form_validation->error_string())
                                    ), REST_Controller::HTTP_OK); 
                                
        }else
            {   
                $device = $this->input->post("device");
                $token = $this->input->post("token");
                $user_id = $this->input->post("user_id");
                
                $field = "";
                if($device=="android"){
                    $field = "user_gcm_code";
                }else if($device=="ios"){
                    $field = "user_ios_token";
                }
                if($field!=""){
                    $this->db->query("update users set ".$field." = '".$token."' where user_id = '".$user_id."'");
                  //  $data["responce"] = true;    
                    
                    $this->response(array(
                                    RESPONCE => true)
                                    , REST_Controller::HTTP_OK); 
                    
                }else{
                    
                       $this->response(array(
                                        RESPONCE => false,
                                        DATA => "Device type is not set"
                                    ), REST_Controller::HTTP_OK); 
                }
                
                
            }
            echo json_encode($data);
    }
    
     public function test_fcm_post(){
        $message["title"] = "test";
        $message["message"] = "grocery test";
        $message["image"] = "";
        $message["created_at"] = date("Y-m-d h:i:s");  
    
    $this->load->helper('gcm_helper');
    $gcm = new GCM();   
    $result = $gcm->send_notification(array("etWhFjJAIjU:APA91bGK78eKYUapQlKXG0bs0V66UYMeu4X0c_xK20HpHaD1KWNKuZg3cFQyRlKdqUxASKMCxmgNBTEJCOvttR3wIGxJLYOnUxajKG4-haiSJ-hKvW2faGfuH7jUd3Gmp9DbPFNk3L0J"),$message ,"android");
      // $result = $gcm->send_topics("/topics/rabbitapp",$message ,"ios"); 
    print_r($result);
    }  
        
}
?>