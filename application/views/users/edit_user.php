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
            Users
            <small> Manage Users </small>
          </h1>
          
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                           
                        </div>
                        <div class="box-body">
                        
                            <form role="form" action="" method="post">
                              <div class="box-body">
                              <?php 
                                echo $this->session->flashdata("message");
                               ?>
                                <div class="form-group">
                                    <div class="row">
                                    <div class="col-md-6">
                                        <label for="user_fullname"> Full Name  </label>
                                        <input type="text" class="form-control" id="user_fullname" value="<?php echo $user->user_fullname; ?>" name="user_fullname" placeholder="User Full Name" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="user_email">  User Email </label>
                                        <input type="email" class="form-control" id="user_email" disabled="" readonly=""  value="<?php echo $user->user_email; ?>"  name="user_email" placeholder="user@gmail.com" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="user_password"> Password  </label>
                                        <input type="password" class="form-control" id="user_password"  value="<?php echo $user->user_password; ?>"  name="user_password" placeholder="password" />
                                    </div>
                                   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                      <label for="status">
                                        <input type="checkbox" id="status" name="status"   <?php echo ($user->user_status == 1) ? "checked" : ""; ?>  />  <?php echo $this->lang->line("Status");?>
                                      </label>
                                    </div>
                                </div>
                              </div><!-- /.box-body -->
            
                              <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </div>
                            </form>
                        </div>
                    </div>
                </div>
               
                
            </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
      <?php  $this->load->view("admin/common/common_footer"); ?>  

      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
 
    
  </body>
</html>
