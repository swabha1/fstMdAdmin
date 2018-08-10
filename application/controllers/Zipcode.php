<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zipcode extends MY_Controller {
    public function __construct()
    {
                parent::__construct();
                // Your own constructor code
                $this->load->database();
                $this->load->helper('login_helper'); 
    }
    
/* ========== Zip Code ==========*/
 

function add_zipcode(){
    if(_is_user_login($this)){
	     $data["error"] = "";
             
              $data["zipcode"]  = $this->zipcode_model->get_zipcode();
            
                $this->load->library('form_validation');
                $this->form_validation->set_rules('zipcode', 'zipcode', 'trim|required');  
                 $this->form_validation->set_rules('delivery_charge', 'Delivery Charges', 'trim|required');

                if ($this->form_validation->run() == FALSE)
        		{
        		  if($this->form_validation->error_string()!="")
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
        		}
        		else
        		{ 
                    $array = array(
                    "zipcode"=>$this->input->post("zipcode"), 
                      "delivery_charge"=>$this->input->post("delivery_charge") 
                    );
                    
                    $this->common_model->data_insert("zipcode",$array);
                     
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("zipcode/add_zipcode");
                } 
                 
                $this->load->view("admin/zipcode/list_zipcode",$data);  
                
             
        }
        
    } 
    function edit_zipcode($zipcode_id){
	   if(_is_user_login($this)){
	       
	       $q = $this->db->query("select * from `zipcode` WHERE zipcode_id=".$zipcode_id);
            $data["getzip"] = $q->row();
            
	        $data["error"] = "";
            $data["active"] = "listzip";
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('zipcode', 'zipcode', 'trim|required');  
                 $this->form_validation->set_rules('delivery_charge', 'Delivery Charges', 'trim|required');
                
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
                     $array = array(
                    "zipcode"=>$this->input->post("zipcode"), 
                      "delivery_charge"=>$this->input->post("delivery_charge") 
                    );
                    
                    
                    $this->common_model->data_update("zipcode",$array,array("zipcode_id"=>$zipcode_id)); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('zipcode/add_zipcode');
               	}
            }
            $this->load->view("admin/zipcode/edit_zipcode",$data);
        }
        else
        {
            redirect('admin');
        }
    
}
    
function delete_zipcode($zipcode_id){
        if(_is_user_login($this)){
            $this->db->query("Delete from zipcode where zipcode_id = '".$zipcode_id."'");
            redirect("zipcode/add_zipcode");
        }
}
/* ========== Zip Code ==========*/  
  
}
