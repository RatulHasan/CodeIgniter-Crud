<?php
/**
 * Author= Ratul Hasan
 * email: ratuljh@gmail.com
 */
class Create_crud_Model  extends CI_Model {

    public function get_table_info($table_name){
        $database=$this->db->database;
        $this->db->select("*");
        $this->db->from("`INFORMATION_SCHEMA`.`COLUMNS`");
        $this->db->where("TABLE_SCHEMA",$database);
        $this->db->where("TABLE_NAME",$table_name);
        $query_result=$this->db->get();
        $result=$query_result->result();
        return $result;
    }

}
