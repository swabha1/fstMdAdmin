<?php
class manufacturer_model extends CI_Model{
    
      function get_manufacturer_list(){
        $q = $this->db->query("Select * from manufacturer");
            return $q->result();
            
      } 
}
?>