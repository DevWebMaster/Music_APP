<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Like_model extends CI_Model
{
    public $_tablename = 'tbl_likes';

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $useId : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkIsLiked($useId, $musicId)
    {
        $this->db->select("*");
        $this->db->from($this->_tablename);
        $this->db->where("user_id", $useId);
        $this->db->where("music_id", $musicId);
        $this->db->where("status", 1);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function is used to add new djs to system
     * @return number $insert_id : This is last inserted id
     */
    function addLike($likeInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->_tablename, $likeInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to delete the djs information
     * @param number $djsId : This is djs id
     * @return boolean $result : TRUE / FALSE
     */
    function updateLike($userId, $likeInfo)
    {
        $this->db->where('user_id', $userId);
        $this->db->update($this->_tablename, $likeInfo);
        
        return $this->db->affected_rows();
    }
}

  