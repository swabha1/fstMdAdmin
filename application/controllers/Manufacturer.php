<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manufacturer extends MY_Controller {
    public function __construct()
    {
                parent::__construct();
                // Your own constructor code
                $this->load->database();
                $this->load->helper('login_helper'); 
    }
    
/* ========== Products ==========*/
function index(){
        $this->load->model("manufacturer_model");
        $data["manufacturer"]  = $this->manufacturer_model->get_manufacturer_list();
        $this->load->view("admin/manufacturer/list_manufacturer",$data);    
}
 
 

function edit_products($mfg_id){
	   if(_is_user_login($this)){
	       
	       $q = $this->db->query("select * from `manufacturer` WHERE mfg_id=".$mfg_id);
            $data["getmfg"] = $q->row();
            
	        $data["error"] = "";
            $data["active"] = "listmfg";
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('mfg_name', 'Manufacturer Name', 'trim|required');
                
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
                     "mfg_name"=>$this->input->post("mfg_name") 
                    );
                    if($_FILES["manufacturer_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/manufacturer/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('manufacturer_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["mfg_image"]=$img_data['file_name'];
                        }
                        
                   }
                    
                    $this->common_model->data_update("manufacturer",$array,array("mfg_id"=>$mfg_id)); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('manufacturer/index');
               	}
            }
            $this->load->view("admin/manufacturer/edit_manufacturer",$data);
        }
        else
        {
            redirect('admin');
        }
    
}
function add_manufacturer(){
	   if(_is_user_login($this)){
	       $data["error"] = "";
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('mfg_name', 'Manufacturer Name', 'trim|required');
               
                
                if ($this->form_validation->run() == FALSE)
        		{
        		      if($this->form_validation->error_string()!="") { 
        			 $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                 }
                                   
        		}
        		else
        		{
                    $this->load->model("common_model");
                    $array = array( 
                     "mfg_name"=>$this->input->post("mfg_name") 
                    );
                    if($_FILES["manufacturer_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/manufacturer/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('manufacturer_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["mfg_image"]=$img_data['file_name'];
                        }
                        
                   }
                    
                    $this->common_model->data_insert("manufacturer",$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Manufacturer added successfully...
                                    </div>');
                    redirect('manufacturer/index');
               	}
            }
            
            $this->load->view("admin/manufacturer/add_manufacturer",$data);
        }
        else
        {
            redirect('admin');
        }
    
}
function delete_manufacturer($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from manufacturer where mfg_id = '".$id."'");
            redirect("manufacturer/index");
        }
}
/* ========== Products ==========*/  
  
}
