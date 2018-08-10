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
            App Registers
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
                                     <table class="table data_table" id="select2">
                                        <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>Name</th> 
                                            <th>Phone  </th>
                                            <th>User Email </th>
                                            <th>User Birthdate </th> 
                                            <th>User Image </th>
                                            <th>Status</th>
                                            
                                        </tr>
                                        </thead>
                                  <tbody>
                                  <?php
                                  foreach($users as $user)
                                  {
                                    
                                    ?>
                                   
                                        <tr>
                                            
                                            <td><?php echo $user->user_id; ?></td>
                                            <td><?php echo $user->user_fullname; ?></td> 
                                            <td><?php echo $user->user_phone; ?></td>
                                            <td><?php echo $user->user_email; ?></td>
                                            <td><?php echo $user->user_bdate; ?></td> 
                                            <td><?php echo $user->user_image; ?></td>
                                            <td><input class='tgl tgl-ios tgl_checkbox' data-table="users" data-status="status" data-idfield="user_id"  data-id="<?php echo $user->user_id; ?>" id='cb_<?php echo $user->user_id; ?>' type='checkbox' <?php echo ($user->user_status==1)? "checked" : ""; ?> />
                            <label class='tgl-btn' for='cb_<?php echo $user->user_id; ?>'></label></td>
                                            <td>
                                            </td>
                                        </tr>
                                    <?php
                                  }
                                  ?>
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
