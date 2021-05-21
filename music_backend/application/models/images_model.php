<?php
/**
 * Created by PhpStorm.
 * User: CStar
 * Date: 1/20/2018
 * Time: 4:41 AM
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Images_model extends CI_Model
{
    public $table_name = 'image_list';

    public function addNewImage($data)
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

    public function getImage($image_id)
    {
        $this->db->where('id',$image_id);
        $query =  $this->db->get($this->table_name);
        $result = $query->result_array();
        return $result;
    }

    public function getAllImages()
    {
        $this->db->order_by('id','asc');
        $query = $this->db->get($this->table_name);
        $result = $query->result_array();
        return  $result;
    }

    public function updateImage($data, $where){
        $this->db->where($where);
        $result = $this->db->update($this->table_name,$data);

        return $result;
    }

    public function deleteImage($id)
    {
        $this->db->where('id',$id);
        $this->db->delete($this->table_name);
    }

    public function searcImage($search)
    {
        $this->db->like('name',$search);
        $this->db->order_by('id','asc');
        $query = $this->db->get($this->table_name);
        $result = $query->result_array();
        return  $result;
    }

    public function updateOrder($image_id,$order,$type)
    {
        $this->db->where('id',$image_id);
        $this->db->set($type,$order);
        $this->db->update($this->table_name);
    }

    public function getMaxIndex(){
        $this->db->select_max("id");
        $query = $this->db->get($this->table_name);
        return $query->row()->id;
    }

}