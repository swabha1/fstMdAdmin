<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {
    public function __construct()
    {
                parent::__construct();
                // Your own constructor code
                $this->load->database();
                $this->load->helper('login_helper'); 
    }
    
/* ========== Products ==========*/
function index(){
        $this->load->model("product_model");
        $data["products"]  = $this->product_model->get_products();
        $this->load->view("admin/product/list_product",$data);    
}
 
 

function edit_products($prod_id){
	   if(_is_user_login($this)){
	    
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                
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
                    $this->load->model("common_model");
                    $array = array( 
                     "product_name"=>$this->input->post("prod_title"), 
                    "category_id"=>$this->input->post("parent"),
                    "in_stock"=>$this->input->post("prod_status"),
                    "price"=>$this->input->post("price"),
                    "unit_value"=>$this->input->post("qty"),
                    "unit"=>$this->input->post("unit") 
                    
                    );
                    if($_FILES["prod_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/products/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('prod_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["product_image"]=$img_data['file_name'];
                        }
                        
                   }
                    
                    $this->common_model->data_update("products",$array,array("product_id"=>$prod_id)); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('product/index');
               	}
            }
            $this->load->model("product_model");
            $data["product"] = $this->product_model->get_product_by_id($prod_id);
            $this->load->view("admin/product/edit",$data);
        }
        else
        {
            redirect('admin');
        }
    
}
function add_product(){
	   if(_is_user_login($this)){
	       $data["error"] = "";
	     $this->load->model("manufacturer_model");
            $data["manufacturer"] = $this->manufacturer_model->get_manufacturer_list();
            if(isset($_POST))
            {
                
                
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                  $this->form_validation->set_rules('manufacturer', 'Manufacturer', 'trim|required'); 
                 $this->form_validation->set_rules('price', 'price', 'trim|required');
                $this->form_validation->set_rules('qty', 'qty', 'trim|required'); 
                
                if ($this->form_validation->run() == FALSE)
        		{
        		      if($this->form_validation->error_string()!="") { 
        			  	$data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                 }
                                   
        		}
        		else
        		{
        		   $isgeneric = ($this->input->post("isgeneric")=="on")? 1 : 0;
                  
                    $this->load->model("common_model");
                    $array = array( 
                     "product_name"=>$this->input->post("prod_title"), 
                    "category_id"=>$this->input->post("parent"),
                    "mfg_id"=>$this->input->post("manufacturer"),
                    "isgeneric"=>$isgeneric,
                    "in_stock"=>$this->input->post("prod_status"),
                    "price"=>$this->input->post("price"),
                    "unit_value"=>$this->input->post("qty"),
                    "unit"=>$this->input->post("unit") 
                    );
                    if($_FILES["prod_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/products/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('prod_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["product_image"]=$img_data['file_name'];
                        }
                        
                   }
                    
                    $this->common_model->data_insert("products",$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('product/index');
               	}
            }
            
            $this->load->view("admin/product/add_product",$data);
        }
        else
        {
            redirect('admin');
        }
    
}
function delete_product($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from products where product_id = '".$id."'");
            redirect("product/index");
        }
}
/* ========== Products ==========*/  
function search(){
    $q  =  $this->db->query("Select * from products");
    header('Content-type: text/json');
    echo json_encode($q->result());
}  
}
