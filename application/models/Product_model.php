<?php
class Product_model extends CI_Model{
    
      function get_products($in_stock=false,$cat_id="",$search="", $page = ""){
            $filter = "";
            $limit = ""; 
            if($page != ""){
            	$from = $page * 8; 
            	$limit .=" limit ".$from.", 8";	
            } 
            if($in_stock){
                $filter .=" and products.in_stock = 1 ";
            }
            if($cat_id!=""){
                $filter .=" and products.category_id = '".$cat_id."' ";
            }
             if($search!=""){
                $filter .=" and products.product_name like '%".$search."%'";
            }
            $q = $this->db->query("Select products.*,( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title,manufacturer.mfg_name from products 
            inner join categories on categories.id = products.category_id
            inner join manufacturer on manufacturer.mfg_id = products.mfg_id
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            where 1 ".$filter." ORDER BY product_name ASC ".$limit);
            $products = $q->result(); 
            return $products; 
      }
       function get_sale_by_user($user_id){
            $q = $this->db->query("Select * from sale where user_id = '".$user_id."' and status != 3 ORDER BY sale_id DESC");
            return $q->result();
      }
      function get_sale_order_items($sale_id){
        $q = $this->db->query("Select sale_items.*,products.product_image, products.product_name from sale_items 
        inner join products on products.product_id = sale_items.product_id
        where sale_id = '".$sale_id."'");
            return $q->result();
      }
      function get_prescription_by_user($user_id){
            $q = $this->db->query("Select sale_prescription.*,user_delivery_address.* from sale_prescription
             inner join user_delivery_address on user_delivery_address.delivery_id = sale_prescription.delivery_id
             where sale_prescription.user_id = '".$user_id."' and status != 3 ORDER BY sale_id DESC");
            return $q->result();
      }
       function get_suggest_products(){
         $q = $this->db->query("Select products.*,( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title,manufacturer.mfg_name from products 
            inner join categories on categories.id = products.category_id
            inner join manufacturer on manufacturer.mfg_id = products.mfg_id
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            ORDER BY RAND() LIMIT 5");
            return $q->result(); 
      }
      function get_suggest_details_page_products($cat_id){
             
         $q = $this->db->query("Select products.*,( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title,manufacturer.mfg_name from products 
            inner join categories on categories.id = products.category_id
            inner join manufacturer on manufacturer.mfg_id = products.mfg_id
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            where products.category_id = '".$cat_id."' ORDER BY RAND() LIMIT 6");
            $products = $q->result(); 
            return $products; 
      }
      
      
      
      
      
      
      function get_product_by_id($prod_id){
            $q = $this->db->query("Select products.*, categories.title from products 
            inner join categories on categories.id = products.category_id
            where 1 and products.product_id = '".$prod_id."' limit 1");
            return $q->row(); 
      }
       
      function get_product_price($in_stock=false,$prod_id=""){
            $filter = "";
            if($in_stock){
                $filter .=" and products.in_stock = 1 ";
            }
            if($prod_id!=""){
                $filter .=" and products.product_id = '".$prod_id."' ";
            }
            $q = $this->db->query("Select product_price.* from product_price 
            inner join products on products.product_id = product_price.product_id 
            where 1 ".$filter);
            return $q->result();
      }
        
      function get_prices_by_ids($ids){
            $q = $this->db->query("Select product_price.* from product_price 
            where 1 and price_id in (".$ids.")");
            return $q->result();
      }
      
      function get_price_by_id($price_id){
        $q = $this->db->query("Select * from product_price 
            where 1 and price_id = '".$price_id."'");
            return $q->row();
      }
      function get_socity_by_id($id){
        $q = $this->db->query("Select * from socity 
            where 1 and socity_id = '".$id."'");
            return $q->row();
      }
      function get_socities(){
        
        $q = $this->db->query("Select * from socity");
            return $q->result();
      }
      
      function get_sale_orders($filter=""){
         $sql = "Select distinct sale.*,users.user_fullname,users.user_phone,users.pincode,users.socity_id,users.house_no from sale 
            inner join users on users.user_id = sale.user_id 
            where 1 ".$filter." ORDER BY sale_id DESC";
            $q = $this->db->query($sql);
            return $q->result();
      }
      
      function get_sale_order_by_id($order_id){
            $q = $this->db->query("Select distinct sale.*,users.user_fullname,users.user_email,users.user_phone,users.pincode,users.user_address,users.user_city,users.house_no, user_delivery_address.delivery_zipcode, user_delivery_address.delivery_landmark, user_delivery_address.delivery_fullname,user_delivery_address.delivery_city, user_delivery_address.delivery_mobilenumber from sale 
            inner join users on users.user_id = sale.user_id
            left outer join user_delivery_address on user_delivery_address.delivery_id = sale.delivery_id 
            where sale_id = ".$order_id." limit 1");
            return $q->row();
      }
      
      
      function get_leftstock(){
        $q = $this->db->query("Select products.*,( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock from products 
        left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            ");
        return $q->result();
      }
      
      function get_all_users(){
         $sql = "Select registers.*, ifnull(sale_order.total_amount, 0) as total_amount,total_orders  from registers 
            
            left outer join (Select sum(total_amount) as total_amount, count(sale_id) as total_orders, user_id from sale group by user_id) as sale_order on sale_order.user_id = registers.user_id
            where 1 order by user_id DESC";
            $q = $this->db->query($sql);
            
            return $q->result();
      }
      
       function get_prescription_order_item($sale_id){
        $q = $this->db->query("Select * from sale_prescription_items 
            where sale_id = '".$sale_id."'");
            return $q->result();  
      }
}
?>