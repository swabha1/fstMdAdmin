<?php
class Offer_model extends CI_Model{
    protected $table_name;
    public function __construct()
    {
        parent::__construct();
        $this->table_name = 'offer';
    }
    function get_offer(){        
        $q = $this->db->query("select * from ".$this->table_name);
        return $q->result();
        
    }
    function get_offer_by_id($offer_id){
            $q = $this->db->query("Select * from offer  
            where offer_id= '".$offer_id."' limit 1");
            return $q->row(); 
      }
       
    
}
?>