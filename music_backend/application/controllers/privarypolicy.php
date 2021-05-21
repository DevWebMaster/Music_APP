<?php
/**
 * Created by PhpStorm.
 * User: starengineer
 * Date: 3/19/2019
 * Time: 12:37 AM
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');
//require APPPATH . '/libraries/BaseController.php';

class Privarypolicy extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

//        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
//        ('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
//        $this->output->set_header('Pragma: no-cache');
//        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    public function index() {
        $this->loadViews("privacy");
    }
}