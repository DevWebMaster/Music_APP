<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Forum_model extends CI_Model
{
    public $table_name = 'tbl_forum_list';

    /**
     * This function is used to get the forum listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function forumListingCount($searchText = '')
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
     * This function is used to get the forum listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function forumListing($searchText = '', $page = null, $segment = null)
    {
        $this->db->select('BaseTbl.id, BaseTbl.name, BaseTbl.contents');
        $this->db->from($this->table_name . ' as BaseTbl');

        if(!empty($searchText)) {
            $likeCriteria = "BaseTbl.name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);

        if ($page && $segment) {
            $this->db->limit($page, $segment);
        }
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to add new forum to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewForum($forumInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->table_name, $forumInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get forum information by id
     * @param number $forumId : This is forum id
     * @return array $result : This is forum information
     */
    function getForumInfo($forumId)
    {
        $this->db->select('id');
        $this->db->from($this->table_name);
        $this->db->where('isDeleted', 0);
        $this->db->where('id', $forumId);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    
    /**
     * This function is used to update the forum information
     * @param array $forumInfo : This is forum updated information
     * @param number $forumId : This is forum id
     */
    function editForum($forumInfo, $forumId)
    {
        $this->db->where('id', $forumId);
        $this->db->update($this->table_name, $forumInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * This function is used to delete the forum information
     * @param number $forumId : This is forum id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteForum($forumId, $forumInfo)
    {
        $this->db->where('id', $forumId);
        $this->db->update($this->table_name, $forumInfo);
        
        return $this->db->affected_rows();
    }
}

  