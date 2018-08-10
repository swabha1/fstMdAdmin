<?php
class Zipcode_model extends CI_Model{
    protected $table_name;
    public function __construct()
    {
        parent::__construct();
        $this->table_name = 'zipcode';
    }
    function get_zipcode(){        
        $q = $this->db->query("select * from ".$this->table_name);
        return $q->result();
        
    }
   
    
}
?>