<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Sync8 extends BaseController
{
    /**
     * This is default constructor of the class
     */

    //public $key_array = array('C','Db','D','Eb','E','F','Gb','G','Ab','A','Bb','B');
    public $player_kinds_array = array('loop','drums','bass','keys','aux','bgv','guitar');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('sample_model');
        $this->load->model('sample_item_model');
        $this->load->model('music_cell_model');
        $this->load->model('devicetoken_model');
        $this->load->model('paidstatus_model');
        $this->load->model('sync8_list_model');
        $this->load->model('sync8_item_model');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
         
    }

    public function index()
    {
        $this->isLoggedIn();  
        $this->global['pageTitle'] = 'Triggerz Sync8';
        $this->global['samples'] = $this->sync8_list_model->getAllSync8List();
        $this->global['search']='';
        $this->loadViews("sync8/sync8-lists", $this->global, NULL , NULL);
    }

    public function addNewSync8()
    {
        $this->isLoggedIn();  
        $this->global['pageTitle'] = 'Add New Sync8';
        $this->loadViews("sync8/addnewsync8", $this->global, NULL , NULL);
    }

    public function editSync8($sync8_id)
    {
        $this->isLoggedIn();  
        $sync8 = $this->sync8_list_model->getSync8($sync8_id);
        $this->global['sample'] = $sync8;      
        $this->global['pageTitle'] = 'Edit Sync8';
        $this->loadViews("sync8/sync8-edit", $this->global, NULL , NULL);
    }

    public function addNewSync8_B(){
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


        $result = $this->sync8_list_model->addNewSync8($data);
        $last_row = $this->sync8_list_model->getLastRow();
        
        for ($i=1; $i <= 9; $i++)
        { 
            $this->sync8_item_model->addEmptyCell();
            $last_item_row = $this->sync8_item_model->getLastRow();
            $this->sync8_list_model->addKeyItem($last_row[0]['id'],$i,$last_item_row[0]['id']);
        }
        redirect('index.php/editsync8/'.$last_row[0]['id']);

    }


    public function editSync8s($sample_id){
        $this->isLoggedIn();  
        $sample = $this->sync8_list_model->getSync8($sample_id);
        
        for ($i=1; $i <= 9; $i++) { 
            $sample[0]['key_item_'.$i] = $this->sync8_item_model->getCell($sample[0]['cell_'.$i]);
        }

        $this->global['sample'] = $sample[0];       
        $this->global['pageTitle'] = 'Edit Sample Sets';
        $this->loadViews("sync8/sync8-cell", $this->global, NULL , NULL);
    }


    public function musicUpload()
    {
        $sync8_cell_id = $this->input->post('sync8-cell-id');
        $sync8_music_no = $this->input->post('sync8-music-no');
        $sync8_id = $this->input->post('sync8-id');
        $sync8_cell_no = $this->input->post('sync8-cell-no');
        $upload_file_name = "";

        if($_FILES['sync8-music-file']['name']){
           
            $uploaddir = './assets/sync8-musicfiles/';
            $path = $_FILES['sync8-music-file']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $dest_filename = 'sync8_'.$sync8_id.'_'.$sync8_cell_no.'_'.$this->player_kinds_array[$sync8_music_no-1] . '.' . $ext;
            $uploadfile = $uploaddir .$dest_filename;
            $file_name = $dest_filename;
            if (move_uploaded_file($_FILES['sync8-music-file']['tmp_name'], $uploadfile)) {
                //$this->sample_item_model->editItemField($item_no,$field,$file_name);
                $upload_file_name = $file_name;
            } else {
               // echo "Possible file upload attack!\n";
                redirect('index.php/editsync8/'.$sync8_id);
            }

         }

         $this->sync8_item_model->updateMusicFile($sync8_cell_id,$sync8_music_no,$upload_file_name);
         redirect('index.php/editsync8/'.$sync8_id);
    }

    public function updateSync8_B()
    {
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

        $this->sync8_list_model->updateSync8($data);

        redirect('index.php/editsync8-id/'.$data['id']);
    }

    public function getSync8List()
    {
        $result = $this->sync8_list_model->getAllSync8List();
        
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

    public function getSync8($id)
    {
        $sync = $this->sync8_list_model->getSync8($id);

        if(count($sync)>0)
        {
            $data['success'] = 0;
            $data['id'] = $sync[0]['id'];
            $data['name'] = $sync[0]['name'];
            $data['description'] = $sync[0]['description'];
            $data['is_free'] = $sync[0]['is_free'];
            $data['price'] = $sync[0]['price'];
            $data['thumb'] = $sync[0]['thumb'] == ""? base_url()."assets/thumbimages/no_img.png":base_url().'assets/thumbimages/'.$sync[0]['thumb'];
            $data['bpm'] = $sync[0]['bpm'];

            $items = array();
            for($i = 1; $i <=9; $i++ )
            {
                if($sync[0]['cell_'.$i] == "" || $sync[0]['cell_'.$i] == null)
                {
                    $items['cell_'.$i] = "";
                }
                else
                {
                    $temp_item = $this->sync8_item_model->getCell($sync[0]['cell_'.$i]);
                    if(count($temp_item) == 0 )
                    {
                         $items['cell_'.$i] = "";
                    }
                    else
                    {
                        $temp['id'] = $temp_item[0]['id'];
                        $temp['name'] = $temp_item[0]['name'];
                        for($j = 1; $j <= 7; $j++)
                        {
                            $temp[$this->player_kinds_array[$j-1]] = $temp_item[0]['player_'.$j] == ""? "":base_url().'assets/sync8-musicfiles/'.$temp_item[0]['player_'.$j];
                        }

                         $items['cell_'.$i] = $temp;
                    }
                }
            }

            $data['items'] = $items;

            echo json_encode($data);
            exit();
        }

        $data['success'] = 1;
        $data['message'] = 'There is no any sample';
        echo json_encode($data);
        exit();
    }

    public function deleteSync8()
    {
        $this->isLoggedIn();
        $sync8_id = $this->input->post('sync8-id');
        $this->sync8_list_model->deletSync8($sync8_id);
        redirect('index.php/sync8-lists');
    }

    public function deleteMusicFile()
    {
        $this->isLoggedIn();
        $sync8_cell_id = $this->input->post('sync8-cell-id');
        $sync8_cell_no = $this->input->post('sync8-cell-no');
        $sync8_id = $this->input->post('sync8-id');
        $this->sync8_item_model->deleteMusicFile($sync8_cell_id, $sync8_cell_no);
        
        redirect('index.php/editsync8/'.$sync8_id);
    }

    public function editName()
    {
        $this->isLoggedIn();
        $sync8_cell_id = $this->input->post('sync8-cell-id');
        $sync8_cell_name = $this->input->post('sync8-cell-name');
        $sync8_id = $this->input->post('sync8-id');
        $this->sync8_item_model->editName($sync8_cell_id, $sync8_cell_name);
        
        redirect('index.php/editsync8/'.$sync8_id);
    }

}

?>