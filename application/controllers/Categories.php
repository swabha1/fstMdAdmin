<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller {
    public function __construct()
    {
                parent::__construct();
                // Your own constructor code
                $this->load->database();
                $this->load->helper('login_helper');
                $this->load->helper('sms_helper');
    }
    
/* ========== Categories =========== */
    public function addcategories()
	{
	   if(_is_user_login($this)){
	       
            $data["error"] = "";
           
            if(isset($_REQUEST["addcatg"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
        		{
        		   if($this->form_validation->error_string()!=""){
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
        		}
        		else
        		{
                    $this->load->model("category_model");
                    
                    $slug = url_title($this->input->post('cat_title'), 'dash', TRUE);
                    $parentid = $this->input->post("parent");
                     $addcat = array(
                            "type"=>$this->input->post("type"),
                            "title"=>$this->input->post("cat_title"),
                            "slug"=>$slug,
                            "parent"=>$this->input->post("parent"),
                            "description"=>strip_tags($this->input->post("cat_descri")),
                            "status"=>$this->input->post("cat_status")
                            );
            
                if($_FILES["cat_img"]["size"] > 0){
                    $config['upload_path']          = './uploads/category/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $this->load->library('upload', $config);
    
                    if ( ! $this->upload->do_upload('cat_img'))
                    {
                            $error = array('error' => $this->upload->display_errors());
                    }
                    else
                    {
                        $img_data = $this->upload->data();
                        $addcat["image"]=$img_data['file_name'];
                    }
                    
               }
               
                if($parentid != "0"){
                    $q = $this->db->query("select * from `categories` where id=".$parentid);
                    $parent = $q->row();
                    $leval = $parent->leval + 1;
                    $addcat["leval"] = $leval;                       
                }
                
               
               $this->db->insert("categories",$addcat);  
                     
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('categories/index');
               	}
            }
	   	$this->load->view('admin/categories/addcat',$data);
        }
        else
        {
            redirect('admin');
        }
	}
    
    public function editcategory($id)
	{
	   if(_is_user_login($this))
       {
            $q = $this->db->query("select * from `categories` WHERE id=".$id);
            $data["getcat"] = $q->row();
            
	        $data["error"] = "";
            $data["active"] = "listcat";
            if(isset($_REQUEST["savecat"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('cat_id', 'Categories Id', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                if ($this->form_validation->run() == FALSE)
        		{
        		   if($this->form_validation->error_string()!=""){
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                   }
        		}
        		else
        		{
                    $this->load->model("category_model");
                    $this->category_model->edit_category(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your category saved successfully...
                                    </div>');
                    redirect('categories/index');
               	}
            }
	   	   $this->load->view('admin/categories/editcat',$data);
        }
        else
        {
            redirect('admin');
        }
	}
    
    public function index()
	{
	   if(_is_user_login($this)){
	       $data["error"] = "";
	       $data["active"] = "listcat";
           $this->load->model("category_model");
           $data["allcat"] = $this->category_model->get_categories();
           $this->load->view('admin/categories/listcat',$data);
        }
        
    }
    
    public function deletecat($id)
	{
	   if(_is_user_login($this)){
	        
            $this->db->delete("categories",array("id"=>$id));
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your item deleted successfully...
                                    </div>');
            redirect('categories/index');
        }
        else
        {
            redirect('admin');
        }
    }

      
/* ========== End Categories ========== */    
 
  
}
