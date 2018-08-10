<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Dashboard</title>
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
    
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/plugins/chosen/chosen.min.css"); ?>">
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
                         Order 
                          <small> </small>
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
                                    <input type="hidden" id="sale_id" value="<?php echo $order->sale_id; ?>" />
                                    <div class="box-body">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                    <label class="">Order Date : <span class="text-danger">*</span></label> 
                                                    <input type="text" name="date" class="form-control" placeholder="dd-mm-yyyy" value="<?php echo date("d-m-Y",strtotime($order->on_date)); ?>" />    
                                            </div>
                                            <div class="form-group">
                                                    <label class="">Delivery Address : <span class="text-danger">*</span></label> 
                                                    <textarea name="address" class="form-control"><?php echo $order->delivery_address; ?></textarea>    
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <?php if(!empty($order->prescriotion_image)){
                                                    echo "<h4>Prescription Images :</h4>";
                                                    if($order->prescriotion_image->prescription_img1 != ""){ echo "<a href='".base_url("uploads/prescription/".$order->prescriotion_image->prescription_img1)."'><img src='".base_url("uploads/prescription/crop/small/".$order->prescriotion_image->prescription_img1)."' class='thumbnail col-md-3' /></a>"; };
                                                if($order->prescriotion_image->prescription_img2 != ""){ echo "<a href='".base_url("uploads/prescription/".$order->prescriotion_image->prescription_img2)."'><img src='".base_url("uploads/prescription/crop/small/".$order->prescriotion_image->prescription_img2)."' class='thumbnail col-md-3' /></a>"; };
                                                if($order->prescriotion_image->prescription_img3 != ""){ echo "<a href='".base_url("uploads/prescription/".$order->prescriotion_image->prescription_img3)."'><img src='".base_url("uploads/prescription/crop/small/".$order->prescriotion_image->prescription_img3)."' class='thumbnail col-md-3' /></a>"; }; 
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="pull-right">
                                                <table class="table table-striped">
                                                    <tr><th colspan="2">Customer Details</th></tr>
                                                    <tr><td>Name:</td><td><?php echo $order->user->user_fullname; ?></td></tr>
                                                    <tr><td>Phone:</td><td><?php echo $order->user->user_phone; ?></td></tr>
                                                    <tr><td>Email:</td><td><?php echo $order->user->user_email; ?></td></tr>
                                                </table>
                                            </div>
                                        </div>
                                        
                                    </div><!-- /.box-body --> 

                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="add_offer" value="Add" />
                                       
                                    </div>
                                </form>
                            </div><!-- /.box -->
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="">
                                        <h3>Order Items : 
                                            <a href="javascript:;" class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#add_product_modal" ><i class="glyphicon glyphicon-plus"></i> Add</a>
                                        </h3>
                                            <table class="table table-striped table-responsive">
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Discount(%)</th>
                                                    <th>Qty</th>
                                                    <th>Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                                <tbody id="item_list">
                                                    <?php foreach($order->items as $item){
                                                        $this->load->view("admin/orders/item_row",array("item"=>$item));
                                                    } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5">
                                                            
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                    </div>
                                </div>
                            </div>
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
    
    <div class="modal fade" id="add_product_modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Product</h4>
          </div>
          <div class="modal-body">
                <form action="" method="post">
                    <div id="error_log"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <select id="search_product" class="form-control" style="600px" name="search_product">
                            
                            </select> 
                        </div>
                        <div class="col-md-6">
                            <input type="number" name="qty" id="product_qty" class="form-control" />
                        </div>
                        <div class="col-md-12">
                            <div class="details"></div>
                        </div>
                    </div>
                </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" id="btn_add" class="btn btn-primary">Add</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
    
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/chosen/chosen.jquery.min.js"); ?>"></script>
    
    <!-- AdminLTE App -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/dist/js/app.min.js"); ?>"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/dist/js/demo.js"); ?>"></script>
        <!-- date-range-picker -->
 
    
    <script>
      $(function () {
         //Date range picker with time picker
        $("body").on("click",".btn_edit",function(){
            var id = $(this).data("id");
            $("#qty_"+id).show();
            $("#btn_save_"+id).show();
            $("#span_"+id).hide();
            
            $(this).hide();
        });
        $("body").on("click","#btn_add",function(){
           var prod = $("#search_product").val();
           var qty = $("#product_qty").val();
           if(prod == ""){
                $("#error_log").html("Please choose product");
            exit;
           }
           if(qty == ""){
                $("#error_log").html("Please enter Qty");
            exit;
           } 
           
           $.ajax({
              method: "POST",
              url: "<?php echo site_url("order/add_item"); ?>",
              data: { product_id: prod, qty: qty, sale_id : $("#sale_id").val() }
            })
              .done(function( msg ) {
                               $("#search_product").val("");
                               $("#product_qty").val("");
                               $('#add_product_modal').modal('hide'); 
                               $("#item_list").prepend(msg);
              });
           
        });
        $("body").on("click",".btn_save",function(){
            var id = $(this).data("id");
            var _this = $(this);            
            var qty = $("#qty_"+id).val();
            if(qty > 0){
            $.ajax({
              method: "POST",
              url: "<?php echo site_url("order/update_item"); ?>",
              data: { item_id: id, qty: qty }
            })
              .done(function( msg ) {
                                $("#qty_"+id).hide();
                                $("#btn_save_"+id).hide();
                                $("#btn_edit_"+id).show();
                                $("#span_"+id).show();
                                $("#span_"+id).html(qty);

              });
            }
        });
        
        $("body").on("click",".btn_delete",function(){
            var id = $(this).data("id");
            var _this = $(this);          
              
            if(confirm("Are you sure to delete?")){
            $.ajax({
              method: "POST",
              url: "<?php echo site_url("order/delete_item"); ?>",
              data: { item_id: id }
            })
              .done(function( msg ) {
                    $("#row_"+id).remove();
              });
            }
        });
        $('#add_product_modal').on('shown.bs.modal', function () {
            $("#search_product").chosen();  
        });
        
        $("body").on("change","#search_product",function(){
            var details_x = "";
            var opt = $(this).find(":selected");
            details_x += "Price :"+opt.data("price")+" / "+opt.data("unit_value")+" "+opt.data("unit");
            
            $("#add_product_modal .details").html(details_x);     
        });
        $.ajax({
              method: "POST",
              url: "<?php echo site_url("product/search"); ?>",
              data: {  }
            })
              .done(function( obj ) {
                $("#search_product").html("");
                $("#search_product").append("<option value=''>--Choose Product--</option>");
                $.each( obj, function( key, value ) {
                    
                    $("#search_product").append("<option value='"+value.product_id+"'  data-discount='"+value.discount+"'  data-in_stock='"+value.in_stock+"' data-unit='"+value.unit+"' data-unit_value='"+value.unit_value+"' data-price='"+value.price+"'>"+value.product_name+"</option>")
                    
                });
                $('#search_product').trigger("chosen:updated");
            });
      });
    </script>
  </body>
</html>
