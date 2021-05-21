<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Sync4_list_model extends CI_Model
{
    public $table_name = 'sync4_list';

    public function getAllSync4List()
    {
        $this->db->order_by('id','asc');
        $query = $this->db->get($this->table_name);
        $result = $query->result_array();
        return  $result;
    }

    public function addNewSync4($data)
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

    public function getSync4($sample_id)
    {
        $this->db->where('id',$sample_id);
        $query =  $this->db->get($this->table_name);
        $result = $query->result_array();
        return $result;
    }

    public function updateSync4($data){
        $this->db->where('id',$data['id']);
        $this->db->update($this->table_name,$data);
    }

    public function updateMusicFile($id, $music_no,$file_name)
    {
        $this->db->where('id',$id);
        $this->db->update($this->table_name,array('music_'.$music_no => $file_name));
    }

    public function updateMusicDrumFile($id, $drum_no,$file_name)
    {
        $this->db->where('id',$id);
        $this->db->update($this->table_name,array('drum_'.$drum_no => $file_name));
    }

    public function deleteSync4($id)
    {
        $this->db->where('id',$id);
        $this->db->delete($this->table_name);
    }

    public function deleteMusicFile($id, $no)
    {
        $this->db->where('id',$id);
        $this->db->update($this->table_name,array('music_'.$no => $no));
    }

    public function deleteDrumFile($id, $no)
    {
        $this->db->where('id',$id);
        $this->db->update($this->table_name,array('drum_'.$no => $no));
    }

    public function editMusicName($id, $no, $name)
    {
        $this->db->where('id',$id);
        $this->db->update($this->table_name,array('music_title_'.$no => $name));
    }
}