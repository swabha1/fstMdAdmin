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
                         Edit Categories  
                    </h1> 
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-6">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('success_req'); ?>
                            <!-- general form elements -->
                            <div class="box box-primary">
                                 
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="">  Categories Title :  <span class="text-danger">*</span></label>
                                            <input type="text" name="cat_title" class="form-control" placeholder="Categories Title" value="<?php echo $getcat->title; ?>"/>
                                            <input type="hidden" name="cat_id" class="form-control" placeholder="Categories id" value="<?php echo $getcat->id; ?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="">  Parent Category :  <span class="text-danger">*</span></label>
                                            <select class="text-input form-control" name="parent">
                                                <option value="0">  No Parent</option>
                                                <?php  
                                                    echo printCategory(0,0,$this,$getcat);
                                                    function printCategory($parent,$leval,$th,$getcat){
                                                    
                                                    $q = $th->db->query("SELECT a.*, Deriv1.count FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` WHERE a.`parent`=" . $parent);
                                                    $rows = $q->result();
                            
                                                    foreach($rows as $row){
                                                        if ($row->count > 0) {
                                                				
                                                                    //print_r($row) ;
                                                					//echo "<option value='$row[id]_$co'>".$node.$row["alias"]."</option>";
                                                                    printRow($row,$getcat);
                                               					   // printCategory($row->id, $leval + 1,$th,$getcat);
                                                					
                                                				} elseif ($row->count == 0) {
                                                					printRow($row,$getcat);
                                                                    //print_r($row);
                                                				}
                                                        }
                            
                                                    }
                                                    function printRow($d,$getcat){
                                                        
                                                   // foreach($data as $d){
                                                    
                                                    ?>
                                                     <option value="<?php echo $d->id; ?>" <?php if($getcat->parent == $d->id){ echo 'selected=""';} ?> ><?php for($i=0; $i<$d->leval; $i++){ echo "_"; } echo $d->title; ?></option>
                                                        
                                                     <?php } ?> 
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class=""> Categories Description :</label>
                                            <textarea name="cat_descri" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $getcat->description; ?></textarea>
                                            <p class="help-block"> Categories Description.</p>
                                        </div>
                                        <div class="form-group">
                                            <label> Categories Image: </label>
                                            <div class="cat-img pull-right" style="width: 50px; height: 50px;"><img width="100%" height="100%" src="<?php echo $this->config->item('base_url').'uploads/category/'.$getcat->image ?>" /></div>
                                            <input type="file" name="cat_img" />
                                        </div>
                                        <div class="form-group"> 
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="cat_status" id="optionsRadios1" value="1"  <?php if($getcat->status == 1){ echo 'checked=""'; } ?> />
                                                     Actvie
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="cat_status" id="optionsRadios2" value="0" <?php if($getcat->status == 0){ echo 'checked=""'; } ?> />
                                                     Deactive 
                                                </label>
                                            </div>
                                            <p class="help-block"> Set Categories Status.</p>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="savecat" value="Save Category" />
                                       
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
