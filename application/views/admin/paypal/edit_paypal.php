<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>  <?php echo $this->config->item("company_title");?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/bootstrap/css/bootstrap.min.css"); ?>" />
     <!-- Font Awesome -->
     <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/dist/css/font-awesome.min.css"); ?>" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/dist/css/ionicons.min.css"); ?>" />
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/plugins/datatables/dataTables.bootstrap.css"); ?>">
   
    <!-- daterange picker -->
     <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/plugins/daterangepicker/daterangepicker-bs3.css"); ?>">
   <!-- bootstrap datepicker -->
  <link rel="stylesheet"href="<?php echo base_url($this->config->item("theme_admin")."/plugins/datepicker/bootstrap-datepicker.min.css"); ?>">
   <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/dist/css/AdminLTE.css"); ?>">  
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/dist/css/skins/_all-skins.min.css"); ?>">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
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
                        Update Paypal Details
                          <small> Edit</small>
                    </h1> 
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('message'); ?>
                            <!-- general form elements -->
                            <div class="box box-primary"> 
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                         
                                        
                                         <div class="col-md-6">
                                             <div class="form-group"> 
                                                <label for="notice_type">Type <span class="red">*</span></label>
                                                <select name="mode" class="form-control select2">  
                                                    <option value="PRODUCTION" <?php if($paypal->mode == "PRODUCTION"){ echo "selected"; } ?>>Production</option>
                                                    <option value="SANDBOX" <?php if($paypal->mode == "SANDBOX"){ echo "selected"; } ?>>Sandbox</option>  
                                                     
                                                </select> 
                                            </div> 
                                            
                                            <div class="form-group">
                                                    <label class="">Paypal Merchant Name : <span class="text-danger">*</span></label> 
                                                    <input type="text" id="paypal_merchant_name" name="paypal_merchant_name" value="<?php echo $paypal->paypal_merchant_name; ?>" class="form-control"   />    
                                             </div>
                                             <div class="form-group"> 
                                                    <label class=""> Client ID : <span class="text-danger">*</span></label> 
                                                    <input type="text" id="client_id" name="client_id" value="<?php echo $paypal->client_id; ?>" class="form-control"  />    
                                             </div>  
                                              <div class="form-group"> 
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" name="paypal_status" id="optionsRadios1" value="1"  <?php if($paypal->status == 1){ echo "checked"; } ?>/>
                                                        Paypal enable in app.
                                                    </label>
                                                </div>
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" name="paypal_status" id="optionsRadios2" value="0"  <?php if($paypal->status == 0){ echo "checked"; } ?> />
                                                        Paypal disable in app.
                                                    </label>
                                                </div>                                             
                                               </div>
                                               <div class="box-footer" style="text-align: center;">
                                                    <input type="submit" class="btn btn-primary" name="add_paypal" value="UPDATE" />
                                                   
                                                </div>
                                         </div> 
                                    </div><!-- /.box-body --> 

                                    
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

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/jQuery/jQuery-2.1.4.min.js"); ?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/bootstrap/js/bootstrap.min.js"); ?>"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/datatables/jquery.dataTables.min.js"); ?>"></script>
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/datatables/dataTables.bootstrap.min.js"); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/dist/js/app.min.js"); ?>"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/dist/js/demo.js"); ?>"></script>
        <!-- date-range-picker -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/daterangepicker/moment.min.js"); ?>"></script> 
<script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
<script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/daterangepicker/bootstrap-datepicker.js"); ?>"></script> 
 
    <script type="text/javascript">
    $(function () {
        $("#paypal").click(function () {
            if ($(this).is(":checked")) {  
                $("#sandbox").removeAttr("disabled");
                $("#paypal_merchant").removeAttr("disabled");
                $("#paypal_config_client_id").removeAttr("disabled");
                $("#paypal_merchant_sandbox").removeAttr("disabled");
                 $("#paypal_config_client_id_sandbox").removeAttr("disabled"); 
            } else {   
                $("#sandbox").attr("disabled", "disabled");
                $("#paypal_merchant").attr("disabled", "disabled");
                $("#paypal_config_client_id").attr("disabled", "disabled");
                $("#paypal_merchant_sandbox").attr("disabled", "disabled");
                $("#paypal_config_client_id_sandbox").attr("disabled", "disabled");
            }
        });
    });
    </script>
    <script>
      $(function () {
         //Date range picker with time picker
        $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'YYYY/MM/DD h:mm A' })
     $( "#reservationtime" ).daterangepicker({ 
        minDate: 0,
        'startDate': dateToday
        });
     
        
    
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      
      });
      
    
      
    </script>
    
  </body>
</html>
