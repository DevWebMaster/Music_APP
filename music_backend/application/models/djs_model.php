<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Djs_model extends CI_Model
{
    public $table_name = 'tbl_djs';

    /**
     * This function is used to get the djs listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function djsListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.id, BaseTbl.name');
        $this->db->from($this->table_name . ' as BaseTbl');
//        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "BaseTbl.name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
//        $this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();
        
        return count($query->result());
    }
    
    /**
     * This function is used to get the djs listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function djsListing($searchText = '', $page = null, $segment = null)
    {
        $this->db->select('BaseTbl.id, BaseTbl.name, BaseTbl.avatar_url, BaseTbl.profile_cover, BaseTbl.email, BaseTbl.mobile');
        $this->db->from($this->table_name . ' as BaseTbl');

        if(!empty($searchText)) {
            $likeCriteria = "BaseTbl.name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where_not_in('BaseTbl.mobile', 0);

        if ($page && $segment) {
            $this->db->limit($page, $segment);
        }
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to add new djs to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewDJs($djsInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->table_name, $djsInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get djs information by id
     * @param number $djsId : This is djs id
     * @return array $result : This is djs information
     */
    function getDJsInfo($djsId)
    {
        $this->db->select('*');
        $this->db->from($this->table_name);
        $this->db->where('isDeleted', 0);
        $this->db->where('id', $djsId);
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to update the djs information
     * @param array $djsInfo : This is djs updated information
     * @param number $djsId : This is djs id
     */
    function editDJs($djsInfo, $djsId)
    {
        $this->db->where('id', $djsId);
        $this->db->update($this->table_name, $djsInfo);
        
        return TRUE;
    }
    
    /**
     * This function is used to delete the djs information
     * @param number $djsId : This is djs id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteDJs($djsId, $djsInfo)
    {
        $this->db->where('id', $djsId);
        $this->db->update($this->table_name, $djsInfo);
        
        return $this->db->affected_rows();
    }
}

  