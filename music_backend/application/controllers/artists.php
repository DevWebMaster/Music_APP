<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : artists (artistsController)
 * artists Class to control all artists related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Artists extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('artists_model');
        date_default_timezone_set('Africa/Lagos');
    }
    
    /**
     * This function used to load the first screen of the artists
     */
    public function index()
    {
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'CodeInsect : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * This function is used to load the artists list
     */
    function artistsListing()
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
            
            $count = $this->artists_model->artistsListingCount($searchText);

			$returns = $this->paginationCompress ( "artistsListing/", $count, 5 );
            
            $data['artistsRecords'] = $this->artists_model->artistsListing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'CodeInsect : Artists Listing';
            
            $this->loadViews("artist/list", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to add new artists to the system
     */
    function addNewArtists()
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
                $this->artistsListing();
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('name')));
                $email = $this->input->post('email');
                $mobile = $this->input->post('mobile');
                
                $artistsInfo = array('name'=> $name, 'email'=>$email, 'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'updatedBy'=>$this->vendorId, 'created_date'=>date('Y-m-d H:i:s'), 'updated_date'=>date('Y-m-d H:i:s'));
                
                $result = $this->artists_model->addNewArtists($artistsInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New artists created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'artists creation failed');
                }
                
                redirect('index.php/artistsListing');
            }
        }
    }

    /**
     * This function is used to edit the artists information
     */
    function editArtists()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $artistsId = $this->input->post('artistId');
            
            $this->form_validation->set_rules('name','Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[32]');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                redirect('index.php/artistsListing');
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('name')));
                $email = $this->input->post('email');
                $mobile = $this->input->post('mobile');

                $artistsInfo = array('name'=>ucwords($name), 'email'=>$email, 'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updated_date'=>date('Y-m-d H:i:s'));
                
                $result = $this->artists_model->editArtists($artistsInfo, $artistsId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'artists updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'artists updation failed');
                }

                redirect('index.php/artistsListing');
            }
        }
    }

    /**
     * This function is used to delete the artists using artistsId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteArtists()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $artistsId = $this->input->post('artistId');
            $artistsInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updated_date'=>date('Y-m-d H:i:s'));
            
            $result = $this->artists_model->deleteArtists($artistsId, $artistsInfo);

            if($result == true)
            {
                $this->session->set_flashdata('success', 'artists deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'artists delete failed');
            }

            redirect('index.php/artistsListing');
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
    public function getArtistsList() {
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $this->load->library('pagination');

        $count = $this->artists_model->artistsListingCount($searchText);

        // store the result in array form
        $result_set = array();
        if (count($count) > 0) {

            $data['artistsRecords'] = $this->artists_model->artistsListing($searchText);

            $status = "success";
            $msg = "Success!";
        } else {
            $status = "failed";
            $msg = "artists not existing.";
        }

        echo json_encode(array('status' => $status, 'msg' => $msg, 'result' => $data));
    }
}

?>