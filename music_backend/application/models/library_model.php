<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Library_model extends CI_Model
{
    public $table_name = 'tbl_library';

    /**
     * This function is used to get the library listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function libraryListingCount($searchText = '')
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
     * This function is used to get the library listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function libraryListing($searchText = '', $page = null, $segment = null)
    {
        $this->db->select('BaseTbl.id, BaseTbl.name, BaseTbl.thumb_img');
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
     * This function is used to add new library to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewLibrary($libraryInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->table_name, $libraryInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get library information by id
     * @param number $libraryId : This is library id
     * @return array $result : This is library information
     */
    function getLibraryInfo($libraryId)
    {
        $this->db->select('id');
        $this->db->from($this->table_name);
        $this->db->where('isDeleted', 0);
        $this->db->where('id', $libraryId);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    
    /**
     * This function is used to update the library information
     * @param array $libraryInfo : This is library updated information
     * @param number $libraryId : This is library id
     */
    function editLibrary($libraryInfo, $libraryId)
    {
        $this->db->where('id', $libraryId);
        $this->db->update($this->table_name, $libraryInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * This function is used to delete the library information
     * @param number $libraryId : This is library id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteLibrary($libraryId, $libraryInfo)
    {
        $this->db->where('id', $libraryId);
        $this->db->update($this->table_name, $libraryInfo);
        
        return $this->db->affected_rows();
    }
}

  