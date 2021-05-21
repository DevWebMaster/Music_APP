<?php
/**
 * Created by PhpStorm.
 * User: CStar
 * Date: 1/20/2018
 * Time: 4:38 AM
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Images extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('images_model');
        $this->load->model('response_model');

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    public function listImages() {
        $this->isLoggedIn();

        $images = $this->images_model->getAllImages();
        $response = $this->response_model->getAllResponse();

        $this->global['images'] = $images;
        $this->global['pageTitle'] = 'Image List';
        $this->global['search']='';
        $this->global['response'] = $response;

        $this->loadViews("images/list", $this->global, NULL , NULL);
    }

    public function deleteImage() {
        $imageId = $this->input->post('image');

        $image = $this->images_model->getImage($imageId);

        if ($image[0]) {
            $result = $this->images_model->deleteImage($imageId);
            $after_id = $image[0]['id'];
            $after_index = $image[0]['index_num'];

            $update = array('index_num' => $after_index);
            $where = array('index_num' => $after_id);
            $update_result = $this->images_model->updateImage($update, $where);

            if ($update_result) {
                echo json_encode(array('status' => 'success', 'msg' => "Image $after_id was removed", 'image' => $imageId));
            }
        } else {
            echo json_encode(array('status' => 'failed', 'msg' => "failed"));
        }

    }

    public function saveImages() {

        for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
            $image = array('name' => $_FILES['file']['name'][$i], 'tmp_name' => $_FILES['file']['tmp_name'][$i]);
            $filename = $this->saveImage($image);

            if ($filename) {
                $index_num = $this->images_model->getMaxIndex();

                if (is_null($index_num)) {
                    $index_num = 0;
                }

                $link = '';
                if (isset($_POST['links']) && isset($_POST['links'][$i])) {
                    $link = $_POST['links'][$i];
                }

                $current_time = date('Y-m-d h:i:s');
            }
        }
    }

    public function saveImage() {
        $image = $_FILES['file'];

        $uploaddir = './assets/upload_images/';
        $path = $image['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $dest_filename = md5(uniqid(rand(), true)) . '.' . $ext;
        $uploadfile = $uploaddir .$dest_filename;
        $file_name = $dest_filename;
        if (move_uploaded_file($image['tmp_name'], $uploadfile)) {
            $index_num = $this->images_model->getMaxIndex();

            if (is_null($index_num)) {
                $index_num = 0;
            }

            $link = '';
            if (isset($_POST['links'])) {
                $link = $_POST['links'];
            }

            $current_time = date('Y-m-d h:i:s');

            $data = array(
                'user' => 0,
                'index_num' => $index_num,
                'path' => $file_name,
                'link' => $link,
                'created_at' => $current_time,
                'updated_at' => $current_time
            );

            $this->images_model->addNewImage($data);

        } else {

        }

        redirect('/index.php/images');
    }

    public function updateIndex() {
        $id = $this->input->post('id');
        $left_sibling = $this->input->post('left_sibling_id');
        $right_sibling = $this->input->post('right_sibling_id');

        if ($left_sibling == 'parent') {
            $left_sibling = 0;
        }

        $row = $this->images_model->getImage($id);

        $data = array('index_num' => $left_sibling);
        $where = array('id' => $id);
        $result = $this->images_model->updateImage($data, $where);

        if ($result) {

            $data_a = array('index_num' => $row[0]['index_num']);
            $where_a = array('index_num' => $row[0]['id']);
            $result_a = $this->images_model->updateImage($data_a, $where_a);

            $data_b = array('index_num' => $id);
            $where_b = array('id' => $right_sibling);
            $result_b = $this->images_model->updateImage($data_b, $where_b);

        }

        if ($result && $result_b) {
            echo true;
        } else {
            echo false;
        }
    }

    public function updateTitle() {
        $imageId = $this->input->post('link-id');
        $imageLink = $this->input->post('link-text');

        $data = array('link' => $imageLink);
        $where = array('id' => $imageId);
        $this->images_model->updateImage($data, $where);

        echo true;
    }

    /*
     * Backend API for image list
     */
    public function getImageList() {
        $list = $this->images_model->getAllImages();
        $response = $this->response_model->getAllResponse();

        // store the result in array form
        $result_set = array();
        if (count($list) > 0) {
            $i = 0;
            $rows = array();
            foreach ($list as $row) {
                $rows[$row['index_num']] = $row;
                $i++;
            }

            $j = 0;
            $next = 0;
            while ($j < count($rows)) {
                if ($j == 0) {
                    $result_set[] = $rows[$j];
                    $next = $rows[$j]['id'];
                    $j++;
                    continue;
                }

                $result_set[] = $rows[$next];
                $next = $rows[$next]['id'];
                $j++;
            }

            $status = "success";
            $msg = "Success!";
        } else {
            $status = "failed";
            $msg = "Images is not existing.";
        }

        echo json_encode(array('status' => $status, 'msg' => $msg, 'result' => $result_set, 'response_option' => $response));
    }
}