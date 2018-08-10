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
                          Edit Products  
                    </h1> 
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-6">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('message'); ?>
                            <!-- general form elements -->
                            <div class="box box-primary"> 
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class=""> Product Title :  <span class="text-danger">*</span></label>
                                            <input type="text" name="prod_title" class="form-control" value="<?php echo $product->product_name; ?>" placeholder="Product Title"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Product Category : <span class="text-danger">*</span></label>
                                            <select class="text-input form-control" name="parent">
                                                <option value="">Select Category</option>
                                                 <?php  
                                                    echo printCategory(0,0,$this,$product);
                                                    function printCategory($parent,$leval,$th,$product){
                                                    
                                                    $q = $th->db->query("SELECT a.*, Deriv1.count FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` WHERE a.`status`=1 and a.`parent`=" . $parent);
                                                    $rows = $q->result();
                            
                                                    foreach($rows as $row){
                                                        if ($row->count > 0) {
                                                				
                                                                    //print_r($row) ;
                                                					//echo "<option value='$row[id]_$co'>".$node.$row["alias"]."</option>";
                                                                    printRow($row,$product,true);
                                               					    printCategory($row->id, $leval + 1,$th,$product);
                                                					
                                                				} elseif ($row->count == 0) {
                                                					printRow($row,$product,false);
                                                                    //print_r($row);
                                                				}
                                                        }
                            
                                                    }
                                                    function printRow($d,$product,$bool){
                                                        
                                                   // foreach($data as $d){
                                                    
                                                    ?>
                                                       <option value="<?php echo $d->id; ?>" <?php if($product->category_id == $d->id){ echo "selected"; } ?> ><?php for($i=0; $i<$d->leval; $i++){ echo "_"; } echo $d->title; ?></option>
                                                         
                                                     <?php } ?> 
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Product Image:  </label>
                                            <input type="file" name="prod_img" />
                                        </div>
                                        <div class="form-group"> 
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="prod_status" id="optionsRadios1" value="1"  <?php if($product->in_stock == 1){ echo "checked"; } ?> />
                                                    In Stock
                                                </label>
                                            </div>
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="prod_status" id="optionsRadios2" value="0" <?php if($product->in_stock == 0){ echo "checked"; } ?> />
                                                    Out of stock
                                                </label>
                                            </div>
                                            <p class="help-block">Product Status.</p>
                                        </div>
                                    </div><!-- /.box-body -->
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="">Price : <span class="text-danger">*</span></label>
                                            <input type="text" name="price" class="form-control" value="<?php echo $product->price; ?>" placeholder="00.00"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Qty : <span class="text-danger">*</span></label>
                                            <input type="text" name="qty" class="form-control" value="<?php echo $product->unit_value; ?>"  placeholder="00"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Unit : <span class="text-danger">*</span></label>                                           
                                            <input type="text" name="unit" class="form-control "value="<?php echo $product->unit; ?>" placeholder="KG/ BAG/ NOS/ QTY / etc "/>    
                                               
                                        </div>
                                        
                                         
                                    </div>
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
