<!DOCTYPE html>
<html>
    <?php  $this->load->view("admin/common/common_head"); ?>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <?php  $this->load->view("admin/common/common_header"); ?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php  $this->load->view("admin/common/common_sidebar"); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            
             Slider 
          </h1>
           
        </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('success_req'); ?>
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"> Add Slider  </h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                    <div class="col-md-6">
                                     <div class="form-group">
                                            <label class=""> Slider Title  : <span class="text-danger">*</span></label>
                                            <input type="text" name="slider_title" class="form-control" placeholder="Slider Title" value="<?php if(isset($_REQUEST["slider_title"])){echo $_REQUEST["slider_title"];} ?>"/>
                                        </div>
                                        </div>
                                   <div class="col-md-6">
                                     <div class="form-group">
                                            <label class=""> Slider Url  : </label>
                                            <input type="text" name="slider_url" class="form-control" placeholder="Slider Url/Link" value="<?php if(isset($_REQUEST["slider_url"])){echo $_REQUEST["slider_url"];} ?>"/>
                                        </div>
                                        </div>
                                  
                                   
                                         
                                        <div class="col-md-6">
                                     
                                        <div class="form-group">
                                            <label>  Image  : <span class="text-danger">*</span> </label>
                                            <input type="file" name="slider_img" />
                                        </div>
                                        </div>
                               
                                             <!--    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">Select Status : <span class="text-danger">*</span></label>
                                            <select class="text-input form-control" name="slider_status">
                                                <option value="1"> Active  </option>
                                                <option value="0"> DeActive  </option>
                                                      
                                            </select>
                                        </div>
                                        </div>-->
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="addslider" value="Add Slider" />
                                       
                                    </div>
                                </form>
                            </div><!-- /.box -->
                        </div>

                    </div>
                    <!-- Main row -->
                </section><!-- /.content -->
           
        </div><!-- ./wrapper -->

        <?php  $this->load->view("admin/common/common_footer"); ?>  

      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    
  </body>
</html>
