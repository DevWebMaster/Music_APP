<?php
/**
 * Created by PhpStorm.
 * User: CStar
 * Date: 2/11/2018
 * Time: 12:03 AM
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Response extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('response_model');

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    public function saveResponse() {
        $title = $_POST['response_title'];
        $message = $_POST['response_message'];
        $option = $_POST['response_option'];
        $link = $_POST['response_link'];

        $data = array('title' => $title, 'message' => $message, 'option' => $option, 'link' => $link);

        $data['response_type'] = $_POST['response_type'];

        if ($_POST['response_type'] == 'single') {
            $data['single_button_label'] = $_POST['single_button_label'];
        }

        if ($_POST['response_type'] == 'dual') {
            $data['yes_button_label'] = $_POST['yes_button_label'];
            $data['no_button_label'] = $_POST['no_button_label'];
            $data['dual_link'] = $_POST['dual_link'];
        }

        error_log(json_encode($data), 3, 'debug.log');

        if ($lastRow = $this->response_model->getLastRow()) {
            $id = $lastRow[0]['id'];
            $this->response_model->updateResponse($data, array('id' => $id));
        } else {
            $this->response_model->addNewResponse($data);
        }

        redirect('index.php/images');
    }
}