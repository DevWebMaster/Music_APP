<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class SampleSets extends BaseController
{
    /**
     * This is default constructor of the class
     */

    public $key_array = array('C','Db','D','Eb','E','F','Gb','G','Ab','A','Bb','B');
    public $player_kinds_array = array('drum','bass','piano','rhodes','organ','synth','guitar');

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
        $this->load->model('sync8_list_model');
        $this->load->model('sync8_item_model');

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
         
    }

    public function index()
    {
    	$this->isLoggedIn();  
        $this->global['pageTitle'] = 'Sample Sets List';
        $this->global['samples'] = $this->sample_model->getAllSample();
        $this->global['search']='';
        $this->loadViews("samplesetslist", $this->global, NULL , NULL);
    }

    public function addNewSampleSet()
    {
    	$this->isLoggedIn();  
    	$this->global['pageTitle'] = 'Add New Sample Set';
        $this->loadViews("addnewsampleset", $this->global, NULL , NULL);
    }

    public function editSampleSet($sample_id){
    	$this->isLoggedIn();  
    	$sample = $this->sample_model->getSample($sample_id);
		$this->global['sample'] = $sample;
        $sync4 = $this->sync4_list_model->getAllSync4List();
        $this->global['sync4s'] = $sync4;

    	$this->global['pageTitle'] = 'Edit Sample Set';
        $this->loadViews("sampleset", $this->global, NULL , NULL);
    }

    public function editSampleSets($sample_id){
    	$this->isLoggedIn();  
    	$sample = $this->sample_model->getSample($sample_id);
		
		for ($i=1; $i <= 20; $i++) { 
			$sample[0]['key_item_'.$i] = $this->sample_item_model->getSampleItem($sample[0]['key_'.$i]);
		}

		$this->global['sample'] = $sample[0];    	
    	$this->global['pageTitle'] = 'Edit Sample Sets';
        $this->loadViews("samplesets", $this->global, NULL , NULL);
    }
    
    public function editMusicFile(){

    	$this->isLoggedIn();  
 		$item_no = $this->input->post('item-no');
        $field = $this->input->post('field-name');
        $sample_no = $this->input->post('sample-no');
        $key_no = $this->input->post('key-no');
        $sample_item = $this->sample_item_model->getSampleItem($item_no);
        $cur_cell=array();
        if($sample_item[0][$field] == NULL || $sample_item[0][$field] =="" || $sample_item[0][$field] =="0")
        {
        	$this->music_cell_model->addEmptyCell();
        	$cur_cell = $this->music_cell_model->getLastRow();
        	$this->sample_item_model->editItemField($item_no,$field,$cur_cell[0]['id']);
        }
        else{
        	$cur_cell = $this->music_cell_model->getCell($sample_item[0][$field]);
        		
        }

		
     	$uploaddir = './assets/music-sample/';
     	$cell_data = array();
     	for($i = 1;$i <= 7; $i++)
     	{
     		$path = $_FILES['player_'.$i]['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);

     		//$uploadfile = $uploaddir .$sample_no.'_'.$item_no.'_'.$field.'_'.$cur_cell[0]['id'].'_'.$i.'_'. basename($_FILES['player_'.$i]['name']);
     		//$file_name = $sample_no.'_'.$item_no.'_'.$field.'_'.$cur_cell[0]['id'].'_'.$i.'_'. basename($_FILES['player_'.$i]['name']);

     		$uploadfile = $uploaddir .$sample_no.'_'.$field.'_'.$key_no.'_'.$this->player_kinds_array[$i-1].'.'.$ext;
     		$file_name = $sample_no.'_'.$field.'_'.$key_no.'_'.$this->player_kinds_array[$i-1].'.'.$ext;
     		if (move_uploaded_file($_FILES['player_'.$i]['tmp_name'], $uploadfile)) {
		    	//$this->sample_item_model->editItemField($item_no,$field,$file_name);
		    	$cell_data['player_'.$i] = $file_name;
			} else {
			   // echo "Possible file upload attack!\n";
			}
     	}

     	$this->music_cell_model->updateCell($cur_cell[0]['id'],$cell_data);

		//$uploadfile = $uploaddir .$sample_no.'_'.$item_no.'_'.$field.'_'. basename($_FILES['musicfile']['name']);
		// $file_name = $sample_no.'_'.$item_no.'_'.$field.'_'. basename($_FILES['musicfile']['name']);
		// if (move_uploaded_file($_FILES['musicfile']['tmp_name'], $uploadfile)) {
		//     $this->sample_item_model->editItemField($item_no,$field,$file_name);
		// } else {
		//    // echo "Possible file upload attack!\n";
		// }
		redirect('index.php/editsamplesets/'.$sample_no);

    }


    public function deleteMusicFile(){
    	$this->isLoggedIn();  
    	$item_no = $this->input->post('item-no');
        $field = $this->input->post('field-name');
        $sample_no = $this->input->post('sample-no');
        $this->sample_item_model->editItemField($item_no,$field,"");
        redirect('index.php/editsamplesets/'.$sample_no);
    }

    public function deletMusicOneFile()
    {

    	$item_no = $this->input->post('item_no');
        $field = $this->input->post('field_name');
        $sample_no = $this->input->post('sample_no');
        $player_no = $this->input->post('player_no');
        $sample_item = $this->sample_item_model->getSampleItem($item_no);
        $music_cell = $this->music_cell_model->getCell($sample_item[0][$field]);
        $data['player_'.$player_no] = '';
        $this->music_cell_model->updateCell($music_cell[0]['id'],$data);
		$data['success'] = 0;
    	
        echo json_encode($data);

    }

    public function deleteSampleSet(){
    	$this->isLoggedIn();  
    	$sample_no = $this->input->post('sample-no');
    	$this->sample_model->deleteSample($sample_no);
    	redirect('index.php/sample-sets-list');
    }


    public function searchSample(){
    	$this->isLoggedIn();  
    	$this->global['pageTitle'] = 'Search Sample';
    	$search = $this->input->post('searchText');
        $this->global['samples'] = $this->sample_model->searcSample($search);
        $this->global['search']=$search;
        $this->loadViews("samplesetslist", $this->global, NULL , NULL);
    }



    /**
    *	backend part
    */

    public function addNewSampleSet_B(){
    	$data['name'] = $this->input->post('sname');
    	$data['description'] = $this->input->post('sdescription');
    	$data['price']	= $this->input->post('sprice');
        $data['bpm'] = $this->input->post('bpm');

    	if($this->input->post('sfree'))
    	{
    		$data['is_free'] = 'yes';
    	}
    	else{
    		$data['is_free'] = 'no';
    	}

    	$data['option'] = $this->input->post('option');

        if ($data['option'] == 'construction') {
            $data['option_value'] = $this->input->post('master_code');
        }

        if ($data['option'] == 'demo') {
            $data['option_value'] = $this->input->post('demo_link');
        }

        if ($data['option'] == 'buy') {
            $data['option_value'] = '';
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


    	$result = $this->sample_model->addNewSample($data);

    	if ($result) {
    		$last_row = $this->sample_model->getLastRow();

    		for ($i=1; $i <= 20; $i++)
    		{ 
    			$this->sample_item_model->addEmptyItem();
    			$last_item_row = $this->sample_item_model->getLastRow();
    			$this->sample_model->addKeyItem($last_row[0]['id'],$i,$last_item_row[0]['id']);
    			//$item_upadate_data = array();
    			// foreach($this->key_array as $key_item) { 
    			// 	$this->music_cell_model->addEmptyCell();
    			// 	$last_cell = $this->music_cell_model->getLastRow();
    			// 	$item_upadate_data[$key_item] = $last_cell[0]['id'];
    			// }
    			// $this->sample_item_model->updateItem($last_item_row[0]['id'],$item_upadate_data);
    		}

    		//$last_item_row = $this->sample_item_model->getLastRow();

    		redirect('index.php/editsamplesets/'.$last_row[0]['id']);
    	}
    }

    public function updateSampleSet_B(){
    	$data['id'] = $this->input->post('sid');
    	$data['name'] = $this->input->post('sname');
    	$data['description'] = $this->input->post('sdescription');
    	$data['price']	= $this->input->post('sprice');
        $data['bpm'] = $this->input->post('bpm');
        $data['sync4'] = $this->input->post('sync4');
        $data['sync4_2'] = $this->input->post('sync4_2');
    	if($this->input->post('sfree'))
    	{
    		$data['is_free'] = 'yes';
    	}
    	else{
    		$data['is_free'] = 'no';
    	}

        $data['option'] = $this->input->post('option');

        if ($data['option'] == 'construction') {
            $data['option_value'] = $this->input->post('master_code');
        }

        if ($data['option'] == 'demo') {
            $data['option_value'] = $this->input->post('demo_link');
        }

        if ($data['option'] == 'buy') {
            $data['option_value'] = '';
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

    	$this->sample_model->updateSample($data);

    	redirect('index.php/editsampleset/'.$data['id']);
    }


    public function getSetList()
    {
    	$result = $this->sample_model->getAllSample();
    	
    	$data = array();
        $items = array();
    	if(count($result)>0)
    	{
    		$data['success'] = 0;
    		
    		//$data['items'] = $result;
    		
    		for ($i=0; $i < count($result) ; $i++) { 
    			$temp['id'] = $result[$i]['id'];
    			$temp['name'] = $result[$i]['name'];
    			$temp['description'] = $result[$i]['description'];
    			$temp['is_free'] = $result[$i]['is_free'];
    			$temp['price'] = $result[$i]['price'];
                $temp['thumb'] = $result[$i]['thumb'] == ""? base_url()."assets/thumbimages/no_img.png":base_url().'assets/thumbimages/'.$result[$i]['thumb'];
                $temp['bpm'] = $result[$i]['bpm'];
                $temp['option'] = $result[$i]['option'];
                $temp['option_value'] = $result[$i]['option_value'];

                $sync4_l = array();
                if ($result[$i]['sync4']) {
                    $result_sync4_l = $this->sync4_list_model->getSync4($result[$i]['sync4']);
                    if(count($result_sync4_l)>0)
                    {
                        $sync4_l['success'] = 0;
                        $sync4_l['description'] = $result_sync4_l[0]['description'];
                        $sync4_l['is_free'] = $result_sync4_l[0]['is_free'];
                        $sync4_l['price'] = $result_sync4_l[0]['price'];
                        $sync4_l['thumb'] = $result_sync4_l[0]['thumb'] == ""? base_url()."assets/thumbimages/no_img.png":base_url().'assets/thumbimages/'.$result[0]['thumb'];
                        $sync4_l['music_1'] = $result_sync4_l[0]['music_1'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result_sync4_l[0]['music_1'];
                        $sync4_l['music_2'] = $result_sync4_l[0]['music_2'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result_sync4_l[0]['music_2'];
                        $sync4_l['music_3'] = $result_sync4_l[0]['music_3'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result_sync4_l[0]['music_3'];
                        $sync4_l['music_4'] = $result_sync4_l[0]['music_4'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result_sync4_l[0]['music_4'];
                        $sync4_l['music_5'] = $result_sync4_l[0]['music_5'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result_sync4_l[0]['music_5'];

                        $sync4_l['music_title_1'] = $result_sync4_l[0]['music_title_1'] == ""? "":$result_sync4_l[0]['music_title_1'];
                        $sync4_l['music_title_2'] = $result_sync4_l[0]['music_title_2'] == ""? "":$result_sync4_l[0]['music_title_2'];
                        $sync4_l['music_title_3'] = $result_sync4_l[0]['music_title_3'] == ""? "":$result_sync4_l[0]['music_title_3'];
                        $sync4_l['music_title_4'] = $result_sync4_l[0]['music_title_4'] == ""? "":$result_sync4_l[0]['music_title_4'];
                        $sync4_l['music_title_5'] = $result_sync4_l[0]['music_title_5'] == ""? "":$result_sync4_l[0]['music_title_5'];

                        $sync4_l['drum_1'] = $result_sync4_l[0]['drum_1'] == ""? "":base_url().'assets/sync4-drumfiles/'.$result_sync4_l[0]['drum_1'];
                        $sync4_l['drum_2'] = $result_sync4_l[0]['drum_2'] == ""? "":base_url().'assets/sync4-drumfiles/'.$result_sync4_l[0]['drum_2'];
                        $sync4_l['drum_3'] = $result_sync4_l[0]['drum_3'] == ""? "":base_url().'assets/sync4-drumfiles/'.$result_sync4_l[0]['drum_3'];
                        $sync4_l['drum_4'] = $result_sync4_l[0]['drum_4'] == ""? "":base_url().'assets/sync4-drumfiles/'.$result_sync4_l[0]['drum_4'];
                        $sync4_l['drum_5'] = $result_sync4_l[0]['drum_5'] == ""? "":base_url().'assets/sync4-drumfiles/'.$result_sync4_l[0]['drum_5'];

                        $sync4_l['bpm'] = $result_sync4_l[0]['bpm'];
                    }
                }
                $temp['sync4_left']['id'] = $result[$i]['sync4'];
                $temp['sync4_left']['data'] = $sync4_l;

                $sync4_r = array();
                if ($result[$i]['sync4_2']) {
                    $result_sync4_r = $this->sync4_list_model->getSync4($result[$i]['sync4_2']);
                    if(count($result_sync4_r)>0)
                    {
                        $sync4_r['success'] = 0;
                        $sync4_r['description'] = $result_sync4_r[0]['description'];
                        $sync4_r['is_free'] = $result_sync4_r[0]['is_free'];
                        $sync4_r['price'] = $result_sync4_r[0]['price'];
                        $sync4_r['thumb'] = $result_sync4_r[0]['thumb'] == ""? base_url()."assets/thumbimages/no_img.png":base_url().'assets/thumbimages/'.$result[0]['thumb'];
                        $sync4_r['music_1'] = $result_sync4_r[0]['music_1'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result_sync4_r[0]['music_1'];
                        $sync4_r['music_2'] = $result_sync4_r[0]['music_2'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result_sync4_r[0]['music_2'];
                        $sync4_r['music_3'] = $result_sync4_r[0]['music_3'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result_sync4_r[0]['music_3'];
                        $sync4_r['music_4'] = $result_sync4_r[0]['music_4'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result_sync4_r[0]['music_4'];
                        $sync4_r['music_5'] = $result_sync4_r[0]['music_5'] == ""? "":base_url().'assets/sync4-musicfiles/'.$result_sync4_r[0]['music_5'];

                        $sync4_r['music_title_1'] = $result_sync4_r[0]['music_title_1'] == ""? "":$result_sync4_r[0]['music_title_1'];
                        $sync4_r['music_title_2'] = $result_sync4_r[0]['music_title_2'] == ""? "":$result_sync4_r[0]['music_title_2'];
                        $sync4_r['music_title_3'] = $result_sync4_r[0]['music_title_3'] == ""? "":$result_sync4_r[0]['music_title_3'];
                        $sync4_r['music_title_4'] = $result_sync4_r[0]['music_title_4'] == ""? "":$result_sync4_r[0]['music_title_4'];
                        $sync4_r['music_title_5'] = $result_sync4_r[0]['music_title_5'] == ""? "":$result_sync4_r[0]['music_title_5'];

                        $sync4_r['drum_1'] = $result_sync4_r[0]['drum_1'] == ""? "":base_url().'assets/sync4-drumfiles/'.$result_sync4_r[0]['drum_1'];
                        $sync4_r['drum_2'] = $result_sync4_r[0]['drum_2'] == ""? "":base_url().'assets/sync4-drumfiles/'.$result_sync4_r[0]['drum_2'];
                        $sync4_r['drum_3'] = $result_sync4_r[0]['drum_3'] == ""? "":base_url().'assets/sync4-drumfiles/'.$result_sync4_r[0]['drum_3'];
                        $sync4_r['drum_4'] = $result_sync4_r[0]['drum_4'] == ""? "":base_url().'assets/sync4-drumfiles/'.$result_sync4_r[0]['drum_4'];
                        $sync4_r['drum_5'] = $result_sync4_r[0]['drum_5'] == ""? "":base_url().'assets/sync4-drumfiles/'.$result_sync4_r[0]['drum_5'];

                        $sync4_r['bpm'] = $result_sync4_r[0]['bpm'];
                    }
                }
                $temp['sync4_right']['id'] = $result[$i]['sync4_2'];
                $temp['sync4_right']['data'] = $sync4_r;

                $temp['set_type'] = "1";
    			$items[] = $temp;
    		}

    	}
    

        $result8 = $this->sync8_list_model->getAllSync8List();
        if(count($result8)>0)
        {
            for ($i=0; $i < count($result8); $i++) {
                $temp8['id'] = $result8[$i]['id'];
                $temp8['name'] = $result8[$i]['name'];
                $temp8['description'] = $result8[$i]['description'];
                $temp8['is_free'] = $result8[$i]['is_free'];
                $temp8['price'] = $result8[$i]['price'];
                $temp8['thumb'] = $result8[$i]['thumb'] == ""? base_url()."assets/thumbimages/no_img.png":base_url().'assets/thumbimages/'.$result8[$i]['thumb'];
                $temp8['bpm'] = $result8[$i]['bpm'];
                $temp8['sync4'] = "0";
                $temp8['set_type'] = "2";

                $cell_list = array();
                for($j = 1; $j <=9; $j++ )
                {
                    if($result8[$i]['cell_'.$j] == "" || $result8[$i]['cell_'.$j] == null)
                    {
                        $cell_list['cell_'.$j] = "";
                    }
                    else
                    {
                        $temp_item = $this->sync8_item_model->getCell($result8[$i]['cell_'.$j]);
                        if(count($temp_item) == 0 )
                        {
                            $cell_list['cell_'.$j] = "";
                        }
                        else
                        {
                            $temp_cell['id'] = $temp_item[0]['id'];
                            $temp_cell['name'] = $temp_item[0]['name'];
                            for($k = 1; $k <= 7; $k++)
                            {
                                $temp_cell[$this->player_kinds_array[$k-1]] = $temp_item[0]['player_'.$k] == ""?
                                    "":base_url().'assets/sync8-musicfiles/'.$temp_item[0]['player_'.$k];
                            }

                            $cell_list['cell_'.$j] = $temp_cell;
                        }
                    }
                }

                $temp8['cells'] = $cell_list;

                $items[] = $temp8;
            }
        }

        if(count($items)>0)
        {
            $data['items'] = $items;
            $data['count'] = count($items);
            echo json_encode($data);
            exit();
        }

        $data['success'] = 1;
        $data['message'] = 'There is no any sample';
        echo json_encode($data);
        exit();
    }

    public function getSet($sample_id,$key){
    	$sample = $this->sample_model->getSample($sample_id);
		$data = array();

		if (count($sample)>0)
		{
			$data['success'] = 0;
			$data['id'] = $sample[0]['id'];
			$data['name'] = $sample[0]['name'];
			$data['description'] = $sample[0]['description'];
			$data['is_free'] = $sample[0]['is_free'];
            $temp['option'] = $sample[0]['option'];
            $temp['option_value'] = $sample[0]['option_value'];
			$data['key'] = $key;
			$items = array();

			if ($key == 'key') {
                for ($i=1; $i <= 12; $i++) {
                    $temp = $this->sample_item_model->getSampleItem($sample[0]['key_'.$i]);
                    $items['key_'.$i] = $temp[0][$key];
                    if($items['key_'.$i] != null){
                        //$items['key_'.$i] = base_url().'assets/music-sample/'.$items['key_'.$i];
                        $cell = $this->music_cell_model->getCell($items['key_'.$i]);
                        if (count($cell)>0) {

                            $temp = array();
                            for($j = 1;$j<=7;$j++)
                            {

                                if($cell[0]['player_'.$j] == NULL)
                                {
                                    //$items['key_'.$i]['player_'.$j] = '';
                                    $temp[$this->player_kinds_array[$j-1]] = '';
                                }
                                else{
                                    //$items['key_'.$i]['player_'.$j] = base_url().'assets/music-sample/'.$cell[0]["player_".$j];
                                    $temp[$this->player_kinds_array[$j-1]] = base_url().'assets/music-sample/'.$cell[0]["player_".$j];
                                }
                            }
                            $items['key_'.$i] = $temp;

                        }
                        else{
                            $items['key_'.$i] = '';
                        }

                    }
                    else{
                        $items['key_'.$i] = '';
                    }

                }
            } else {
                for ($i=1; $i <= 20; $i++) {
                    $temp = $this->sample_item_model->getSampleItem($sample[0]['key_'.$i]);
                    $items['key_'.$i] = $temp[0][$key];
                    if($items['key_'.$i] != null){
                        //$items['key_'.$i] = base_url().'assets/music-sample/'.$items['key_'.$i];
                        $cell = $this->music_cell_model->getCell($items['key_'.$i]);
                        if (count($cell)>0) {

                            $temp = array();
                            for($j = 1;$j<=7;$j++)
                            {

                                if($cell[0]['player_'.$j] == NULL)
                                {
                                    //$items['key_'.$i]['player_'.$j] = '';
                                    $temp[$this->player_kinds_array[$j-1]] = '';
                                }
                                else{
                                    //$items['key_'.$i]['player_'.$j] = base_url().'assets/music-sample/'.$cell[0]["player_".$j];
                                    $temp[$this->player_kinds_array[$j-1]] = base_url().'assets/music-sample/'.$cell[0]["player_".$j];
                                }
                            }
                            $items['key_'.$i] = $temp;

                        }
                        else{
                            $items['key_'.$i] = '';
                        }

                    }
                    else{
                        $items['key_'.$i] = '';
                    }

                }
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

    public function getMusicFile($sample_id,$key,$num){
    	$sample = $this->sample_model->getSample($sample_id);
    	if(count($sample)>0)
    	{
    		$item_id = $sample[0]['key_'.$num];
    		$item = $this->sample_item_model->getSampleItem($item_id);
    		$url = $item[0][$key];
    		if($url == NULL)
    		{
    			$data['success'] = 1;
    			$data['message'] = 'This item is empty!';
    			echo json_encode($data);
    			exit();
    		}
    		else{
    			$data['success'] = 0;
    			//$data['url'] = base_url().'assets/music-sample/'.$url;
    			$cell = $this->music_cell_model->getCell($url);
    			if(count($cell)>0)
    			{
    				$data['id'] = $url;
    				$temp = array();
    				for ($i=1; $i <= 7; $i++) { 
                        $temp_url_item = $cell[0]['player_'.$i]=="" ? "" : base_url().'assets/music-sample/'.$cell[0]['player_'.$i];
    					$temp[$this->player_kinds_array[$i-1]] = $temp_url_item;
    				}
    				$data['items'] = $temp;
    				echo json_encode($data);
    				exit();
    			}
    			else{
    				$data['success'] = 1;
    				$data['message'] = 'This item is empty!';
    				echo json_encode($data);
    				exit();
    			}
    			
    		}
    	}
    	else{
    		$data['success'] = 1;
    		$data['message'] = 'There is no any sample';
    		echo json_encode($data);
    		exit();
    	}
    }

    public function updateOrder()
    {
    	$sample_id = $this->input->post('sample_id');
    	$order = $this->input->post('order');
    	$type = $this->input->post('type');
    	$this->sample_model->updateOrder($sample_id,$order,$type);
    	$data = array(
    		'success' => 0,
    		'message' => 'update successed'
    	);
    	echo json_encode($data);
    }

    public function getOrder($sample_id,$type)
    {
    	$sample = $this->sample_model->getSample($sample_id);
    	if(count($sample)>0)
    	{
			$data['success'] = 0;
			$data['type'] = $type;
			$data['order'] = $sample[0][$type];
			echo json_encode($data);
    	}
    	else{
    		$data['success'] = 1;
    		$data['message'] = 'There is no any sample';
    		echo json_encode($data);
    		exit();
    	}
    }

    public function getMusicFiles($cell_id)
    {
    	$cell = $this->music_cell_model->getCell($cell_id);
    	if(count($cell)>0){
    		
    		$data = $cell[0];
    		$data['success'] = 0;
    		//var_dump($cell);
    		for($i=1;$i<=7;$i++)
    		{
    			$data['player_'.$i] = base_url().'assets/music-sample/'.$cell[0]['player_'.$i];
    			if($cell[0]['player_'.$i] == NULL)
    			{
    				$data['player_'.$i] = "";
    			}
    		}
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

    public function sendNotification()
    {
    	// $tokens = $this->devicetoken_model->getTokens();
    	// if(count($tokens)!=0){
		    // $ch = curl_init("https://fcm.googleapis.com/fcm/send");
		    // //The device token.
		    // $token = "tt"; //token here
		    // //Title of the Notification.
		    // $title = "updated";
		    // //Body of the Notification.
		    // $body = "This is the body show Notification";
		    // //Creating the notification array.
		    // $notification = array('title' =>$title , 'text' => $body);
		    // //This array contains, the token and the notification. The 'to' attribute stores the token.
		    // $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
		    // //Generating JSON encoded string form the above array.
		    // $json = json_encode($arrayToSend);
		    // //Setup headers:
		    // $headers = array();
		    // $headers[] = 'Content-Type: application/json';
		    // $headers[] = 'Authorization: key=AIzaSyDeDiOQh-jd2pH47BrWo4M9xJ-YL_e9JpY'; // key here
		    // //Setup curl, add headers and post parameters.
		    // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		    // curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		    // curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);       
		    // //Send the request
		    // $response = curl_exec($ch);
		    // //Close request
		    // curl_close($ch);
		    // return $response;
    	//}
                $passphrase = 'song'; 
                $message = 'my push notification';
                $ctx = stream_context_create();
                // Change 3 : APNS Cert File name and location.
                stream_context_set_option($ctx, 'ssl', 'local_cert', dirname(__FILE__) .'/ck.pem'); 
                stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
                // Open a connection to the APNS server
                $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
                if (!$fp)
                    exit("Failed to connect: $err $errstr" . PHP_EOL);
                echo 'Connected to APNS' . PHP_EOL;
                // Create the payload body
                $body['aps'] = array(
                    'alert' => $message,
                    'sound' => 'default'
                    );
                // Encode the payload as JSON
                $payload = json_encode($body);
		$tokens = $this->devicetoken_model->getTokens();
    	if(count($tokens)!=0){
    		foreach ($tokens as $token) {
		    	// $fcmApiKey = 'AIzaSyDeDiOQh-jd2pH47BrWo4M9xJ-YL_e9JpY';//App API Key(This is google cloud messaging api key not web api key)
		     //    $url = 'https://fcm.googleapis.com/fcm/send';//Google URL
		 
		    	// $registrationIds = $token['token'];//$dataArr['device_id'];//Fcm Device ids array
		 
		    	// $message ='update';// $dataArr['message'];//Message which you want to send
		     //    $title = 'music sample is updated';//$dataArr['message'];
		 
		     //    // prepare the bundle
		     //    $msg = array('message' => $message,'title' => $title);
		     //    $fields = array('registration_ids' => $registrationIds,'data' => $msg);
		 
		     //    $headers = array(
		     //        'Authorization: key=' . $fcmApiKey,
		     //        'Content-Type: application/json'
		     //    );
		 
		     //    $ch = curl_init();
		     //    curl_setopt( $ch,CURLOPT_URL, $url );
		     //    curl_setopt( $ch,CURLOPT_POST, true );
		     //    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		     //    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		     //    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		     //    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		     //    $result = curl_exec($ch );
		     //    // Execute post
		     //    $result = curl_exec($ch);
		     //    if ($result === FALSE) {
		     //        die('Curl failed: ' . curl_error($ch));
		     //    }
		     //    // Close connection
		     //    curl_close($ch);    
		     //    return $result;



                $deviceToken= $token; 
                // Change 2 : If any
               
                // Build the binary notification
                $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
                // Send it to the server
                 fwrite($fp, $msg, strlen($msg));
                
               

    		}

   	 	}
         fclose($fp);
    }

    public function registerDeviceToken($token)
    {
    	if(!$this->devicetoken_model->is_registered($token))
    	{
    		$this->devicetoken_model->addToken($token);
    	}
    }

    public function updatePaidState($token,$sample_id,$key_name,$update_state)
    {
        $token_id  = $this->devicetoken_model->getTokenID($token);
        if(!$token_id)
        {
           $this->registerDeviceToken($token);
           $token_id  = $this->devicetoken_model->getTokenID($token);
        }
       
        $paidstatus = $this->paidstatus_model->getPaidStatusItem($sample_id,$token_id);
        
        if(!$paidstatus){
            $this->paidstatus_model->addNewItem($token_id,$sample_id);
            $paidstatus = $this->paidstatus_model->getPaidStatusItem($sample_id,$token_id);
        }

        if($key_name == 'All')
        {
            $this->paidstatus_model->updateStatusAll($token_id,$sample_id,$update_state);
        }
        else{
            $this->paidstatus_model->updateStatus($token_id,$sample_id,$key_name,$update_state);
        }

    }

    public function getPaidState($token,$sample_id,$key_name)
    {
        $token_id  = $this->devicetoken_model->getTokenID($token);
         if(!$token_id)
        {
           $this->registerDeviceToken($token);
           $token_id  = $this->devicetoken_model->getTokenID($token);

        }

        $paidstatus = $this->paidstatus_model->getPaidStatusItem($sample_id,$token_id);
        
        if(!$paidstatus){
            $this->paidstatus_model->addNewItem($token_id,$sample_id);
            $paidstatus = $this->paidstatus_model->getPaidStatusItem($sample_id,$token_id);
        }

        $data['success'] = 0;
        $data['status'] =  $paidstatus[$key_name];

        echo json_encode($data);

    }

}