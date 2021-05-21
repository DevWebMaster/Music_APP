<?php
/**
 * Created by PhpStorm.
 * User: CStar
 * Date: 1/20/2018
 * Time: 4:41 AM
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Response_model extends CI_Model
{
    public $table_name = 'response';

    public function addNewResponse($data)
    {
        $result = $this->db->insert($this->table_name,$data);
        return $result;
    }

    public function getLastRow()
    {
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $query = $this->db->get($this->table_name);
        $result = $query->result_array();
        return $result;
    }

    public function getResponse($image_id)
    {
        $this->db->where('id',$image_id);
        $query =  $this->db->get($this->table_name);
        $result = $query->result_array();
        return $result;
    }

    public function getAllResponse()
    {
        $this->db->order_by('id','asc');
        $query = $this->db->get($this->table_name);
        $result = $query->result_array();
        return  $result;
    }

    public function updateResponse($data, $where){
        $this->db->where($where);
        $result = $this->db->update($this->table_name,$data);

        return $result;
    }

    public function deleteResponse($id)
    {
        $this->db->where('id',$id);
        $this->db->delete($this->table_name);
    }

    public function searcResponse($search)
    {
        $this->db->like('name',$search);
        $this->db->order_by('id','asc');
        $query = $this->db->get($this->table_name);
        $result = $query->result_array();
        return  $result;
    }

}