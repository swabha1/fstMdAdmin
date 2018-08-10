<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends MY_Controller {
    public function __construct()
    {
                parent::__construct();
                // Your own constructor code
                $this->load->database();
                $this->load->helper('login_helper'); 
    }
    
/* ========== Offer ==========*/
function index(){
        
        $data["offer"]  = $this->offer_model->get_offer();
        $this->load->view("admin/offer/list_offer",$data);    
} 

function edit_offer($offer_id){
	   if(_is_user_login($this)){ 
             $data["offer"] = $this->offer_model->get_offer_by_id($offer_id);
                $this->load->library('form_validation');
                $this->form_validation->set_rules('offer_title', 'Title', 'trim|required');
                $this->form_validation->set_rules('offer_description', 'Description', 'trim|required'); 
                $this->form_validation->set_rules('offer_coupon', 'offer_coupon', 'trim|required');
                $this->form_validation->set_rules('offer_discount', 'discount', 'trim|required');
                
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
                    
                    $times = explode('-',$this->input->post("reservationtime")); 
                     $offer_start_date = date("Y-m-d h:i:s",strtotime(trim($times[0]))) ;
                     $offer_end_date = date("Y-m-d h:i:s",strtotime(trim($times[1])));
                     
                    
                   
                    $array = array( 
                     "offer_title"=>$this->input->post("offer_title"), 
                    "offer_description"=>$this->input->post("offer_description"),
                     "offer_start_date"=>$offer_start_date,
                      "offer_end_date"=>$offer_end_date,
                    "offer_coupon"=>$this->input->post("offer_coupon"),
                    "offer_discount"=>$this->input->post("offer_discount"),
                    "offer_status"=>'1'
                    );
                     
                    
                    $this->common_model->data_update("offer",$array,array("offer_id"=>$offer_id)); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Edit successfully...
                                    </div>');
                    redirect('offer/index');
               	}
             
             
           
            $this->load->view("admin/offer/edit_offer",$data); 
        }
        else
        {
            redirect('admin');
        }
    
}
function add_offer(){
	   if(_is_user_login($this)){
	       $data["error"] = ""; 
                $this->load->library('form_validation');
                $this->form_validation->set_rules('offer_title', 'Title', 'trim|required');
                $this->form_validation->set_rules('offer_description', 'Description', 'trim|required'); 
                $this->form_validation->set_rules('offer_coupon', 'offer_coupon', 'trim|required');
                $this->form_validation->set_rules('offer_discount', 'discount', 'trim|required');
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
        		   
                     $times = explode('-',$this->input->post("reservationtime")); 
                     $offer_start_date = date("Y-m-d h:i:s",strtotime(trim($times[0]))) ;
                     $offer_end_date = date("Y-m-d h:i:s",strtotime(trim($times[1])));
                     
                    
                   
                    $array = array( 
                     "offer_title"=>$this->input->post("offer_title"), 
                    "offer_description"=>$this->input->post("offer_description"),
                     "offer_start_date"=>$offer_start_date,
                      "offer_end_date"=>$offer_end_date,
                    "offer_coupon"=>$this->input->post("offer_coupon"),
                    "offer_discount"=>$this->input->post("offer_discount"),
                    "offer_status"=>'1'
                    );
                     
                    $this->common_model->data_insert("offer",$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your offer added successfully...
                                    </div>');
                   redirect('offer/index');
               	}
           
            
            $this->load->view("admin/offer/add_offer",$data);
        }
        else
        {
            redirect('admin');
        }
    
}
function delete_offer($offer_id){
        if(_is_user_login($this)){
            $this->db->query("Delete from offer where offer_id = '".$offer_id."'");
            redirect("offer/index");
        }
}
/* ========== Products ==========*/  
  
}
