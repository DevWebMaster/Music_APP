<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Paidstatus_model extends CI_Model
{
	public $table_name = 'paidstatus';

	public function getPaidStatusItem($sample_id,$token_id)
	{
		$this->db->where('sample_id',$sample_id);
		$this->db->where('token',$token_id);
		$query = $this->db->get($this->table_name);
		$result = $query->result_array();

		if(count($result)>0)
		{
			return $result[0];
		}
		return false;
	}

	public function addNewItem($token_id,$sample_id)
	{
		$data = array(
			'token'		 =>	$token_id,
			'sample_id'	 => $sample_id,
			'C'			 => 'unpaid',
			'Db'		 => 'unpaid',
			'D'			 => 'unpaid',
			'Eb'		 => 'unpaid',
			'E'			 => 'unpaid',
			'F'			 => 'unpaid',
			'Gb'		 => 'unpaid',
			'G'			 => 'unpaid',
			'Ab'		 => 'unpaid',
			'A'			 => 'unpaid',
			'Bb'		 => 'unpaid'
		);

		$this->db->insert($this->table_name,$data);
	}

	public function updateStatusAll($token_id,$sample_id,$update_state){
		$this->db->where('token',$token_id);
		$this->db->where('sample_id',$sample_id);
		$data = array(
			'C'			 => $update_state,
			'Db'		 => $update_state,
			'D'			 => $update_state,
			'Eb'		 => $update_state,
			'E'			 => $update_state,
			'F'			 => $update_state,
			'Gb'		 => $update_state,
			'G'			 => $update_state,
			'Ab'		 => $update_state,
			'A'			 => $update_state,
			'Bb'		 => $update_state
		);
		$this->db->set($data);
		$this->db->update($this->table_name);
	}

	public function updateStatus($token_id,$sample_id,$key_name,$update_state){
		$this->db->where('token',$token_id);
		$this->db->where('sample_id',$sample_id);
		$this->db->set($key_name,$update_state);
		$this->db->update($this->table_name);
	}
}