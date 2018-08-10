<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal extends MY_Controller {
    public function __construct()
    {
                parent::__construct();
                // Your own constructor code
                $this->load->database();
                $this->load->helper('login_helper'); 
    }
    
/* ========== paypal ==========*/
function index(){ 
         if(_is_user_login($this)){
	        $q  = $this->db->query("Select * from paypal where id = '1'");
            $row = $q->row();
            $data["error"] = "";
           
            if(isset($_REQUEST["add_paypal"]))
            { 
                     $addcat = array(
                            "mode"=>$this->input->post("mode"),
                            "paypal_merchant_name"=>$this->input->post("paypal_merchant_name"),  
                            "client_id"=>$this->input->post("client_id"),
                            "status"=>$this->input->post("paypal_status")
                            ); 
               
             
                  $this->common_model->data_update("paypal",$addcat,array("id"=>$row->id));   
                   
                
            }
             $q  = $this->db->query("Select * from paypal where id = '1'");
            $row = $q->row();
           
            $data["paypal"] = $row; 
	    $this->load->view("admin/paypal/edit_paypal",$data); 
        }
        else
        {
            redirect('admin');
        }
} 
 
 
/* ========== paypal ==========*/  
  
}
