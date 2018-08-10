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
                        Add Products
                        <small>Preview</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                        <li><a href="#">Products</a></li>
                        <li class="active">Add Products</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-6">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('message'); ?>
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Add Products</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="">Product Title : <span class="text-danger">*</span></label> 
                                                    <input type="text" name="prod_title" class="form-control" placeholder="Product Title"/>    
                                         </div>
                                        <div class="form-group">
                                            <label class="">Product Category : <span class="text-danger">*</span></label>
                                            <select class="text-input form-control" name="parent">
                                                <option value="">Select Category</option>
                                                <?php  
                                                    echo printCategory(0,0,$this);
                                                    function printCategory($parent,$leval,$th){
                                                    
                                                    $q = $th->db->query("SELECT a.*, Deriv1.count FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` WHERE a.`status`=1 and a.`parent`=" . $parent);
                                                    $rows = $q->result();
                            
                                                    foreach($rows as $row){
                                                        if ($row->count > 0) {
                                                				
                                                                    //print_r($row) ;
                                                					//echo "<option value='$row[id]_$co'>".$node.$row["alias"]."</option>";
                                                                    printRow($row,true);
                                               					    printCategory($row->id, $leval + 1,$th);
                                                					
                                                				} elseif ($row->count == 0) {
                                                					printRow($row,false);
                                                                    //print_r($row);
                                                				}
                                                        }
                            
                                                    }
                                                     
                                                    function printRow($d,$bool){
                                                          
                                                   // foreach($data as $d){
                                                    ?>
                                                    <option value="<?php echo $d->id; ?>" <?php if($d->parent == "0" && $d->leval == "0" && $bool){echo "disabled";} ?> <?php if(isset($_REQUEST["parent"]) && $_REQUEST["parent"]==$d->id){echo "selected"; } ?> ><?php for($i=0; $i<$d->leval; $i++){ echo "_"; } echo $d->title; ?></option>
                                                        
                                                     <?php } ?> 
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="manufacturer">Manufacturer <span class="red">*</span></label>
                                            <select class="form-control" name="manufacturer" id="manufacturer" style="width: 100%;">
                                               <option value="">Select Manufacturer</option>
                                                <?php foreach($manufacturer as $mfg){
                                                    ?>
                                                    <option value="<?php echo $mfg->mfg_id; ?>"><?php echo $mfg->mfg_name; ?></option>
                                                    <?php
                                                } ?>
                                            </select> 
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Product Image: </label>
                                            <input type="file" name="prod_img" />
                                        </div>
                                        
                                         
                                        
                                        <div class="form-group">
                                            <div class="checkbox">
                                              <label for="isgeneric">
                                                <input type="checkbox" id="isgeneric" name="isgeneric"  /> Is Generic
                                              </label>
                                            </div>
                                              <p class="help-block">(Product Is Generic OR Not.)</p>
                                        </div>
                                        
                                        <div class="form-group"> 
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="prod_status" id="optionsRadios1" value="1" checked/>
                                                    In Stock
                                                </label>
                                            </div>
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="prod_status" id="optionsRadios2" value="0"/>
                                                    Out of stock
                                                </label>
                                            </div>
                                            <p class="help-block">(Product Status.)</p>
                                        </div>
                                    
                                        
                                        <div class="form-group">
                                            <label class="">Price : <span class="text-danger">*</span></label>
                                            <input type="text" name="price" class="form-control" placeholder="00.00"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Qty : <span class="text-danger">*</span></label>
                                            <input type="text" name="qty" class="form-control"  placeholder="00"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Unit : <span class="text-danger">*</span></label>
                                           
                                                    <input type="text" name="unit" class="form-control" placeholder="KG/ BAG/ NOS/ QTY / etc "/>    
                                                
                                        </div>
                                        
                                       
                                        
                                    </div><!-- /.box-body -->

                                        

                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="addcatg" value="Add Product" />
                                       
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
