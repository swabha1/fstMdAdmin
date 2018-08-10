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
                         Zipcode 
                    </h1>
                    
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="box box-primary"> 
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body"> 
                                        <div class="form-group">
                                            <label class="">Zip / Area code : <span class="text-danger">*</span> 
                                            <input type="text" name="zipcode" class="form-control" placeholder="123456" value="<?php echo $getzip->zipcode; ?>" />
                                        </div>
                                         <div class="form-group">
                                            <label class="">Delivery Charge : <span class="text-danger">*</span> </label>
                                            <input type="number" name="delivery_charge" class="form-control" placeholder="00" value="<?php echo $getzip->delivery_charge; ?>" />
                                        </div>
                                    </div><!-- /.box-body --> 
                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="add_zipcode" value="Add" />                                       
                                    </div>
                                </form>
                            </div><!-- /.box -->
                        </div>
                    </div>
                    <!-- Main row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- /.content-wrapper -->
      
      <?php  $this->load->view("admin/common/common_footer"); ?>  

      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

  
  </body>
</html>
