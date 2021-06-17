<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Music_model extends CI_Model
{
    public $table_name = 'tbl_music';
    public $table_djs = 'tbl_djs';
    public $table_genres = 'tbl_genres';
    public $table_artists = 'tbl_artists';

    /**
     * This function is used to get the music listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function musicListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.id, BaseTbl.name');
        $this->db->from($this->table_name . ' as BaseTbl');
        $this->db->join($this->table_djs . ' as DjTbl', 'DjTbl.id = BaseTbl.dj','left');
        $this->db->join($this->table_genres . ' as GrTbl', 'GrTbl.id = BaseTbl.genre','left');

        if(!empty($searchText)) {
            $likeCriteria = "BaseTbl.name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where_not_in('DjTbl.isDeleted', 1);
//        $this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();
        
        return count($query->result());
    }
    
    /**
     * This function is used to get the music listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function musicListing($uid, $searchText = '', $ids = null, $page = null, $segment = null, $is_admin = false)
    {
        $sql = "BaseTbl.id, BaseTbl.name, BaseTbl.description, BaseTbl.thumb, BaseTbl.music, BaseTbl.duration, BaseTbl.created_date, (select count(*) from tbl_likes Where music_id = BaseTbl.id and status = 1) as likes, (select count(*) from tbl_playlog Where music_id = BaseTbl.id) as playCounts, (select count(*) from tbl_comments Where music_id = BaseTbl.id and is_deleted = 0) as comment_count, GrTbl.name as genre, DjTbl.name as DJ";

        if (!$is_admin) {
            $sql .= ", (select count(*) from tbl_likes Where music_id = BaseTbl.id and user_id = $uid and status = 1) as is_liked";
            $sql .= ", (select count(*) from tbl_playlist Where music_id = BaseTbl.id and user_id = $uid and status = 1) as is_playlist";
        }
        $this->db->select($sql);
        $this->db->from($this->table_name . ' as BaseTbl');
        $this->db->join($this->table_djs . ' as DjTbl', 'DjTbl.id = BaseTbl.dj','left');
        $this->db->join($this->table_genres . ' as GrTbl', 'GrTbl.id = BaseTbl.genre','left');

        if(!empty($searchText)) {
            $likeCriteria = "BaseTbl.name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }

        if ($ids) {
            $this->db->where_in('BaseTbl.id', $ids);
        }

        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('DjTbl.isDeleted', 0);
        $this->db->where('GrTbl.isDeleted', 0);

        if (!is_null($page) && $segment) {
            $this->db->limit($page, $segment);
        }

        $this->db->order_by('BaseTbl.created_date', 'desc');

        $query = $this->db->get();
        
        $result = $query->result();    

        return $result;
    }
    function musicRecentListing($uid, $searchText = '', $is_admin = false)
    {
        $sql = "BaseTbl.id, BaseTbl.name, BaseTbl.description, BaseTbl.thumb, BaseTbl.music, BaseTbl.duration, BaseTbl.created_date, (select count(*) from tbl_likes Where music_id = BaseTbl.id and status = 1) as likes, (select count(*) from tbl_playlog Where music_id = BaseTbl.id) as playCounts, (select count(*) from tbl_comments Where music_id = BaseTbl.id and is_deleted = 0) as comment_count, GrTbl.name as genre, DjTbl.name as DJ";

        if (!$is_admin) {
            $sql .= ", (select count(*) from tbl_likes Where music_id = BaseTbl.id and user_id = $uid and status = 1) as is_liked";
            $sql .= ", (select count(*) from tbl_playlist Where music_id = BaseTbl.id and user_id = $uid and status = 1) as is_playlist";
        }
        $this->db->select($sql);
        $this->db->from($this->table_name . ' as BaseTbl');
        $this->db->join($this->table_djs . ' as DjTbl', 'DjTbl.id = BaseTbl.dj','left');
        $this->db->join($this->table_genres . ' as GrTbl', 'GrTbl.id = BaseTbl.genre','left');

        if(!empty($searchText)) {
            $likeCriteria = "BaseTbl.name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }

        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('DjTbl.isDeleted', 0);
        $this->db->where('GrTbl.isDeleted', 0);

        $this->db->order_by('BaseTbl.created_date', 'desc');
        $this->db->limit(5, 0);

        $query = $this->db->get();
        
        $result = $query->result();    

        return $result;
    }
    function musicListingWithGenre($uid, $genreId, $searchText = '', $page = null, $segment = null)
    {
        $this->db->select("BaseTbl.id, BaseTbl.name, BaseTbl.description, BaseTbl.thumb, BaseTbl.music, BaseTbl.duration, DjTbl.name as DJ, DjTbl.avatar_url as djAvatar, GrTbl.name as genre, BaseTbl.created_date, (select count(*) from tbl_likes Where music_id = BaseTbl.id and status = 1) as likes, (select count(*) from tbl_likes Where music_id = BaseTbl.id and user_id = $uid and status = 1) as is_liked, (select count(*) from tbl_playlist Where music_id = BaseTbl.id and user_id = $uid and status = 1) as is_playlist, (select count(*) from tbl_playlog Where music_id = BaseTbl.id) as playCounts, (select count(*) from tbl_comments Where music_id = BaseTbl.id and is_deleted = 0) as comment_count");
        $this->db->from($this->table_name . ' as BaseTbl');
        $this->db->join($this->table_djs . ' as DjTbl', 'DjTbl.id = BaseTbl.dj','left');
        $this->db->join($this->table_genres . ' as GrTbl', 'GrTbl.id = BaseTbl.genre','left');

        $this->db->where('BaseTbl.genre', $genreId);
        $this->db->where_not_in('DjTbl.isDeleted', 1);
        $this->db->where_not_in('GrTbl.isDeleted', 1);

        if(!empty($searchText)) {
            $likeCriteria = "BaseTbl.name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);

        if ($page && $segment) {
            $this->db->limit($page, $segment);
        }

        $this->db->order_by('BaseTbl.created_date', 'desc');

        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    function musicListingWithDJ($uid, $djId, $searchText = '', $page = null, $segment = null)
    {
        $this->db->select("BaseTbl.id, BaseTbl.name, BaseTbl.description, BaseTbl.thumb, BaseTbl.music, BaseTbl.duration, DjTbl.name as DJ, DjTbl.avatar_url as djAvatar, GrTbl.name as genre, BaseTbl.created_date, (select count(*) from tbl_likes Where music_id = BaseTbl.id and status = 1) as likes, (select count(*) from tbl_likes Where music_id = BaseTbl.id and user_id = $uid and status = 1) as is_liked, (select count(*) from tbl_playlist Where music_id = BaseTbl.id and user_id = $uid and status = 1) as is_playlist, (select count(*) from tbl_playlog Where music_id = BaseTbl.id) as playCounts, (select count(*) from tbl_comments Where music_id = BaseTbl.id and is_deleted = 0) as comment_count");
        $this->db->from($this->table_name . ' as BaseTbl');
        $this->db->join($this->table_djs . ' as DjTbl', 'DjTbl.id = BaseTbl.dj','left');
        $this->db->join($this->table_genres . ' as GrTbl', 'GrTbl.id = BaseTbl.genre','left');

        $this->db->where('BaseTbl.dj', $djId);
        $this->db->where_not_in('DjTbl.isDeleted', 1);
        $this->db->where_not_in('GrTbl.isDeleted', 1);

        if(!empty($searchText)) {
            $likeCriteria = "BaseTbl.name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);

        if ($page && $segment) {
            $this->db->limit($page, $segment);
        }

        $this->db->order_by('BaseTbl.created_date', 'desc');

        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    /**
     * This function is used to add new music to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewMusic($musicInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->table_name, $musicInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get music information by id
     * @param number $musicId : This is music id
     * @return array $result : This is music information
     */
    function getMusicInfo($musicId)
    {
        $this->db->select("*, (select count(*) from tbl_likes Where music_id = $musicId and status = 1) as likes");
        $this->db->from($this->table_name);
        $this->db->where('isDeleted', 0);
        $this->db->where('id', $musicId);
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to update the music information
     * @param array $musicInfo : This is music updated information
     * @param number $musicId : This is music id
     */
    function editMusic($musicInfo, $musicId)
    {
        $this->db->where('id', $musicId);
        $this->db->update($this->table_name, $musicInfo);
        
        return TRUE;
    }

    /**
     * This function is used to delete the music information
     * @param number $musicId : This is music id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteMusic($musicId, $musicInfo)
    {
        $this->db->where('id', $musicId);
        $this->db->update($this->table_name, $musicInfo);
        
        return $this->db->affected_rows();
    }
}

  