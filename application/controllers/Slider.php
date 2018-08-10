<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends MY_Controller {
   public function __construct()
    {
                parent::__construct();
                // Your own constructor code
                $this->load->database();
                $this->load->helper('login_helper'); 
    }
    
/* ========== Zip Code ==========*/
public function index()
{
	       $data["error"] = "";
	       $data["active"] = "listslider";
           $this->load->model("slider_model");
           $data["allslider"] = $this->slider_model->get_slider();
           $this->load->view('admin/slider/listslider',$data);
        
        
    }
 public function addslider()
	{
	   if(_is_user_login($this)){
	       $data["error"] = ""; 
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
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
                    $add = array(
                                    "slider_title"=>$this->input->post("slider_title"),
                                    "slider_url"=>$this->input->post("slider_url"),
                                    );
                    
                    if($_FILES["slider_img"]["size"] > 0){
                            $config['upload_path']          = './uploads/slider/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            $this->load->library('upload', $config);
            
                            if ( ! $this->upload->do_upload('slider_img'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                $add["slider_image"]=$img_data['file_name'];
                            }
                            
                       }
                     
                    $this->common_model->data_insert("slider",$add); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your offer added successfully...
                                    </div>');
                   redirect('slider/index');
               	}
            $this->load->view("admin/slider/addslider",$data);
        }
        else
        {
            redirect('admin');
        }
	}
 
     public function editslider($id)
	{
	   if(_is_user_login($this))
       {
            
            $this->load->model("slider_model");
           $data["slider"] = $this->slider_model->get_slider_by_id($id);
           
	        $data["error"] = "";
            $data["active"] = "listslider";
            if(isset($_REQUEST["saveslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
               
                  if ($this->form_validation->run() == FALSE)
        		{
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
        		}
        		else
        		{
                    $this->load->model("slider_model");
                    $this->slider_model->edit_slider($id); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider saved successfully...
                                    </div>');
                    redirect('slider/index');
               	}
            }
	   	   $this->load->view('admin/slider/editslider',$data);
        }
        else
        {
            redirect('login');
        }
	}
     function deleteslider($id){
        $data = array();
            $this->load->model("slider_model");
            $slider  = $this->slider_model->get_slider_by_id($id);
           if($slider){
                $this->db->query("Delete from slider where id = '".$slider->id."'");
                unlink("uploads/slider/".$slider->slider_image);
                redirect("slider/index");
           }
    } 
/* ========== Zip Code ==========*/  
  
}
