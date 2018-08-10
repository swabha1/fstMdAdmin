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
                       Manufacturer 
                    </h1> 
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('message'); ?>
                            <div class="box box-primary">
                                <div class="box-header"> 
                                    <a class="pull-right btn btn-primary" href="<?php echo site_url("manufacturer/add_manufacturer"); ?>">ADD</a>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>                              
                                                <th>Manufacturer Name</th>
                                                <th>Image</th> 
                                                <th class="text-center" style="width: 100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($manufacturer as $mfg){ ?>
                                            <tr>
                                                <td class="text-center"><?php echo $mfg->mfg_id; ?></td>
                                                <td><?php echo $mfg->mfg_name; ?></td>  
                                                <td><?php if($mfg->mfg_image!=""){ ?><div class="cat-img" style="width: 50px; height: 50px;"><img width="100%" height="100%" src="<?php echo $this->config->item('base_url').'uploads/manufacturer/'.$mfg->mfg_image; ?>" /></div> <?php } ?></td>
                                                <td class="text-center"><div class="btn-group">
                                                        <?php echo anchor('manufacturer/edit_products/'.$mfg->mfg_id, '<i class="fa fa-edit"></i>', array("class"=>"btn btn-success")); ?>
                                                        <?php echo anchor('manufacturer/delete_manufacturer/'.$mfg->mfg_id, '<i class="fa fa-times"></i>', array("class"=>"btn btn-danger", "onclick"=>"return confirm('Are you sure delete?')")); ?>
                                                        
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
