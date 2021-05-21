<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Topic;
use sngrl\PhpFirebaseCloudMessaging\Notification;

/**
 * Class : music (musicController)
 * music Class to control all music related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Music extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('music_model');
        $this->load->model('djs_model');
        $this->load->model('genres_model');
        $this->load->model('artists_model');
        

        $this->load->library('mp3file');

        date_default_timezone_set('Africa/Lagos');

        $server_key = 'AIzaSyD4Tekho88a9WWDOKiFNeE7xNQC1_ffebU';
        $this->client = new Client();
        $this->client->setApiKey($server_key);
    }
    
    /**
     * This function used to load the first screen of the music
     */
    public function index()
    {
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'CodeInsect : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * This function is used to load the music list
     */
    public function musicListing()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'CodeInsect : music Listing';
            $this->global['search'] = '';

            $searchText = $this->input->post('searchText');
            $this->global['search'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->music_model->musicListingCount($searchText);

			$returns = $this->paginationCompress ( "musicListing/", $count, 5);

            $this->global['musics'] = $this->music_model->musicListing(null, $searchText, null, $returns["page"], $returns["segment"], true);

            $this->loadViews("music/list", $this->global, null, NULL);
        }
    }

    /**
     * This function is used to add new music to the system
     */
    public function addNewMusic()
    {
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'Add New Music';
        $data['djs'] = $this->djs_model->djsListing();
        $data['genres'] = $this->genres_model->genresListing();
        $data['artists'] = $this->artists_model->artistsListing();

        $this->loadViews("music/add", $this->global, $data , NULL);
    }

    public function saveNewMusic()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('name','Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('description','Description','trim|xss_clean');
            $this->form_validation->set_rules('dj','Dj','trim|xss_clean');
            $this->form_validation->set_rules('genre','Genre','trim|xss_clean');
            $this->form_validation->set_rules('artist','Artist','trim|xss_clean');

            if($this->form_validation->run() == FALSE)
            {
                $this->musicListing();
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('name')));
                $description = $this->input->post('description');
                $dj = $this->input->post('dj');
                $genre = $this->input->post('genre');
                $artist = $this->input->post('artist');

                $musicInfo = array('name'=> $name, 'description'=>$description, 'dj'=>$dj, 'genre'=>$genre, 'artist'=>$artist, 'createdBy'=>$this->vendorId, 'updatedBy'=>$this->vendorId, 'created_date'=>date('Y-m-d H:i:s'), 'updated_date'=>date('Y-m-d H:i:s'));

                $uploaddir = 'assets/thumbimages/music/';
                $path = $_FILES['thumbimg']['name'];

                if ($_FILES['thumbimg']['name']) {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $dest_filename = md5(uniqid(rand(), true)) . '.' . $ext;
                    $uploadfile = $uploaddir . $dest_filename;
                    if (move_uploaded_file($_FILES['thumbimg']['tmp_name'], $uploadfile)) {
                        $musicInfo['thumb'] = $uploadfile;
                    }
                }

                $musidDir = 'assets/music_files/';
                $path = $_FILES['music']['name'];
                if ($_FILES['music']['name']) {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $dest_filename = md5(uniqid(rand(), true)) . '.' . $ext;
                    $musicfile = $musidDir . $dest_filename;
                    if (move_uploaded_file($_FILES['music']['tmp_name'], $musicfile)) {
                        $duration = $this->mp3file->getDurationEstimate($musicfile);
                        $musicInfo['music'] = $musicfile;
                        $musicInfo['duration'] = $duration;
                    }
                }

                $result = $this->music_model->addNewMusic($musicInfo);
                if($result > 0)
                {
                    $this->sendNotification($name);
                    $this->session->set_flashdata('success', 'New music created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'music creation failed');
                }

                redirect('index.php/musicListing');
            }
        }
    }

    public function sendNotification($name) {
        $notification = new Notification('Notification from DJ Bitz', "New Mix \"$name\" was added.");
        $notification->setBadge(1);
        $notification->setSound('default');

        $message = new Message();
        $message->setPriority('high');
        $message->setContentAvailable(true);
        $message->addRecipient(new Topic("new-mix"));
        $message
            ->setNotification($notification)
            ->setData(['content_available' => 'true'])
        ;

        $response = $this->client->send($message);
    }

    /**
     * This function is used to edit the music information
     */
    public function editMusic($music_id){
        $this->isLoggedIn();
        $music = $this->music_model->getMusicInfo($music_id);

        $data['djs'] = $this->djs_model->djsListing();
        $data['genres'] = $this->genres_model->genresListing();
        $data['artists'] = $this->artists_model->artistsListing();
        $data['music'] = $music[0];

        $this->global['pageTitle'] = 'Edit Music';
        $this->loadViews("music/edit", $this->global, $data , NULL);
    }

    function saveEditMusic()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            $musicId = $this->input->post('musicId');
            
            $this->form_validation->set_rules('name','Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('description','Description','trim|xss_clean');
            $this->form_validation->set_rules('dj','Dj','trim|xss_clean');
            $this->form_validation->set_rules('genre','Genre','trim|xss_clean');
            $this->form_validation->set_rules('artist','Artist','trim|xss_clean');

            if($this->form_validation->run() == FALSE)
            {
                redirect('index.php/musicListing');
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('name')));
                $description = $this->input->post('description');
                $dj = $this->input->post('dj');
                $genre = $this->input->post('genre');
                $artist = $this->input->post('artist');

                $musicInfo = array('name'=> $name, 'description'=>$description, 'dj'=>$dj, 'genre'=>$genre, 'artist'=>$artist, 'updatedBy'=>$this->vendorId, 'updated_date'=>date('Y-m-d H:i:s'));

                $uploaddir = 'assets/thumbimages/music/';
                $path = $_FILES['thumbimg']['name'];

                if ($_FILES['thumbimg']['name']) {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $dest_filename = md5(uniqid(rand(), true)) . '.' . $ext;
                    $uploadfile = $uploaddir . $dest_filename;
                    if (move_uploaded_file($_FILES['thumbimg']['tmp_name'], $uploadfile)) {
                        $musicInfo['thumb'] = $uploadfile;
                    }
                }

                $musidDir = 'assets/music_files/';
                $path = $_FILES['music']['name'];

                if ($_FILES['music']['name']) {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $dest_filename = md5(uniqid(rand(), true)) . '.' . $ext;
                    $musicfile = $musidDir . $dest_filename;
                    if (move_uploaded_file($_FILES['music']['tmp_name'], $musicfile)) {
                        $duration = $this->mp3file->getDurationEstimate($musicfile);
                        $musicInfo['music'] = $musicfile;
                        $musicInfo['duration'] = $duration;
                    }
                }

                $result = $this->music_model->editMusic($musicInfo, $musicId);

                if($result == true)
                {
                    $this->session->set_flashdata('success', 'music updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'music updation failed');
                }

                redirect('index.php/musicListing');
            }
        }
    }

    /**
     * This function is used to delete the music using musicId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteMusic()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $musicId = $this->input->post('musicId');
            $musicInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updated_date'=>date('Y-m-d H:i:s'));
            
            $result = $this->music_model->deleteMusic($musicId, $musicInfo);

            if($result == true)
            {
                $this->session->set_flashdata('success', 'music deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'music delete failed');
            }

            redirect('index.php/musicListing');
        }
    }

    function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }

    /*
     * Mobile API
     */
    public function getMusicList() {
        $uid = $this->input->post('uid');
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $this->load->library('pagination');

        $count = $this->music_model->musicListingCount($searchText);

        // store the result in array form
        // print_r($count);
        $result_set = array();
        if ($count > 0) {

            $data['musicRecords'] = $this->music_model->musicListing($uid, $searchText);
            if (is_array($data['musicRecords'])) {
                foreach ($data['musicRecords'] as $music) {
                    if ($music->music && !$music->duration) {
                        $duration = $this->mp3file->getDurationEstimate($music->music);
                        $musicData = array('duration' => $duration);
                        $this->music_model->editMusic($musicData, $music->id);
                    }
                }
            }

            $status = "success";
            $msg = "Success!";
        } else {
            $status = "failed";
            $msg = "music not existing.";
        }

        echo json_encode(array('status' => $status, 'msg' => $msg, 'result' => $data));
    }

    public function getTopMusicList() {
        $uid = $this->input->post('uid');
        $this->load->model("playlog_model");
        $topPlayLogs = $this->playlog_model->playlogListing();

        $topTenMusicIds = array();
        if ($topPlayLogs && is_array($topPlayLogs)) {
            foreach ($topPlayLogs as $log) {
                $topTenMusicIds[] = $log->music_id;
            }
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "Can't find the play logs"));
            exit;
        }

        $topTenMusicLists = $this->music_model->musicListing($uid, '', $topTenMusicIds);
        if ($topTenMusicLists) {
            if (is_array($topTenMusicLists)) {
                $newList = array();
                foreach ($topTenMusicLists as $music) {
                    $newList[$music->id] = $music;
                }

                $topTenMusicLists = array_replace(array_flip($topTenMusicIds), $newList);

                $newItems = array();
                foreach ($topTenMusicLists as $item) {
                    $newItems[] = $item;
                }

                $topTenMusicLists = $newItems;
            }
            echo json_encode(array('status' => "Success", 'result' => $topTenMusicLists));
        } else {
            echo json_encode(array('status' => "faile", 'msg' => "Can't find the Musics"));
        }
    }

    public function getMusicsWithGenre() {
        $uid = $this->input->post('uid');
        $genreId = $this->input->post('genreId');
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $this->load->library('pagination');

        $count = $this->music_model->musicListingCount($searchText);

        // store the result in array form
        $result_set = array();
        if ($count > 0) {

            $data['musicRecords'] = $this->music_model->musicListingWithGenre($uid, $genreId, $searchText);

            $status = "success";
            $msg = "Success!";
        } else {
            $status = "failed";
            $msg = "music not existing.";
        }

        echo json_encode(array('status' => $status, 'msg' => $msg, 'result' => $data));
    }

    public function getMusicsWithDJ() {
        $uid = $this->input->post('uid');
        $djId = $this->input->post('djId');
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $this->load->library('pagination');

        $count = $this->music_model->musicListingCount($searchText);

        // store the result in array form
        $result_set = array();
        if ($count > 0) {

            $data['musicRecords'] = $this->music_model->musicListingWithDJ($uid, $djId, $searchText);

            $status = "success";
            $msg = "Success!";
        } else {
            $status = "failed";
            $msg = "music not existing.";
        }

        echo json_encode(array('status' => $status, 'msg' => $msg, 'result' => $data));
    }

    public function getMusicPlay() {
        $uid = $this->input->post('uid');
        $mid = $this->input->post('mid');
        $musicInfo = $this->music_model->getMusicInfo($mid);

        if ($musicInfo) {
            $this->load->model("playlog_model");
            $this->playlog_model->addNewPlaylog(array(
                'music_id' => $mid,
                'created_at' => date('Y-m-d H:i:s')
            ));

            $this->load->model('playlog_model');
            $playCount = $this->playlog_model->playout($mid);

            $isLiked = false;
                $this->load->model('like_model');
            if ($this->like_model->checkIsLiked($uid, $mid)) {
                $isLiked = true;
            }

            $this->load->model('comment_model');
            $comments = $this->comment_model->listComments($mid);

            echo json_encode(array('status' => "success", 'result' => $musicInfo, 'comments' => $comments, 'is_liked' => $isLiked, 'comment_count' => count($comments), 'play_count' => $playCount));
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "Music data is not valid."));
        }


    }
    public function getPlaylist() {
        $email = $this->input->post('email');
        // $uid = 296;
        $this->load->model('playlist_model');

        $uid = $this->playlist_model->get_userid($email)[0]->id;

        $data['musicRecords'] = $this->playlist_model->getPlaylist($uid);
        if(is_array($data['musicRecords'])){
            echo json_encode(array('status' => 'success', 'result' => $data));
        }else{
            echo json_encode(array('status' => 'failed', 'msg' => 'There is no playlist.'));
        }
    }
    public function addPlaylist() {
        $this->load->model('customer_model');
        $this->load->model('playlist_model');

        $email = $this->input->post('email');
        $music = $this->input->post('music_id');

        /* Get user detail */
        if ($email) {
            $user = $this->customer_model->getUserInfo($email);
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "Your email doesn't exist."));
            exit(1);
        }

        if (!$user || !$user[0]) {
            echo json_encode(array('status' => "failed", 'msg' => "This user doesn't exist."));
            exit(1);
        }

        /* Check if music is already liked */
        $user = $user[0];
        if ($music) {
            $checkResult = $this->playlist_model->checkIsPlaylist($user->id, $music);
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "Music ID is empty."));
            exit(1);
        }

        if ( !$checkResult ) {
            $info = array('user_id' => $user->id, 'music_id' => $music, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'));
            $result = $this->playlist_model->addPlaylist($info);

            if ($result) {
                echo json_encode(array('status' => "success", 'msg' => "You added this music in the playlist successfully."));
            } else {
                echo json_encode(array('status' => "failed", 'msg' => "Your request was not completed. There is some problem."));
            }
        } else {
            $oldInfo = $checkResult[0];
            if (!$oldInfo->status) {
                $this->playlist_model->updatePlaylist($user->id, array('status' => 1, 'updated_at' => date('Y-m-d H:i:s')));
                echo json_encode(array('status' => "success", 'msg' => "You added this music in the playlist successfully."));
            } else {
                echo json_encode(array('status' => "failed", 'msg' => "You already added this music in the playlist."));
            }
        }

        exit(1);
    }
    public function removePlaylist() {
        $this->load->model('customer_model');
        $this->load->model('playlist_model');

        $email = $this->input->post('email');
        $music = $this->input->post('music_id');

        /* Get user detail */
        if ($email) {
            $user = $this->customer_model->getUserInfo($email);
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "Your email doesn't exist."));
            exit(1);
        }

        if (!$user || !$user[0]) {
            echo json_encode(array('status' => "failed", 'msg' => "This user doesn't exist."));
            exit(1);
        }

        /* Check if music is already liked */
        $user = $user[0];
        if ($music) {
            $checkResult = $this->playlist_model->checkIsPlaylist($user->id, $music);
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "Music ID is empty."));
            exit(1);
        }

        if ( $checkResult ) {
            $result = $this->playlist_model->updatePlaylist($user->id, $music, array('status' => 0, 'updated_at' => date('Y-m-d H:i:s')));

            if ($result) {
                echo json_encode(array('status' => "success", 'msg' => "Success"));
            } else {
                echo json_encode(array('status' => "failed", 'msg' => "Your request was not completed. There is some problem."));
            }
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "You never added this music in the playlist."));
        }

        exit(1);
    }
    public function likeMusic() {
        $this->load->model('customer_model');
        $this->load->model('like_model');

        $email = $this->input->post('email');
        $music = $this->input->post('music_id');

        /* Get user detail */
        if ($email) {
            $user = $this->customer_model->getUserInfo($email);
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "Your email doesn't exist."));
            exit(1);
        }

        if (!$user || !$user[0]) {
            echo json_encode(array('status' => "failed", 'msg' => "This user doesn't exist."));
            exit(1);
        }

        /* Check if music is already liked */
        $user = $user[0];
        if ($music) {
            $checkResult = $this->like_model->checkIsLiked($user->id, $music);
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "Music ID is empty."));
            exit(1);
        }

        if ( !$checkResult ) {
            $info = array('user_id' => $user->id, 'music_id' => $music, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'));
            $result = $this->like_model->addLike($info);

            if ($result) {
                echo json_encode(array('status' => "success", 'msg' => "You liked this music successfully."));
            } else {
                echo json_encode(array('status' => "failed", 'msg' => "Your request was not completed. There is some problem."));
            }
        } else {
            $oldInfo = $checkResult[0];
            if (!$oldInfo->status) {
                $this->like_model->updateLike($user->id, array('status' => 1, 'updated_at' => date('Y-m-d H:i:s')));
                echo json_encode(array('status' => "success", 'msg' => "You liked this music successfully."));
            } else {
                echo json_encode(array('status' => "failed", 'msg' => "You already liked this music."));
            }
        }

        exit(1);
    }

    public function disLikeMusic() {
        $this->load->model('customer_model');
        $this->load->model('like_model');

        $email = $this->input->post('email');
        $music = $this->input->post('music_id');

        /* Get user detail */
        if ($email) {
            $user = $this->customer_model->getUserInfo($email);
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "Your email doesn't exist."));
            exit(1);
        }

        if (!$user || !$user[0]) {
            echo json_encode(array('status' => "failed", 'msg' => "This user doesn't exist."));
            exit(1);
        }

        /* Check if music is already liked */
        $user = $user[0];
        if ($music) {
            $checkResult = $this->like_model->checkIsLiked($user->id, $music);
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "Music ID is empty."));
            exit(1);
        }

        if ( $checkResult ) {
            $result = $this->like_model->updateLike($user->id, array('status' => 0, 'updated_at' => date('Y-m-d H:i:s')));

            if ($result) {
                echo json_encode(array('status' => "success", 'msg' => "Success"));
            } else {
                echo json_encode(array('status' => "failed", 'msg' => "Your request was not completed. There is some problem."));
            }
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "You never liked this music."));
        }

        exit(1);
    }

    public function addComment() {
        $this->load->model('customer_model');
        $this->load->model('comment_model');

        $email = $this->input->post('email');
        $music = $this->input->post('music_id');
        $comment = $this->input->post('comment');

        /* Get user detail */
        if ($email) {
            $user = $this->customer_model->getUserInfo($email);
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "Your email doesn't exist."));
            exit(1);
        }

        if (!$user || !$user[0]) {
            echo json_encode(array('status' => "failed", 'msg' => "This user doesn't exist."));
            exit(1);
        }

        /* Add new comment */
        $user = $user[0];
        if ( !$music || !$comment ) {
            echo json_encode(array('status' => "failed", 'msg' => "Parameter is missing."));
            exit(1);
        }

        $info = array('user_id' => $user->id, 'music_id' => $music, 'comment' => $comment, 'is_deleted' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'));
        $result = $this->comment_model->addComment($info);

        if ($result) {
            echo json_encode(array('status' => "success", 'msg' => "You commented this music successfully.", 'comment_id' => $result));
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "Your request was not completed. There is some problem."));
        }

        exit(1);
    }

    public function updateComment() {
        $this->load->model('customer_model');
        $this->load->model('comment_model');

        $email = $this->input->post('email');
        $commentId = $this->input->post('comment_id');
        $comment = $this->input->post('comment');

        /* Get user detail */
        if ($email) {
            $user = $this->customer_model->getUserInfo($email);
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "Your email doesn't exist."));
            exit(1);
        }

        if (!$user || !$user[0]) {
            echo json_encode(array('status' => "failed", 'msg' => "This user doesn't exist."));
            exit(1);
        }

        $user = $user[0];
        if ( !$comment ) {
            echo json_encode(array('status' => "failed", 'msg' => "Parameter is missing."));
            exit(1);
        }

        $info = array('comment' => $comment, 'updated_at' => date('Y-m-d H:i:s'));
        $result = $this->comment_model->updateComment($commentId, $user->id, $info);

        if ($result) {
            echo json_encode(array('status' => "success", 'msg' => "You commented this music successfully."));
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "Your request was not completed. There is some problem."));
        }

        exit(1);
    }

    public function deleteComment() {
        $this->load->model('customer_model');
        $this->load->model('comment_model');

        $email = $this->input->post('email');
        $commentId = $this->input->post('comment_id');

        /* Get user detail */
        if ($email) {
            $user = $this->customer_model->getUserInfo($email);
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "Your email doesn't exist."));
            exit(1);
        }

        if (!$user || !$user[0]) {
            echo json_encode(array('status' => "failed", 'msg' => "This user doesn't exist."));
            exit(1);
        }

        $user = $user[0];
        $info = array('is_deleted' => 1, 'updated_at' => date('Y-m-d H:i:s'));
        $result = $this->comment_model->updateComment($commentId, $user->id, $info);

        if ($result) {
            echo json_encode(array('status' => "success", 'msg' => "You deleted the comment successfully."));
        } else {
            echo json_encode(array('status' => "failed", 'msg' => "Your request was not completed. There is some problem."));
        }

        exit(1);
    }
}

?>