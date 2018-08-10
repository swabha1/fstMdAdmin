<!DOCTYPE html>
<html>
    <?php  $this->load->view("admin/common/common_head"); ?>
     <!-- daterange picker -->
     <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/plugins/daterangepicker/daterangepicker-bs3.css"); ?>">
   <!-- bootstrap datepicker -->
  <link rel="stylesheet"href="<?php echo base_url($this->config->item("theme_admin")."/plugins/datepicker/bootstrap-datepicker.min.css"); ?>">
   <!-- Theme style -->
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
                         Edit Offer  
                    </h1> 
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-6">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('message'); ?>
                            <!-- general form elements -->
                            <div class="box box-primary"> 
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                                <label class="">Title : <span class="text-danger">*</span></label> 
                                                <input type="text" name="offer_title" class="form-control" placeholder="Title" value="<?php echo $offer->offer_title; ?>" />    
                                         </div>
                                         <div class="form-group">
                                                <label class="">Description : <span class="text-danger">*</span></label> 
                                                <input type="text" name="offer_description" class="form-control" placeholder="Description" value="<?php echo $offer->offer_title; ?>" />    
                                         </div>
                                         
                                        <div class="form-group">
                                        <label>Date and time range:</label> 
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                          </div>
                                          <input type="text" class="form-control pull-right" name="reservationtime" id="reservationtime" value="<?php echo $offer->offer_start_date; ?> - <?php echo $offer->offer_end_date; ?>" />
                                        </div>
                                        <!-- /.input group -->
                                      </div>
                                          
                                          
                                      <div class="form-group">
                                            <label class="">Coupon : <span class="text-danger">*</span></label> 
                                            <input type="text" name="offer_coupon" class="form-control" placeholder="CODE15" value="<?php echo $offer->offer_coupon; ?>" />    
                                     </div>
                                     
                                    
                                      <div class="form-group">
                                         
                						  <label>Discount</label>
                                          <div class="input-group col-md-6"> 
                                            <input type="number" class="form-control" name="offer_discount" value="<?php echo $offer->offer_discount; ?>" />
                                            <span class="input-group-addon">%</span>
                                          </div>
                                         
                                      </div> 
                                   
                                    </div><!-- /.box-body --> 

                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="add_offer" value="Add" />
                                       
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

         <!-- date-range-picker -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/daterangepicker/moment.min.js"); ?>"></script> 
<script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
<script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/daterangepicker/bootstrap-datepicker.js"); ?>"></script> 
 <script>
  $(function () {
         //Date range picker with time picker
        $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'YYYY/MM/DD h:mm A' })
     $( "#reservationtime" ).daterangepicker({ 
        minDate: 0,
        'startDate': dateToday
        });
          });
 </script>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    
  </body>
</html>
