<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Sync8_item_model extends CI_Model
{
    public $table_name = 'sync8_cell';

    public function addEmptyCell()
    {
        //$this->db->set('player_1',NULL);
        $this->db->set('name','No Title');
        $this->db->insert($this->table_name);
    }

    public function getLastRow()
    {
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $query = $this->db->get($this->table_name);
        $result = $query->result_array();
        return $result;
    }

    public function getCell($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get($this->table_name);
        $result = $query->result_array();
        return $result;
    }

    public function updateCell($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->set($data);
        $this->db->update($this->table_name);
    }

    public function updateMusicFile($id,$no,$name)
    {
        $this->db->where('id',$id);
        $this->db->set('player_'.$no,$name);
        $this->db->update($this->table_name);
    }

    public function deleteMusicFile($id, $no)
    {
        $this->db->where('id',$id);
        $this->db->update($this->table_name, array('player_'.$no => ""));
    }

    public function editName($id, $name)
    {
        $this->db->where('id',$id);
        $this->db->update($this->table_name, array('name' => $name));
    }
}