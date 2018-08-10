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
                                            <input type="text" name="zipcode" class="form-control" placeholder="123456"/>
                                        </div>
                                         <div class="form-group">
                                            <label class="">Delivery Charge : <span class="text-danger">*</span> </label>
                                            <input type="number" name="delivery_charge" class="form-control" placeholder="00"/>
                                        </div>
                                    </div><!-- /.box-body --> 
                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="add_zipcode" value="Add" />                                       
                                    </div>
                                </form>
                            </div><!-- /.box -->
                        </div>
                        <div class="col-xs-6">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('message'); ?>
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Zipcode List</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th> 
                                                <th>Zip / Area code :</th>
                                                <th>Delivery Charge</th>
                                                <th class="text-center" style="width: 100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($zipcode as $zip){ ?>
                                            <tr>
                                                <td class="text-center"><?php echo $zip->zipcode_id; ?></td> 
                                                <td><?php echo $zip->zipcode; ?></td>
                                                  <td><?php echo $zip->delivery_charge; ?></td>
                                                <td class="text-center"><div class="btn-group">
                                                        <?php echo anchor('zipcode/edit_zipcode/'.$zip->zipcode_id, '<i class="fa fa-edit"></i>', array("class"=>"btn btn-success")); ?>
                                                        <?php echo anchor('zipcode/delete_zipcode/'.$zip->zipcode_id, '<i class="fa fa-times"></i>', array("class"=>"btn btn-danger", "onclick"=>"return confirm('Are you sure delete?')")); ?>
                                                        
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
        </div><!-- /.content-wrapper -->
      
      <?php  $this->load->view("admin/common/common_footer"); ?>  

      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

   
  </body>
</html>
