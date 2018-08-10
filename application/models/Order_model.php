<?php
class Order_model extends CI_Model{
    protected $table_name;
    protected $table_items;
    protected $table_prescription;
    protected $table_prescription_item;
    public function __construct()
    {
        parent::__construct();
        $this->table_name = 'sale';
        $this->table_items = 'sale_items';
        $this->table_prescription = 'sale_prescription';
        $this->table_prescription_item = 'sale_prescription_items';
    }
    function get_orders($parms=array()){
        $filter = "";
        if(!empty($parms)){
            foreach($parms as $key=>$val){
                if(trim($val) != ""){
                    $filter .= " and ".trim($key)." = '".trim($val)."' ";    
                }
            }
        }
        $q = $this->db->query("select $this->table_name.*, ifnull(items.total_items , 0) as total_items, $this->table_prescription.prescription_img1, $this->table_prescription.prescription_img2, $this->table_prescription.prescription_img3, user_delivery_address.* from ".$this->table_name." 
        left outer join $this->table_prescription on $this->table_prescription.sale_id = $this->table_name.sale_id
        left outer join (select count(*) as total_items, sale_id from $this->table_items group by sale_id) as items on items.sale_id = $this->table_name.sale_id
        left outer join user_delivery_address on user_delivery_address.delivery_id =  $this->table_name.delivery_id
        where 1 $filter order by $this->table_name.on_date desc
        ");
        return $q->result();
        
    }
    
    function get_today_order($date){
        $q = $this->db->query("select $this->table_name.*, ifnull(items.total_items , 0) as total_items, $this->table_prescription.prescription_img1, $this->table_prescription.prescription_img2, $this->table_prescription.prescription_img3, user_delivery_address.* from ".$this->table_name." 
        left outer join $this->table_prescription on $this->table_prescription.sale_id = $this->table_name.sale_id
        left outer join (select count(*) as total_items, sale_id from $this->table_items group by sale_id) as items on items.sale_id = $this->table_name.sale_id
        left outer join user_delivery_address on user_delivery_address.delivery_id =  $this->table_name.delivery_id
        where  $this->table_name.order_date= '".$date."' order by $this->table_name.on_date desc
        ");
        return $q->result();
    }
    
    function get_order_by_id($id){
            $q = $this->db->query("Select * from $this->table_name  
            where sale_id= '".$id."' limit 1");
            $order = $q->row();
            $order->prescriotion_image = $this->get_order_prescription($order->sale_id);
            $order->items = $this->get_order_items($order->sale_id);
            $order->user = $this->users_model->get_user_by_id($order->user_id);
            
            return $order; 
    }
    function get_order_items($id){
        $q = $this->db->query("Select * from $this->table_items
            left outer join products on products.product_id = $this->table_items.product_id  
            where $this->table_items.sale_id= '".$id."'");
            $order = $q->result();
            return $order;
    }
    function get_order_item_by_id($id){
        $q = $this->db->query("Select * from $this->table_items
            left outer join products on products.product_id = $this->table_items.product_id  
            where $this->table_items.sale_item_id= '".$id."'");
            $order = $q->row();
            return $order;
    }
    
    function get_order_prescription($id){
        $q = $this->db->query("Select * from $this->table_prescription 
            where $this->table_prescription.sale_id= '".$id."' limit 1");
            $order = $q->row();
            return $order;
    }

    
}
?>