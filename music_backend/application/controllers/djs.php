<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : djs (djsController)
 * djs Class to control all djs related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Djs extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('djs_model');
        date_default_timezone_set('Africa/Lagos');
    }
    
    /**
     * This function used to load the first screen of the djs
     */
    public function index()
    {
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'CodeInsect : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * This function is used to load the djs list
     */
    function djsListing()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->djs_model->djsListingCount($searchText);

			$returns = $this->paginationCompress ( "djsListing/", $count, 5 );
            
            $data['djsRecords'] = $this->djs_model->djsListing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'CodeInsect : djs Listing';
            
            $this->loadViews("dj/list", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to add new djs to the system
     */
    function addNewDJs()
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
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->djsListing();
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('name')));
                $email = $this->input->post('email');
                $mobile = $this->input->post('mobile');
                $description = $this->input->post('description');
                
                $djsInfo = array('name'=> $name, 'email'=>$email, 'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'updatedBy'=>$this->vendorId, 'created_date'=>date('Y-m-d H:i:s'), 'updated_date'=>date('Y-m-d H:i:s'));

                $uploaddir = 'assets/dj-avatars/';
                $path = $_FILES['avatar']['name'];

                if ($_FILES['avatar']['name']) {
                    $ext = pathinfo($path, 4);
                    $dest_filename = md5(uniqid(rand(), true)) . '.' . $ext;
                    $uploadfile = $uploaddir . $dest_filename;
                    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadfile)) {
                        $djsInfo['avatar_url'] = $uploadfile;
                    }
                }

                $coversdir = 'assets/dj-covers/';
                $path = $_FILES['cover']['name'];

                if ($_FILES['cover']['name']) {
                    $ext = pathinfo($path, 4);
                    $cover_filename = md5(uniqid(rand(), true)) . '.' . $ext;
                    $coverfile = $coversdir . $cover_filename;
                    if (move_uploaded_file($_FILES['cover']['tmp_name'], $coverfile)) {
                        $djsInfo['profile_cover'] = $coverfile;
                    }
                }

                $result = $this->djs_model->addNewDJs($djsInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New djs created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'djs creation failed');
                }
                
                redirect('index.php/djsListing');
            }
        }
    }

    /**
     * This function is used to edit the djs information
     */
    function editDJs()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $djsId = $this->input->post('djId');
            
            $this->form_validation->set_rules('name','Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[32]');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                redirect('index.php/djsListing');
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('name')));
                $email = $this->input->post('email');
                $mobile = $this->input->post('mobile');
                $description = $this->input->post('description');

                $djsInfo = array('name'=>ucwords($name), 'email'=>$email, 'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updated_date'=>date('Y-m-d H:i:s'));

                $uploaddir = 'assets/dj-avatars/';
                $path = $_FILES['avatar']['name'];

                if ($_FILES['avatar']['name']) {
                    $ext = pathinfo($path, 4);
                    $dest_filename = md5(uniqid(rand(), true)) . '.' . $ext;
                    $uploadfile = $uploaddir . $dest_filename;
                    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadfile)) {
                        $djsInfo['avatar_url'] = $uploadfile;
                    }
                }

                $coversdir = 'assets/dj-covers/';
                $path = $_FILES['cover']['name'];

                if ($_FILES['cover']['name']) {
                    $ext = pathinfo($path, 4);
                    $cover_filename = md5(uniqid(rand(), true)) . '.' . $ext;
                    $coverfile = $coversdir . $cover_filename;
                    if (move_uploaded_file($_FILES['cover']['tmp_name'], $coverfile)) {
                        $djsInfo['profile_cover'] = $coverfile;
                    }
                }

                $result = $this->djs_model->editDJs($djsInfo, $djsId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'djs updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'djs updation failed');
                }

                redirect('index.php/djsListing');
            }
        }
    }
    /**
     * This function is used to get the user information
     */
    function getProfile()
    {
        $this->load->model('customer_model');
        $email = $this->input->post('email');
      
        if($email){
            $result = $this->customer_model->getUserInfo1($email);
        }else {
            echo json_encode(array('status' => "failed", 'msg' => "Your email doesn't exist."));
            exit(1);
        }

        if (!$result) {
            echo json_encode(array('status' => "failed", 'msg' => "This user doesn't exist."));
            exit(1);
        }
        
        if($result)
        {
            echo json_encode(array('status' => "success", 'msg' => "You commented this music successfully.", 'data' => $result));
        }
        else
        {
            echo json_encode(array('status' => "error", 'msg' => "You can't get the user information. Try again!"));
        }
    }
    /**
     * This function is used to set the user information
     */
    function setProfile()
    {
	header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }

        $this->load->model('customer_model');

        $name = ucwords(strtolower($this->input->post('username')));
        $email = $this->input->post('email');
        $isDjs = $this->input->post('isDjs');
        $base64_image_tmp = $this->input->post('base64string');

        $base64_image = explode(',', $base64_image_tmp);
	
        $djsInfo = array('username'=>ucwords($name), 'isDjs'=>$isDjs, 'updated_at'=>date('Y-m-d H:i:s'));

        $uploaddir = 'assets/profile-avatars/';
        $dest_filename = md5(uniqid(rand(), true)) . '.jpg';
        $djsInfo['profile_avatar'] = $uploaddir.$dest_filename;
	if(strlen($base64_image)) {
      	  $binary = base64_decode($base64_image);
    	   header('Content-Type: bitmap; charset=utf-8');
       	  $file = fopen($uploaddir.$dest_filename, 'wb');
       	  fwrite($file, $binary);
      	  fclose($file);
	}else{
	  echo json_encode(array('status' => "failed", 'msg' => "Your avatar file doesn't exist."));
          exit(1);
	}
        if($email){
            $user = $this->customer_model->getUserInfo1($email);
        }else {
            echo json_encode(array('status' => "failed", 'msg' => "Your email doesn't exist."));
            exit(1);
        }

        if (!$user) {
            echo json_encode(array('status' => "failed", 'msg' => "This user doesn't exist."));
            exit(1);
        }

        $result = $this->customer_model->setProfile($djsInfo, $email); 
        
        if($result == true)
        {
	     $userinfo = $this->customer_model->getUserInfo1($email);
            echo json_encode(array('status' => "success", 'msg' => "user profile updated successfully", 'userInfo' => $userinfo));
        }
        else
        {
            echo json_encode(array('status' => "failed", 'msg' => "user profile updation failed"));
        } 
    }
    function deleteCustomer()
    {
        $this->load->model('customer_model');
        $email = $this->input->post('email');
        $userInfo = array('isDeleted'=>1, 'updated_at'=>date('Y-m-d H:i:s'));
        
        $result = $this->customer_model->deleteCustomerByEmail($email, $userInfo);

        if($result == true)
        {
            echo json_encode(array('status' => "success", 'msg' => "user deleted successfully"));
        }
        else
        {
            echo json_encode(array('status' => "failed", 'msg' => "user delete failed"));
        }
    }
    /**
     * This function is used to delete the djs using djsId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteDJs()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $djsId = $this->input->post('djId');
            $djsInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updated_date'=>date('Y-m-d H:i:s'));
            
            $result = $this->djs_model->deleteDJs($djsId, $djsInfo);

            if($result == true)
            {
                $this->session->set_flashdata('success', 'djs deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'djs delete failed');
            }

            redirect('index.php/djsListing');
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
    public function getDJsList() {
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $this->load->library('pagination');

        $count = $this->djs_model->djsListingCount($searchText);

        // store the result in array form
        $result_set = array();
        if ($count > 0) {

            $data['djsRecords'] = $this->djs_model->djsListing($searchText);

            $status = "success";
            $msg = "Success!";
        } else {
            $status = "failed";
            $msg = "djs not existing.";
        }

        echo json_encode(array('status' => $status, 'msg' => $msg, 'result' => $data));
    }
}

?>