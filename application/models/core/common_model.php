<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fenglangyj
 * Date: 13-5-29
 * Time: 下午7:03
 * To change this template use File | Settings | File Templates.
 */
class Common_model extends MY_Model
{
    private  $_table = '';

    function __construct()
    {
        //$this->load->database();
        parent::__construct();
    }

    public function _list()
    {
        $query = $this->db->get();
        return $query->result_array();
    }

    public function _list_fields()
    {
        $fields = $this->db->list_fields($this->_table);
        return $fields;
    }

    public function _field_data()
    {
        return $this->db->field_data($this->_table);
    }

    public function _insert($data)
    {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }
    public function _from($table){
        $this->db->from($table);
        $this->_table = $table;
        return $this;
    }

    public function _delete($where){
        $this->db->delete(null,$where);
        return $this->db->affected_rows();
    }
    public function _row($where){
        $query = $this->db->get_where(null,$where,1);
        $row = $query->row_array();
        return $row;
    }
    public function _update($where,$data){
        $this->db->where($where);
        $this->db->update($this->_table,$data);
        return $this->db->affected_rows();
    }
    public function _map($map){
        foreach($map as $key=>$data){
            $this->db->{$key}($data);
        }
        return $this;
    }
    public function _limit($limit, $offset){
        $this->db->limit($limit,$offset);
        return $this;
    }
    public function _count(){
        $numrows = $this->db->count_all_results();
        //echo $this->db->last_query();
        return $numrows;
    }
    public function _order_by($orderField,$orderDirection){
        $this->db->order_by($orderField,$orderDirection);
        return $this;
    }

    /**
     * 获取主键
     * @return mixed
     */
    public function _get_pk(){
        $list_fields =$this->_list_fields($this->_table);
        return $list_fields[0];
    }
    /*function update_entry()
    {
        $this->title = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date = time();
        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }*/

}
