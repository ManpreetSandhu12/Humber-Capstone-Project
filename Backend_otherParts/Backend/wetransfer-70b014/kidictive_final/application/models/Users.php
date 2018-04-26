<?php

Class Users extends CI_Model
{    
	public function Insert_data($table,$post_data)
    {           
        $this->db->insert($table, $post_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function select_where($table,$con)
    {
        $query = $this->db->get_where($table, $con);
        return $query;
    }
    
    public function update_where($table,$data,$con)
    {
        $this->db->update($table, $data, $con);
        $query= $this->db->trans_complete();
        return $query;
    }
        
    public function delete_where($table,$con)
    {
        $query= $this->db->delete($table, $con);
        return $query;
    }

    public function countRow($table, $parent_id){
    	$query = $this->db->query("SELECT * FROM `child` WHERE parent_id='".$parent_id."'");
		return $query;
    }
	
	public function countVideoRow($table, $parent_id, $child_id){
    	$query = $this->db->query("SELECT * FROM `video` WHERE parent_id='".$parent_id."' AND child_id='".$child_id."'");
		return $query;
    }

    public function generatePIN($digits = 4){
        $i = 0; //counter
        $pin = ""; //our default pin is blank.
        
        while($i < $digits){
        	//generate a random number between 0 and 9.
            $pin .= mt_rand(0, 9);
            $i++;
        }
        return $pin;
    }
}

?>

