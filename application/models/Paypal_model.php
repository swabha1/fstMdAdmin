<?php
class Paypal_model extends CI_Model{
    protected $table_name;
    public function __construct()
    {
        parent::__construct();
        $this->table_name = 'paypal';
    }
    function get_paypal(){        
        $q = $this->db->query("select * from ".$this->table_name);
        return $q->row();
        
    }
    function get_paypal_by_id($paypal_id){
            $q = $this->db->query("Select * from ".$this->table_name."  
            where offer_id= '".$offer_id."' limit 1");
            return $q->row(); 
      }
    
    
}
?>