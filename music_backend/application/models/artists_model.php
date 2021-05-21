<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Artists_model extends CI_Model
{
    public $table_name = 'tbl_artists';

    /**
     * This function is used to get the Artists listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function artistsListingCount($searchText = '')
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
     * This function is used to get the Artists listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function artistsListing($searchText = '', $page = null, $segment = null)
    {
        $this->db->select('BaseTbl.id, BaseTbl.name');
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
     * This function is used to add new Artists to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewArtists($ArtistsInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->table_name, $ArtistsInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get Artists information by id
     * @param number $ArtistsId : This is Artists id
     * @return array $result : This is Artists information
     */
    function getArtistsInfo($ArtistsId)
    {
        $this->db->select('id');
        $this->db->from($this->table_name);
        $this->db->where('isDeleted', 0);
//		$this->db->where('roleId !=', 1);
        $this->db->where('id', $ArtistsId);
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to update the Artists information
     * @param array $ArtistsInfo : This is Artists updated information
     * @param number $ArtistsId : This is Artists id
     */
    function editArtists($ArtistsInfo, $ArtistsId)
    {
        $this->db->where('id', $ArtistsId);
        $this->db->update($this->table_name, $ArtistsInfo);
        
        return TRUE;
    }

    /**
     * This function is used to delete the Artists information
     * @param number $ArtistsId : This is Artists id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteArtists($ArtistsId, $ArtistsInfo)
    {
        $this->db->where('id', $ArtistsId);
        $this->db->update($this->table_name, $ArtistsInfo);
        
        return $this->db->affected_rows();
    }
}

  