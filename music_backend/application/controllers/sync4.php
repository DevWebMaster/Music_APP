<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Sync4 extends BaseController
{
    /**
     * This is default constructor of the class
     */

    //public $key_array = array('C','Db','D','Eb','E','F','Gb','G','Ab','A','Bb','B');
    //public $player_kinds_array = array('drum','bass','piano','rhodes','organ','synth','guitar');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('sample_model');
        $this->load->model('sample_item_model');
        $this->load->model('music_cell_model');
        $this->load->model('devicetoken_model');
        $this->load->model('paidstatus_model');
        $this->load->model('sync4_list_model');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

    }

    public function index()
    {
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'Triggerz Sync4';
        $this->global['samples'] = $this->sync4_list_model->getAllSync4List();
        $this->global['search']='';
        $this->loadViews("sync4/sync4-lists", $this->global, NULL , NULL);
    }

    public function addNewSync4()
    {
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'Add New Sync4';
        $this->loadViews("sync4/addnewsync4", $this->global, NULL , NULL);
    }


    public function editSync4($sync4_id){
        $this->isLoggedIn();
        $sync4 = $this->sync4_list_model->getSync4($sync4_id);
        $this->global['sample'] = $sync4;
        $this->global['pageTitle'] = 'Edit Sync4';
        $this->loadViews("sync4/editsync4", $this->global, NULL , NULL);
    }



    public function addNewSync4_B(){
        $data['name'] = $this->input->post('sname');
        $data['description'] = $this->input->post('sdescription');
        $data['price']  = $this->input->post('sprice');
        $data['bpm'] = $this->input->post('bpm');

        if($this->input->post('sfree'))
        {
            $data['is_free'] = 'yes';
        }
        else{
            $data['is_free'] = 'no';
        }
        $data['thumb'] = "";
        $uploaddir = './assets/thumbimages/';
        $path = $_FILES['thumbimg']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $dest_filename = md5(uniqid(rand(), true)) . '.' . $ext;
        $uploadfile = $uploaddir .$dest_filename;
        $file_name = $dest_filename;
        if (move_uploaded_file($_FILES['thumbimg']['tmp_name'], $uploadfile)) {
            //$this->sample_item_model->editItemField($item_no,$field,$file_name);
            $data['thumb'] = $file_name;
        } else {
            // echo "Possible file upload attack!\n";
        }


        $result = $this->sync4_list_model->addNewSync4($data);
        $last_row = $this->sync4_list_model->getLastRow();
        redirect('index.php/editsync4/'.$last_row[0]['id']);

        //redirect('index.php/addnewsync4');

    }

    public function updateSync4_B(){
        $data['id'] = $this->input->post('sid');
        $data['name'] = $this->input->post('sname');
        $data['description'] = $this->input->post('sdescription');
        $data['price']  = $this->input->post('sprice');
        $data['bpm'] = $this->input->post('bpm');
        if($this->input->post('sfree'))
        {
            $data['is_free'] = 'yes';
        }
        else{
            $data['is_free'] = 'no';
        }
        if($_FILES['thumbimg']['name']){
            $data['thumb'] = "";
            $uploaddir = './assets/thumbimages/';
            $path = $_FILES['thumbimg']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $dest_filename = md5(uniqid(rand(), true)) . '.' . $ext;
            $uploadfile = $uploaddir .$dest_filename;
            $file_name = $dest_filename;
            if (move_uploaded_file($_FILES['thumbimg']['tmp_name'], $uploadfile)) {
                //$this->sample_item_model->editItemField($item_no,$field,$file_name);
                $data['thumb'] = $file_name;
            } else {
                // echo "Possible file upload attack!\n";
            }
        }

        $this->sync4_list_model->updateSync4($data);

        redirect('index.php/editsync4/'.$data['id']);
    }

    public function musicUpload()
    {
        $sync4_id = $this->input->post('sync4-id');
        $sync4_music_no = $this->input->post('sync4-music-no');
        $sync4_drum_no = $this->input->post('sync4-drum-no');
        $upload_file_name = "";

        if($_FILES['sync4-music-file']['name']){

            $uploaddir = './assets/sync4-musicfiles/';
            $path = $_FILES['sync4-music-file']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $dest_filename = "sync4_". $sync4_id."_" . $sync4_music_no . '.' . $ext;
            $uploadfile = $uploaddir .$dest_filename;
            $file_name = $dest_filename;
            if (move_uploaded_file($_FILES['sync4-music-file']['tmp_name'], $uploadfile)) {
                //$this->sample_item_model->editItemField($item_no,$field,$file_name);
                $upload_file_name = $file_name;
            } else {
                // echo "Possible file upload attack!\n";
                redirect('index.php/editsync4/'.$sync4_id);
            }

            $this->sync4_list_model->updateMusicFile($sync4_id,$sync4_music_no,$upload_file_name);
        }

        if($_FILES['sync4-drum-file']['name']){

            $uploadDrumDir = './assets/sync4-drumfiles/';
            $path = $_FILES['sync4-drum-file']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $drum_dest_filename = "sync4_drum_". $sync4_id."_" . $sync4_drum_no . '.' . $ext;
            $uploadDrumFile = $uploadDrumDir . $drum_dest_filename;
            $drum_file_name = $drum_dest_filename;
            if (move_uploaded_file($_FILES['sync4-drum-file']['tmp_name'], $uploadDrumFile)) {
                //$this->sample_item_model->editItemField($item_no,$field,$file_name);
                $upload_drum_file_name = $drum_file_name;
            } else {
                // echo "Possible file upload attack!\n";
                redirect('index.php/editsync4/'.$sync4_id);
            }

            $this->sync4_list_model->updateMusicDrumFile($sync4_id, $sync4_drum_no, $upload_drum_file_name);
        }


        redirect('index.php/editsync4/'.$sync4_id);
    }


    public function getSync4List()
    {
        $result = $this->sync4_list_model->getAllSync4List();

        $data = array();
        if(count($result)>0)
        {
            $data['success'] = 0;
            $data['count']  =   count($result);
            //$data['items'] = $result;
            $items = array();
            for ($i=0; $i < count($result) ; $i++) {
                $temp['id'] = $result[$i]['id'];
                $temp['name'] = $result[$i]['name'];
                $temp['description'] = $result[$i]['description'];
                $temp['is_free'] = $result[$i]['is_free'];
                $temp['price'] = $result[$i]['price'];
                $temp['thumb'] = $result[$i]['thumb'] == ""? base_url()."assets/thumbimages/no_img.png":base_url().'assets/thumbimages/'.$result[$i]['thumb'];
                $temp['music_1'] = $result[$i]['music_1'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result[$i]['music_1'];
                $temp['music_2'] = $result[$i]['music_2'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result[$i]['music_2'];
                $temp['music_3'] = $result[$i]['music_3'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result[$i]['music_3'];
                $temp['music_4'] = $result[$i]['music_4'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result[$i]['music_4'];
                $temp['music_5'] = $result[$i]['music_5'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result[$i]['music_5'];

                $temp['music_title_1'] = $result[$i]['music_title_1'] == ""? "":$result[$i]['music_title_1'];
                $temp['music_title_2'] = $result[$i]['music_title_2'] == ""? "":$result[$i]['music_title_2'];
                $temp['music_title_3'] = $result[$i]['music_title_3'] == ""? "":$result[$i]['music_title_3'];
                $temp['music_title_4'] = $result[$i]['music_title_4'] == ""? "":$result[$i]['music_title_4'];
                $temp['music_title_5'] = $result[$i]['music_title_5'] == ""? "":$result[$i]['music_title_5'];

                $temp['drum_1'] = $result[$i]['drum_1'] == ""? "":$result[$i]['drum_1'];
                $temp['drum_2'] = $result[$i]['drum_2'] == ""? "":$result[$i]['drum_2'];
                $temp['drum_3'] = $result[$i]['drum_3'] == ""? "":$result[$i]['drum_3'];
                $temp['drum_4'] = $result[$i]['drum_4'] == ""? "":$result[$i]['drum_4'];
                $temp['drum_5'] = $result[$i]['drum_5'] == ""? "":$result[$i]['drum_5'];
                $temp['bpm'] = $result[$i]['bpm'];
                $items[] = $temp;
            }
            $data['items'] = $items;
            echo json_encode($data);
            exit();
        }
        else{

            $data['success'] = 1;
            $data['message'] = 'There is no any sample';
            echo json_encode($data);
            exit();
        }
    }

    public function getSync4Item($id)
    {
        $result = $this->sync4_list_model->getSync4($id);
        if(count($result)>0)
        {
            $data['success'] = 0;
            $data['description'] = $result[0]['description'];
            $data['is_free'] = $result[0]['is_free'];
            $data['price'] = $result[0]['price'];
            $data['thumb'] = $result[0]['thumb'] == ""? base_url()."assets/thumbimages/no_img.png":base_url().'assets/thumbimages/'.$result[0]['thumb'];
            $data['music_1'] = $result[0]['music_1'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result[0]['music_1'];
            $data['music_2'] = $result[0]['music_2'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result[0]['music_2'];
            $data['music_3'] = $result[0]['music_3'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result[0]['music_3'];
            $data['music_4'] = $result[0]['music_4'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result[0]['music_4'];
            $data['music_5'] = $result[0]['music_5'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result[0]['music_5'];

            $data['music_title_1'] = $result[0]['music_title_1'] == ""? "":$result[0]['music_title_1'];
            $data['music_title_2'] = $result[0]['music_title_2'] == ""? "":$result[0]['music_title_2'];
            $data['music_title_3'] = $result[0]['music_title_3'] == ""? "":$result[0]['music_title_3'];
            $data['music_title_4'] = $result[0]['music_title_4'] == ""? "":$result[0]['music_title_4'];
            $data['music_title_5'] = $result[0]['music_title_5'] == ""? "":$result[0]['music_title_5'];

            $data['drum_1'] = $result[0]['drum_1'] == ""? "":$result[0]['drum_1'];
            $data['drum_2'] = $result[0]['drum_2'] == ""? "":$result[0]['drum_2'];
            $data['drum_3'] = $result[0]['drum_3'] == ""? "":$result[0]['drum_3'];
            $data['drum_4'] = $result[0]['drum_4'] == ""? "":$result[0]['drum_4'];
            $data['drum_5'] = $result[0]['drum_5'] == ""? "":$result[0]['drum_5'];
            $data['bpm'] = $result[0]['bpm'];

            echo json_encode($data);
            exit();
        }
        else{
            $data['success'] = 1;
            $data['message'] = 'There is no any data';
            echo json_encode($data);
            exit();
        }
    }

    public function deleteSync4()
    {
        $this->isLoggedIn();
        $sync4_no = $this->input->post("sync4-no");
        $this->sync4_list_model->deleteSync4($sync4_no);
        redirect("index.php/sync4-lists");
    }

    public function deleteMusicFile()
    {
        $this->isLoggedIn();
        $sync4_id = $this->input->post("sync4-id");
        $sync4_no = $this->input->post("sync4-music-no");

        if ($sync4_no) {
            $this->sync4_list_model->deleteMusicFile($sync4_id, $sync4_no);
        }

        $sync4_drum_no = $this->input->post("sync4-drum-no");

        if ($sync4_drum_no) {
            $this->sync4_list_model->deleteDrumFile($sync4_id, $sync4_drum_no);
        }

        redirect("index.php/editsync4/".$sync4_id);
    }

    public function editMusicName()
    {
        $this->isLoggedIn();
        $sync4_music_id = $this->input->post('sync4-music-no');
        $sync4_music_name = $this->input->post('sync4-music-name');
        $sync4_id = $this->input->post('sync4-id');
        $this->sync4_list_model->editMusicName($sync4_id, $sync4_music_id, $sync4_music_name);

        redirect('index.php/editsync4/'.$sync4_id);
    }
}