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
             Orders
          </h1>
          
        </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('success_req'); ?>
                                    
                            <div class="box box-primary"> 
                                 
                                <div class="box-body">
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Order ID</th>                                                 
                                                <th> Date </th>
                                                <th> Address </th>
                                                <th> Total Items</th>
                                                <th> Total Amount</th>
                                                <th> Prescription Image</th>
                                                <th> Status </th> 
                                                <th class="text-center" style="width: 100px;"> Order Status </th>
                                                <th class="text-center" style="width: 100px;"> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($orders as $order){ ?>
                                            <tr> 
                                                <td><?php echo $order->sale_id; ?></td>
                                                <td><?php echo date("d-m-Y",strtotime($order->on_date)); ?></td>
                                                <td> <?php echo $order->delivery_address; ?></td>
                                                <td> <?php echo $order->total_items; ?></td>
                                                <td> <?php echo $order->total_amount; ?></td>
                                                <td> <?php if($order->prescription_img1 != ""){ echo "<a href='".base_url("uploads/prescription/".$order->prescription_img1)."'><i class='glyphicon glyphicon-picture'></i></a>"; };
                                                if($order->prescription_img2 != ""){ echo "<a href='".base_url("uploads/prescription/".$order->prescription_img2)."'><i class='glyphicon glyphicon-picture'></i></a>"; };
                                                if($order->prescription_img3 != ""){ echo "<a href='".base_url("uploads/prescription/".$order->prescription_img3)."'><i class='glyphicon glyphicon-picture'></i></a>"; }; ?></td>	
                                                <td>
                                                <?php if($order->status == 0){
                                                    echo "<span class='label label-default'>Pending</span>";
                                                }else if($order->status == 1){
                                                    echo "<span class='label label-success'>Confirm</span>";
                                                }else if($order->status == 2){
                                                    echo "<span class='label label-info'>Delivered</span>";
                                                }else if($order->status == 3){
                                                    echo "<span class='label label-danger'>Cancel</span>";
                                                }  ?>
                                                </td>
                                                <td> 
                                                    <div class="dropdown">
                                                      <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">  Action 
                                                      <span class="caret"></span></button>
                                                      <ul class="dropdown-menu">
                                                        <li><a href="<?php echo site_url("order/cancle_order/".$order->sale_id); ?>">  Cancel </a></li>
                                                            <?php if($order->status == 0){
                                                                            echo "<li><a href='".site_url("order/confirm_order/".$order->sale_id)."'>Confirm</a></li>";
                                                                        }else if($order->status == 1){
                                                                            echo "<li><a href='".site_url("order/delivered_order/".$order->sale_id)."'>Delivered</a></li>";
                                                                        }  ?>
                                                         
                                                      </ul>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                    <a href="<?php echo site_url("order/orderdetails/".$order->sale_id); ?>" class="btn btn-info"> <i class="fa fa-eye"></i></a>
                                                        <?php echo anchor('order/edit/'.$order->sale_id, '<i class="fa fa-edit"></i>', array("class"=>"btn btn-success")); ?>
                                                        <?php echo anchor('order/delete/'.$order->sale_id, '<i class="fa fa-times"></i>', array("class"=>"btn btn-danger", "onclick"=>"return confirm('Are you sure delete?')")); ?>
                                                     </div>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                    <!-- Main row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <?php  $this->load->view("admin/common/common_footer"); ?>  

     
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    
  </body>
</html>
