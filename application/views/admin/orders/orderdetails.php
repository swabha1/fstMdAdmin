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
             Order Details
          </h1>
           <div class="pull-right">
                        <input type="button" value="Print" onclick="window.print()" class="con_txt2 non-print" />
                    </div>
        </section>

                <!-- Main content -->
                <section class="content">
                   
                    <div class="row">
                        <div class="col-xs-12">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('success_req'); ?>
                                    
                            <div class="box box-primary"> 
                                 
                                <div class="box-body">
                                      <table class="table table-bordered data_table">
                                <thead>
                                    <tr>
                                        <th colspan="3"><h3 style="text-align: center;"><?php echo $this->config->item("company_title");?></h3></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="3">
                                        <table class="table">
                                            <tr>
                                                <td valign="top">
                                                                <strong>Order Id : <?php echo $order->sale_id; ?></strong>
                                                                        <br />
                                                                        <strong>Order Date : <?php echo $order->on_date; ?></strong>
                                                                        <br /> <br />
                                                                        <strong>User Details :</strong><br />
                                                                         <strong>User Name :</strong> <?php echo $order->user_fullname ; ?><br />
                                                                         <strong>User Email :</strong> <?php echo $order->user_email ; ?><br />
                                                                        <strong>Phone :</strong> <?php echo $order->user_phone; ?><br />
                                                                        <strong>Address :</strong> <?php echo $order->user_address; ?><br />
                                                                        <strong>City Name :</strong> <?php echo $order->user_city; ?><br />
                                                </td>
                                                <td>
                                                    <strong>Delivery Details :</strong><br />
                                                    <strong>Name :</strong> <?php echo $order->delivery_fullname ; ?><br />
                                                    <strong>Mobile :</strong> <?php echo $order->delivery_mobilenumber ; ?><br />
                                                     <strong>Landmark :</strong> <?php echo $order->delivery_landmark ; ?><br /> 
                                                    <strong>Address :</strong> <?php echo $order->delivery_address; ?> <br />
                                                     <strong>Zipcode / Area code :</strong> <?php echo $order->delivery_zipcode; ?><br />
                                                      <strong>City :</strong> <?php echo $order->	delivery_city; ?></p>
                                              </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>Total Price <?php echo $this->config->item("currency");?></th>
                                </tr>
                                <?php
                                $total_price = 0;
                                foreach($order_items as $items){
                                    ?>
                                    <tr>
                                        <td><?php echo $items->product_name; ?><br />
  <br/>
                                        <?php echo $items->unit_value." ".$items->unit. " (".$this->config->item("currency")." $items->price ) "; ?>
                                        </td>
                                        <td>
                                            <?php echo $items->qty ; ?>
                                        </td>
                                        <td>
                                            <?php echo $items->qty * $items->price;
                                            $total_price = $total_price + ($items->qty * $items->price);
                                             ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="2"><strong class="pull-right">Total :</strong></td>
                                    <td >
                                        <strong class=""><?php echo $total_price; ?> <?php echo $this->config->item("currency");?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong class="pull-right">Delivery Charges :</strong></td>
                                    <td >
                                        <strong class=""><?php echo $order->delivery_charge; ?> <?php echo $this->config->item("currency");?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong class="pull-right">Net Total Amount :</strong></td>
                                    <td >
                                        <strong class=""><?php echo $net = $total_price + $order->delivery_charge; ?> <?php echo $this->config->item("currency");?></strong>
                                    </td>
                                </tr>
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
