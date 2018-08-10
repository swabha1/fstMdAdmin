<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller {
    public function __construct()
    {
                parent::__construct();
                // Your own constructor code
                $this->load->database();
                $this->load->helper('login_helper'); 
    }
    
function index(){
        
        $data["orders"]  = $this->order_model->get_orders();
        $this->load->view("admin/orders/list",$data);    
} 

function edit($id){
	   if(_is_user_login($this)){ 
            $data["order"] = $this->order_model->get_order_by_id($id);
            $this->load->view("admin/orders/edit",$data); 
        }
        else
        {
            redirect('admin');
        }    
}
function add(){
	   if(_is_user_login($this)){
	       $data["error"] = ""; 
        }
        else
        {
            redirect('admin');
        }
    
}
function delete($sale_id){
        if(_is_user_login($this)){
            $this->db->query("Delete from sale where sale_id = '".$sale_id."'"); 
            redirect("order");
        }
}

function update_item(){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('item_id', 'ID', 'trim|required');
                $this->form_validation->set_rules('qty', 'Qty', 'trim|required'); 
                
                if ($this->form_validation->run() == FALSE)
        		{
        		   if($this->form_validation->error_string()!=""){
        			  $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
        		}
        		else
        		{
                    $this->common_model->data_update("sale_items",array("qty"=>$this->input->post("qty")),array("sale_item_id"=>$this->input->post("item_id")));
                    echo "success";    
                }    
}
function add_item(){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('product_id', 'ID', 'trim|required');
                $this->form_validation->set_rules('qty', 'Qty', 'trim|required'); 
                $this->form_validation->set_rules('sale_id', 'Sale ID', 'trim|required'); 
                
                
                if ($this->form_validation->run() == FALSE)
        		{
        		   if($this->form_validation->error_string()!=""){
        			  $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
        		}
        		else
        		{
        		    $product = $this->product_model->get_product_by_id($this->input->post("product_id"));
                    if(!empty($product)){
                        $id = $this->common_model->data_insert("sale_items",array(
                            "qty"=>$this->input->post("qty"),
                            "sale_id"=>$this->input->post("sale_id"),
                            "product_id"=>$product->product_id,
                            "product_name"=>$product->product_name,
                            "unit"=>$product->unit,
                            "unit_value"=>$product->unit_value,
                            "price"=>$product->price,
                            "discount"=>$product->discount));    
                        
                        $item = $this->order_model->get_order_item_by_id($id);
                        echo $this->load->view("admin/orders/item_row",array("item"=>$item),true);
                    }  
                    
                        
                }    
    
}
function delete_item(){
    $this->load->library('form_validation');
                $this->form_validation->set_rules('item_id', 'ID', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
        		{
        		   if($this->form_validation->error_string()!=""){
        			  $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
        		}
        		else
        		{
                    $this->common_model->data_remove("sale_items",array("sale_item_id"=>$this->input->post("item_id")));
                   
                }
}
/* ========== Products ==========*/
 function orderdetails($sale_id){
         if(_is_user_login($this)){ 
             
            $data["order"] = $this->product_model->get_sale_order_by_id($sale_id);
            $data["order_items"] = $this->product_model->get_sale_order_items($sale_id);
            $this->load->view("admin/orders/orderdetails",$data); 
        }
        else
        {
            redirect('admin');
        }    
 }
 
  public function confirm_order($sale_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($sale_id);
            if(!empty($order)){
                $this->db->query("update sale set status = 1 where sale_id = '".$sale_id."'");
                 $q = $this->db->query("Select * from users where user_id = '".$order->user_id."'");
                $user = $q->row();
                
                                $message["title"] = "Confirmed  Order";
                                $message["message"] = "Your order Number '".$order->sale_id."' confirmed successfully";
                                $message["image"] = "";
                                $message["isorder"] = "true";
                                $message["created_at"] = date("Y-m-d h:i:s"); 
                                $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            if($user->user_gcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_gcm_code),$message ,"android");
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order confirmed. </div>');
            }
             redirect("order/index");
        }
    }
    
      public function delivered_order($sale_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($sale_id);
            if(!empty($order)){
                $this->db->query("update sale set status = 2 where sale_id = '".$sale_id."'");
                
                 $q = $this->db->query("Select * from users where user_id = '".$order->user_id."'");
                $user = $q->row();
                
                               $message["title"] = "Delivered  Order";
                                $message["message"] = "Your order Number '".$order->sale_id."' Delivered successfully. Thank you for being with us";
                                $message["image"] = "";
                                $message["isorder"] = "true";
                                $message["created_at"] = date("Y-m-d h:i:s"); 
                                $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            if($user->user_gcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_gcm_code),$message ,"android");
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order delivered. </div>');
            }
            redirect("order/index");
        }
    }
    
      public function cancle_order($sale_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($sale_id);
            if(!empty($order)){
                $this->db->query("update sale set status = 3 where sale_id = '".$sale_id."'");
                
                 $q = $this->db->query("Select * from users where user_id = '".$order->user_id."'");  
                 $user = $q->row();  
                                $message["title"] = "Cancel  Order";
                                $message["message"] = "Your order Number '".$order->sale_id."' cancel successfully";
                                $message["image"] = "";
                                $message["isorder"] = "true";
                                $message["created_at"] = date("Y-m-d h:i:s"); 
                                $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                           if($user->user_gcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_gcm_code),$message ,"android");
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order Cancle. </div>');
            }
            redirect("order/index");
        }
    }
  
  
}
