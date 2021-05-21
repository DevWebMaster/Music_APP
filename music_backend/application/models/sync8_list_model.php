<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Sync8_list_model extends CI_Model
{
	public $table_name = 'sync8_list';

	public function getAllSync8List()
	{
		$this->db->order_by('id','asc');
		$query = $this->db->get($this->table_name);
		$result = $query->result_array();
		return  $result;
	}

	public function addNewSync8($data)
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

	public function addKeyItem($id,$key_no,$item_id)
	{
		$this->db->where('id',$id);
		$this->db->set('cell_'.$key_no,$item_id);
		$this->db->update($this->table_name);
	}

	public function getSync8($sample_id)
	{
		$this->db->where('id',$sample_id);
		$query =  $this->db->get($this->table_name);
		$result = $query->result_array();
		return $result;
	}

	public function updateSync8($data){
		$this->db->where('id',$data['id']);
		$this->db->update($this->table_name,$data);
	}

	public function deletSync8($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this->table_name);
	}
}

?>