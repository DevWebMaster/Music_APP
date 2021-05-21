<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class playlist_model extends CI_Model
{
    public $_tablename = 'tbl_playlist';

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $useId : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkIsPlaylist($useId, $musicId)
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
    function addPlaylist($playlistInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->_tablename, $playlistInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to delete the djs information
     * @param number $djsId : This is djs id
     * @return boolean $result : TRUE / FALSE
     */
    function updatePlaylist($userId, $music, $playlistInfo)
    {
        $this->db->where('user_id', $userId);
        $this->db->where('music_id', $music);
        $this->db->update($this->_tablename, $playlistInfo);
        
        return $this->db->affected_rows();
    }

    function getPlaylist($uid)
    {
        $this->db->select("BaseTbl.id, BaseTbl.name, BaseTbl.description, BaseTbl.thumb, BaseTbl.music, BaseTbl.duration, DjTbl.name as DJ, DjTbl.avatar_url as djAvatar, GrTbl.name as genre, BaseTbl.created_date, (select count(*) from tbl_likes Where music_id = BaseTbl.id and status = 1) as likes, (select count(*) from tbl_likes Where music_id = BaseTbl.id and user_id = $uid and status = 1) as is_liked, (select count(*) from tbl_playlist Where music_id = BaseTbl.id and user_id = $uid and status = 1) as is_playlist, (select count(*) from tbl_playlog Where music_id = BaseTbl.id) as playCounts, (select count(*) from tbl_comments Where music_id = BaseTbl.id and is_deleted = 0) as comment_count");
        $this->db->from('tbl_music as BaseTbl');
        $this->db->join('tbl_djs as DjTbl', 'DjTbl.id = BaseTbl.dj','left');
        $this->db->join('tbl_genres as GrTbl', 'GrTbl.id = BaseTbl.genre','left');
        $this->db->join('tbl_playlist as Playlist', 'Playlist.music_id = BaseTbl.id', 'left');

        $this->db->where_not_in('DjTbl.isDeleted', 1);
        $this->db->where_not_in('GrTbl.isDeleted', 1);

        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('Playlist.status', 1);


        $this->db->order_by('BaseTbl.created_date', 'desc');

        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }
    function get_userid($email)
    {
        $this->db->select('id');
        $this->db->from('tbl_customers');
        $this->db->where('email', $email);

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
}

  