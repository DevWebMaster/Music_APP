<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Sample_item_model extends CI_Model
{
	public $table_name = 'sample_item';

	public function getLastRow()
	{
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$query = $this->db->get($this->table_name);
		$result = $query->result_array();
		return $result;
	}

	public function addEmptyItem()
	{
		$this->db->set('C',NULL);
		$this->db->insert($this->table_name);
	}

	public function getSampleItem($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get($this->table_name);
		$result = $query->result_array();
		return $result;
	}

	public function editItemField($id,$field,$filename){
		$this->db->where('id',$id);
		$this->db->set($field,$filename);
		$this->db->update($this->table_name);
	}

	public function updateItem($item_id, $data)
	{
		$this->db->where('id',$item_id);
		$this->db->update($this->table_name,$data);
	}
}