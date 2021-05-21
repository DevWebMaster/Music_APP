<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Music_cell_model extends CI_Model
{
	public $table_name = 'music_cell';

	public function addEmptyCell()
	{
		$this->db->set('player_1',NULL);
		//$this->db->set('name','No Title');
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
}