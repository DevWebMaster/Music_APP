<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Comment_model extends CI_Model
{
    public $_tablename = 'tbl_comments';
    public $_customersTable = 'tbl_customers';

    /**
     * This function is used to add new djs to system
     * @return number $insert_id : This is last inserted id
     */
    function addComment($comment)
    {
        $this->db->trans_start();
        $this->db->insert($this->_tablename, $comment);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * This function is used to delete the djs information
     * @param number $commentId : This is comment id
     * @return boolean $result : TRUE / FALSE
     */
    function updateComment($commentId, $userId, $updateInfo)
    {
        $this->db->where('id', $commentId);
        $this->db->where('user_id', $userId);
        $this->db->update($this->_tablename, $updateInfo);

        return $this->db->affected_rows();
    }

    /**
     * This function is used to list the comments on the music
     * @param $musicId, music ID
     * @return list of omments on the music
     */
    public function listComments($musicId) {
        $this->db->select('customer.username, comments.*');    //have to add the profile avatar in the customer table.
        $this->db->from($this->_tablename . ' as comments');
        $this->db->where('comments.music_id', $musicId);
        $this->db->where('comments.is_deleted', 0);
        $this->db->join($this->_customersTable . ' as customer', 'comments.user_id = customer.id','left');

        $this->db->order_by('comments.created_at', 'desc');

        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }
}

  