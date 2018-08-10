<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo base_url("img/user2-160x160.jpg"); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php _get_current_user_name($this); ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu"> 
            
            <?php if(_get_current_user_type_id($this)==1){ ?> 
            <li class="<?php echo _is_active_menu($this,array("admin"),array("dashboard")); ?>">
              <a href="<?php echo site_url("admin/dashboard"); ?>">
                <i class="fa fa-dashboard"></i> <span>  Dashboard </span>  
              </a>
            </li>
             <li class="<?php echo _is_active_menu($this,array("slider"),array("index")); ?>">
              <a href="<?php echo site_url("slider/index"); ?>">
                <i class="fa fa-picture-o"></i> <span> Slider </span> <small class="label pull-right bg-green"></small>
              </a>
            </li>  
            <li class="<?php echo _is_active_menu($this,array("register"),array("index")); ?>">
              <a href="<?php echo site_url("register/index"); ?>">
                <i class="fa fa-users"></i> <span> App Registers </span> <small class="label pull-right bg-green"></small>
              </a>
            </li> 
            <li class="<?php echo _is_active_menu($this,array("categories"),array("index")); ?>">
              <a href="<?php echo site_url("categories/index"); ?>">
                <i class="fa fa-bars"></i> <span> Categories</span> <small class="label pull-right bg-green"></small>
              </a>
            </li>  
            <li class="<?php echo _is_active_menu($this,array("manufacturer"),array("index")); ?>">
              <a href="<?php echo site_url("manufacturer/index"); ?>">
                <i class="fa fa-industry"></i> <span> Manufacturer</span> <small class="label pull-right bg-green"></small>
              </a>
            </li>  
            <li class="<?php echo _is_active_menu($this,array("product"),array("index")); ?>">
              <a href="<?php echo site_url("product/index"); ?>">
                <i class="fa fa-outdent"></i> <span> Products </span> <small class="label pull-right bg-green"></small>
              </a>
            </li>  
             <li class="<?php echo _is_active_menu($this,array("order"),array("index")); ?>">
              <a href="<?php echo site_url("order/index"); ?>">
               <i class="fa fa-shopping-cart"></i> <span> Order </span> <small class="label pull-right bg-green"></small>
              </a>
            </li>  
           
             <li class="<?php echo _is_active_menu($this,array("offer"),array("index")); ?>">
              <a href="<?php echo site_url("offer/index"); ?>">
                <i class="fa fa-tags"></i> <span> Offer </span> <small class="label pull-right bg-green"></small>
              </a>
            </li>   
            <li class="<?php echo _is_active_menu($this,array("zipcode"),array("add_zipcode")); ?>">
              <a href="<?php echo site_url("zipcode/add_zipcode"); ?>">
                <i class="fa fa-map-signs"></i> <span> Zip/Area Code </span> <small class="label pull-right bg-green"></small>
              </a>
            </li> 
            <li class="<?php echo _is_active_menu($this,array("paypal"),array("index")); ?>">
              <a href="<?php echo site_url("paypal"); ?>">
                <i class="fa fa-paypal"></i> <span> Paypal </span> <small class="label pull-right bg-green"></small>
              </a>
            </li> 
             <li class="<?php echo _is_active_menu($this,array("notification"),array("index")); ?>">
              <a href="<?php echo site_url("notification"); ?>">
                <i class="fa fa-bell"></i> <span> Notification </span> <small class="label pull-right bg-green"></small>
              </a>
            </li> 
            <?php  } ?>
             
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>