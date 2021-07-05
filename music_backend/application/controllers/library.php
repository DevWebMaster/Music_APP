<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : library (libraryController)
 * library Class to control all library related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Library extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('library_model');
        date_default_timezone_set('Africa/Lagos');
    }
    
    /**
     * This function used to load the first screen of the library
     */
    public function index()
    {
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'CodeInsect : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * This function is used to load the library list
     */
    function libraryListing()
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
            
            $count = $this->library_model->libraryListingCount($searchText);

            $returns = $this->paginationCompress ( "libraryListing/", $count, 5 );
            
            $data['libraryRecords'] = $this->library_model->libraryListing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'CodeInsect : library Listing';
            
            $this->loadViews("library/list", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to add new library to the system
     */
    function addNewLibrary()
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
            
            if($this->form_validation->run() == FALSE)
            {
                $this->libraryListing();
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('name')));
                
                $libraryInfo = array('name'=> $name, 'createdBy'=>$this->vendorId, 'updatedBy'=>$this->vendorId, 'created_date'=>date('Y-m-d H:i:s'), 'updated_date'=>date('Y-m-d H:i:s'));

                $uploaddir = 'assets/thumbimages/library/';
                $path = $_FILES['thumbimg']['name'];

                if ($_FILES['thumbimg']['name']) {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $dest_filename = md5(uniqid(rand(), true)) . '.' . $ext;
                    $uploadfile = $uploaddir . $dest_filename;
                    if (move_uploaded_file($_FILES['thumbimg']['tmp_name'], $uploadfile)) {
                        $libraryInfo['thumb_img'] = $uploadfile;
                    }
                }

                $result = $this->library_model->addNewLibrary($libraryInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New library created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'library creation failed');
                }
                
                redirect('index.php/libraryListing');
            }
        }
    }

    /**
     * This function is used to edit the library information
     */
    function editLibrary()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $libraryId = $this->input->post('libraryId');
            
            $this->form_validation->set_rules('name','Name','trim|required|max_length[128]|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                redirect('index.php/libraryListing');
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('name')));

                $libraryInfo = array('name'=>ucwords($name), 'updatedBy'=>$this->vendorId, 'updated_date'=>date('Y-m-d H:i:s'));

                $uploaddir = 'assets/thumbimages/library/';
                $path = $_FILES['thumbimg']['name'];

                if ($_FILES['thumbimg']['name']) {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $dest_filename = md5(uniqid(rand(), true)) . '.' . $ext;
                    $uploadfile = $uploaddir . $dest_filename;
                    if (move_uploaded_file($_FILES['thumbimg']['tmp_name'], $uploadfile)) {
                        $libraryInfo['thumb_img'] = $uploadfile;
                    }
                }

                $result = $this->library_model->editLibrary($libraryInfo, $libraryId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'library updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'library updation failed');
                }
                
                redirect('index.php/libraryListing');
            }
        }
    }

    /**
     * This function is used to delete the library using libraryId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteLibrary()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $libraryId = $this->input->post('libraryId');
            $libraryInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updated_date'=>date('Y-m-d H:i:s'));
            
            $result = $this->library_model->deleteLibrary($libraryId, $libraryInfo);

            if($result == true)
            {
                $this->session->set_flashdata('success', 'library deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'library delete failed');
            }

            redirect('index.php/libraryListing');
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
    public function getLibraryList() {
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $this->load->library('pagination');

        $count = $this->library_model->libraryListingCount($searchText);

        // store the result in array form
        $result_set = array();
        if ($count > 0) {

            $data['libraryRecords'] = $this->library_model->libraryListing($searchText);

            $status = "success";
            $msg = "Success!";
        } else {
            $status = "failed";
            $msg = "Library not existing.";
        }

        echo json_encode(array('status' => $status, 'msg' => $msg, 'result' => $data));
    }

}

?>