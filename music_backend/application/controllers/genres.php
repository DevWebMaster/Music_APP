<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : genres (genresController)
 * genres Class to control all genres related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Genres extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('genres_model');
        date_default_timezone_set('Africa/Lagos');
    }
    
    /**
     * This function used to load the first screen of the genres
     */
    public function index()
    {
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'CodeInsect : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * This function is used to load the genres list
     */
    function genresListing()
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
            
            $count = $this->genres_model->genresListingCount($searchText);

			$returns = $this->paginationCompress ( "genresListing/", $count, 5 );
            
            $data['genresRecords'] = $this->genres_model->genresListing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'CodeInsect : genres Listing';
            
            $this->loadViews("genres/list", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to add new genres to the system
     */
    function addNewGenres()
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
                $this->genresListing();
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('name')));
                
                $genresInfo = array('name'=> $name, 'createdBy'=>$this->vendorId, 'updatedBy'=>$this->vendorId, 'created_date'=>date('Y-m-d H:i:s'), 'updated_date'=>date('Y-m-d H:i:s'));

                $uploaddir = 'assets/thumbimages/genres/';
                $path = $_FILES['thumbimg']['name'];

                if ($_FILES['thumbimg']['name']) {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $dest_filename = md5(uniqid(rand(), true)) . '.' . $ext;
                    $uploadfile = $uploaddir . $dest_filename;
                    if (move_uploaded_file($_FILES['thumbimg']['tmp_name'], $uploadfile)) {
                        $genresInfo['thumb_img'] = $uploadfile;
                    }
                }

                $result = $this->genres_model->addNewGenres($genresInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New genres created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'genres creation failed');
                }
                
                redirect('index.php/genresListing');
            }
        }
    }

    /**
     * This function is used to edit the genres information
     */
    function editGenres()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $genresId = $this->input->post('genresId');
            
            $this->form_validation->set_rules('name','Name','trim|required|max_length[128]|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                redirect('index.php/genresListing');
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('name')));

                $genresInfo = array('name'=>ucwords($name), 'updatedBy'=>$this->vendorId, 'updated_date'=>date('Y-m-d H:i:s'));

                $uploaddir = 'assets/thumbimages/genres/';
                $path = $_FILES['thumbimg']['name'];

                if ($_FILES['thumbimg']['name']) {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $dest_filename = md5(uniqid(rand(), true)) . '.' . $ext;
                    $uploadfile = $uploaddir . $dest_filename;
                    if (move_uploaded_file($_FILES['thumbimg']['tmp_name'], $uploadfile)) {
                        $genresInfo['thumb_img'] = $uploadfile;
                    }
                }

                $result = $this->genres_model->editGenres($genresInfo, $genresId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'genres updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'genres updation failed');
                }
                
                redirect('index.php/genresListing');
            }
        }
    }

    /**
     * This function is used to delete the genres using genresId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteGenres()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $genresId = $this->input->post('genresId');
            $genresInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updated_date'=>date('Y-m-d H:i:s'));
            
            $result = $this->genres_model->deleteGenres($genresId, $genresInfo);

            if($result == true)
            {
                $this->session->set_flashdata('success', 'genres deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'genres delete failed');
            }

            redirect('index.php/genresListing');
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
    public function getGenresList() {
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $this->load->library('pagination');

        $count = $this->genres_model->genresListingCount($searchText);

        // store the result in array form
        $result_set = array();
        if ($count > 0) {

            $data['genresRecords'] = $this->genres_model->genresListing($searchText);

            $status = "success";
            $msg = "Success!";
        } else {
            $status = "failed";
            $msg = "Genres not existing.";
        }

        echo json_encode(array('status' => $status, 'msg' => $msg, 'result' => $data));
    }

}

?>