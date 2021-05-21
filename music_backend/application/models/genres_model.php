<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Genres_model extends CI_Model
{
    public $table_name = 'tbl_genres';

    /**
     * This function is used to get the genres listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function genresListingCount($searchText = '')
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
     * This function is used to get the genres listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function genresListing($searchText = '', $page = null, $segment = null)
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
     * This function is used to add new genres to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewGenres($genresInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->table_name, $genresInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get genres information by id
     * @param number $genresId : This is genres id
     * @return array $result : This is genres information
     */
    function getGenresInfo($genresId)
    {
        $this->db->select('id');
        $this->db->from($this->table_name);
        $this->db->where('isDeleted', 0);
        $this->db->where('id', $genresId);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    
    /**
     * This function is used to update the genres information
     * @param array $genresInfo : This is genres updated information
     * @param number $genresId : This is genres id
     */
    function editGenres($genresInfo, $genresId)
    {
        $this->db->where('id', $genresId);
        $this->db->update($this->table_name, $genresInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * This function is used to delete the genres information
     * @param number $genresId : This is genres id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteGenres($genresId, $genresInfo)
    {
        $this->db->where('id', $genresId);
        $this->db->update($this->table_name, $genresInfo);
        
        return $this->db->affected_rows();
    }
}

  