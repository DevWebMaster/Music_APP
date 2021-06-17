<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Playlog_model extends CI_Model
{
    public $table_name = 'tbl_playlog';
    public $table_music = 'tbl_music';
    public $table_djs = 'tbl_djs';
    public $table_genres = 'tbl_genres';
    public $table_artists = 'tbl_artists';

    /**
     * This function is used to get the playlog listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function playlogListing()
    {
        $this->db->select('music_id, COUNT(*) as count');
        $this->db->from($this->table_name);
        $this->db->join($this->table_music . ' as MusicTbl', 'MusicTbl.id = music_id');
        $this->db->join($this->table_djs . ' as DjTbl', 'DjTbl.id = MusicTbl.dj','left');
        $this->db->join($this->table_genres . ' as GrTbl', 'GrTbl.id = MusicTbl.genre','left');

        $this->db->where('MusicTbl.isDeleted', 0);
        $this->db->where_not_in('DjTbl.isDeleted', 1);
        $this->db->where_not_in('GrTbl.isDeleted', 1);

        $this->db->group_by('music_id');
        $this->db->order_by('count', 'desc');
        $this->db->limit(10);

        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    function playlogListingWithGenre($genreId)
    {
        $this->db->select('music_id, COUNT(*) as count');
        $this->db->from($this->table_name);
        $this->db->join($this->table_music . ' as MusicTbl', 'MusicTbl.id = music_id');
        $this->db->join($this->table_djs . ' as DjTbl', 'DjTbl.id = MusicTbl.dj','left');
        $this->db->join($this->table_genres . ' as GrTbl', 'GrTbl.id = MusicTbl.genre','left');

        $this->db->where('MusicTbl.isDeleted', 0);
        $this->db->where_not_in('DjTbl.isDeleted', 1);
        $this->db->where_not_in('GrTbl.isDeleted', 1);
        $this->db->where('MusicTbl.genre', $genreId);

        $this->db->group_by('music_id');
        $this->db->order_by('count', 'desc');
        $this->db->limit(10);

        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    /**
     * This function is used to add new playlog to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewPlaylog($playlogInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->table_name, $playlogInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to add new playlog to system
     * @param number $musicId : This is the id of music
     * @return number $insert_id : This is last inserted id
     */
    function playout($musicId) {
        $this->db->select('COUNT(*) as count');
        $this->db->from($this->table_name);
        $this->db->where('music_id', $musicId);

        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }
}

  