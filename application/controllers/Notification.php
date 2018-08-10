<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MY_Controller {
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
   if(_is_user_login($this))
        {
           $data["error"] = "";   
	        
             
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('noti_title', 'noti_title', 'trim|required');
                $this->form_validation->set_rules('noti_description', 'noti_description', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
      		        if($this->form_validation->error_string()!="")
                    {
                        $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                            <i class="fa fa-warning"></i>
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <strong>Warning!</strong> '.$this->form_validation->error_string().'
                            </div>');
                    }
        		}else
                {
                        $message = array("noti_title"=>$this->input->post("noti_title"),
                        "noti_description"=>$this->input->post("noti_description"),"date"=>date("Y-m-d h:i:s"));
                         
                         $noti_image = "";
                         if(isset( $_FILES["noti_image"]) && $_FILES["noti_image"]["size"] > 0)
                         {
                            $config['upload_path']          = './uploads/notification/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            
                            if(!is_dir($config['upload_path']))
                            {
                                mkdir($config['upload_path']);
                            }
                            $this->load->library('upload', $config);
                            if ( ! $this->upload->do_upload('noti_image'))
                            {
                                $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                $noti_image=$img_data['file_name'];
                                
                                 
                            }
                         }                      
                                 
                           
                        $this->load->model("common_model");
                            $this->common_model->data_insert("notification",
                                array(
                                "noti_title"=>$this->input->post("noti_title"),
                                "noti_description"=>$this->input->post("noti_description"), 
                                "noti_image"=>$noti_image, 
                                "school_id"=>_get_current_user_id($this),
                                "date"=>date("Y-m-d h:i:s")));
                         
                        $message = array("message" => $this->input->post("noti_description"),"isorder"=>"false","title"=>$this->input->post("noti_title"),"image" =>$noti_image,'created_at'=>date('Y-m-d h:i:s')); 
                         
                        $this->load->helper("gcm_helper");
                        $gcm = new GCM();
                            $result = $gcm->send_topics("/topics/fastMeds",$message,"android");    
                   
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your Attibute saved successfully...
                                        </div>');    
                        
                }
                 $this->load->model("notification_model");
                        $data["all_notification"] = $this->notification_model->get_notification();    
           
                 
                
                 $this->load->view('admin/notification/listnotification',$data);
            
        }
        
    }
  
  public function test_fcm(){
        $message["title"] = "test";
        $message["message"] = "grocery test";
        $message["image"] = "";
        $message["created_at"] = date("Y-m-d h:i:s");  
    
    $this->load->helper('gcm_helper');
    $gcm = new GCM();   
    $result = $gcm->send_notification(array("dhUEex1gXJk:APA91bEbWmBbnJNkVestXO9LZ92gokzoG8R_r4nKd7iWtKPi7vzzDwLdtBRfK5H8i7LR9xv4Uw_HnQ88uQQMtdLXcgfDnq1_Gc6jj93V4ubFz6nHHmCTzZlC1LI1FVY1ifya11yicP-M"),$message ,"android");
      // $result = $gcm->send_topics("/topics/rabbitapp",$message ,"ios"); 
    print_r($result);
    }      
    
 function delete_notification($id){
        $data = array();
            $this->load->model("notification_model");
            $slider  = $this->notification_model->get_notification_by_id($id);
           if($slider){
                $this->db->query("Delete from notification where noti_id = '".$slider->noti_id."'");
                unlink("uploads/slider/".$slider->noti_image);
                redirect("notification/index");
           }
    } 
/* ========== Zip Code ==========*/  
  
}
