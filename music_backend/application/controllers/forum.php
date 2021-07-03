<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : forum (forumController)
 * forum Class to control all forum related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Forum extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('forum_model');
        date_default_timezone_set('Africa/Lagos');
    }
    
    /**
     * This function used to load the first screen of the forum
     */
    public function index()
    {
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'CodeInsect : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * This function is used to load the forum list
     */
    function forumListing()
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
            
            $count = $this->forum_model->forumListingCount($searchText);

			$returns = $this->paginationCompress ( "forumListing/", $count, 5 );
            
            $data['forumRecords'] = $this->forum_model->forumListing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'CodeInsect : forum Listing';
            
            $this->loadViews("forum/list", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to add new forum to the system
     */
    function addNewForum()
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
                $this->forumListing();
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('name')));
                $contents = ucwords(strtolower($this->input->post('contents')));
                
                $forumInfo = array('name'=> $name, 'contents'=>$contents, 'createdBy'=>$this->vendorId, 'updatedBy'=>$this->vendorId, 'created_date'=>date('Y-m-d H:i:s'), 'updated_date'=>date('Y-m-d H:i:s'));


                $result = $this->forum_model->addNewForum($forumInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New forum created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'forum creation failed');
                }
                
                redirect('index.php/forumListing');
            }
        }
    }

    /**
     * This function is used to edit the forum information
     */
    function editForum()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $forumId = $this->input->post('forumId');
            
            $this->form_validation->set_rules('name','Name','trim|required|max_length[128]|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                redirect('index.php/forumListing');
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('name')));
                $contents = ucwords(strtolower($this->input->post('contents')));

                $forumInfo = array('name'=>ucwords($name), 'contents'=>$contents, 'updatedBy'=>$this->vendorId, 'updated_date'=>date('Y-m-d H:i:s'));

                $result = $this->forum_model->editforum($forumInfo, $forumId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'forum updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'forum updation failed');
                }
                
                redirect('index.php/forumListing');
            }
        }
    }

    /**
     * This function is used to delete the forum using forumId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteForum()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $forumId = $this->input->post('forumId');
            $forumInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updated_date'=>date('Y-m-d H:i:s'));
            
            $result = $this->forum_model->deleteforum($forumId, $forumInfo);

            if($result == true)
            {
                $this->session->set_flashdata('success', 'forum deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'forum delete failed');
            }

            redirect('index.php/forumListing');
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
    public function getForumList() {
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $this->load->library('pagination');

        $count = $this->forum_model->forumListingCount($searchText);

        // store the result in array form
        $result_set = array();
        if ($count > 0) {

            $data['forumRecords'] = $this->forum_model->forumListing($searchText);

            $status = "success";
            $msg = "Success!";
        } else {
            $status = "failed";
            $msg = "Forum not existing.";
        }

        echo json_encode(array('status' => $status, 'msg' => $msg, 'result' => $data));
    }

}

?>