<?php  
class Notification_model extends CI_Model{
    protected $table_name;
    public function __construct()
    {
        parent::__construct();
        $this->table_name = 'notification';
    }
    function get_notification(){
        
        $q = $this->db->query("select * from .$this->table_name ORDER BY noti_id ASC");
        return $q->result();
        
    }
     public function get_notification_by_id($id){
            $q = $this->db->query("select * from .$this->table_name where noti_id ='".$id."' limit 0,1");
            return $q->row();
        }
    
}  
?>