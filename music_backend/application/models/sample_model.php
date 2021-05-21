<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Sample_model extends CI_Model
{
	public $table_name = 'samplesets';

	public function addNewSample($data)
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

	public function getSample($sample_id)
	{
		$this->db->where('id',$sample_id);
		$query =  $this->db->get($this->table_name);
		$result = $query->result_array();
		return $result;
	}

	public function getAllSample()
	{
		$this->db->order_by('id','asc');
		$query = $this->db->get($this->table_name);
		$result = $query->result_array();
		return  $result;
	}

	public function addKeyItem($id,$key_no,$item_id)
	{
		$this->db->where('id',$id);
		$this->db->set('key_'.$key_no,$item_id);
		$this->db->update($this->table_name);
	}

	public function updateSample($data){
		$this->db->where('id',$data['id']);
		$this->db->update($this->table_name,$data);
	}

	public function deleteSample($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this->table_name);
	}

	public function searcSample($search)
	{
		$this->db->like('name',$search);
		$this->db->order_by('id','asc');
		$query = $this->db->get($this->table_name);
		$result = $query->result_array();
		return  $result;
	}

	public function updateOrder($sample_id,$order,$type)
	{
		$this->db->where('id',$sample_id);
		$this->db->set($type,$order);
		$this->db->update($this->table_name);
	}

}