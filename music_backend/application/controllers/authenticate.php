<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Login (LoginController)
 * Login class to control to authenticate user credentials and starts user's session.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */

class Authenticate extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_model');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {

    }

    function registerToken(){
        $token = $this->input->post('token');

        $this->load->model('devicetoken_model');

        if (!$this->devicetoken_model->is_registered($token)) {
            $this->devicetoken_model->addToken($token);
        }

//        echo json_encode(array('status' => "Success", 'msg' => "Token registered successfully"));
        echo json_encode(array('status' => "Success", 'msg' => $token));
    }

    /**
    * This function used to register new user
     */
    function register() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username','Full Name','trim|required|max_length[128]|xss_clean');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
         // $this->form_validation->set_rules('isDjs','isDjs','required');
        if($this->form_validation->run() == FALSE)
        {
            echo json_encode(array('status' => "failed", 'msg' => "Validation failed."));die;
        }
        else {
            $name = ucwords(strtolower($this->input->post('username')));
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            // $isDjs = $this->input->post('isDjs'); // 1->for DJS 2-> Normal not Djs  
            /* Check if the same email is already registered */
            $checkSameEmail = $this->customer_model->checkEmailExists($email);
            /* Register new user */
            if (!$checkSameEmail) {
                
                // $dj =2;
                // if($isDjs != "")
                // {
                //     $dj = $isDjs;
                // }
                
                $userInfo = array('username' => $name, 'email' => $email, 'password' => getHashedPassword($password),/*'isDjs'=>$dj,*/ 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'));

               $insert_id = $this->customer_model->register($userInfo);

                echo json_encode(array('status' => "Success", 'msg' => "User registered successfully."));die;
            } else {
                echo json_encode(array('status' => "failed", 'msg' => "Same email was already registered."));die;
            }
        }

        exit(1);
    }

    /**
     * This function used to logged in user
     */
    public function login()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|xss_clean|trim');
        // $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]|');

        if($this->form_validation->run() == FALSE)
        {
            echo json_encode(array('status' => "failed", 'msg' => "Validation failed."));
        }
        else
        {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $FCM = $this->input->post('token');
 
            $result = $this->customer_model->login($email, $password);

            if ($result) {
                if($FCM != ''){
                    $check = $this->db->get_where('tbl_device_tokens',array("id"=>$result->id))->row_array();
                    if(!empty($check))
                    {
                        $this->db->update('tbl_device_tokens',array('token'=>$FCM),array('id'=>$result->id));
                    }
                    else{
                        $this->db->insert('tbl_device_tokens',array('id'=>$result->id,'token'=>$FCM));
                    }
                
                }
                
                echo json_encode(array('status' => "success", 'msg' => "Login Success", 'userInfo' => $result));
            } else {
                if($FCM != '' && $email != '') {
                    $name = ucwords(strtolower(explode('@', $email)[0]));
                    $checkSameEmail = $this->customer_model->checkEmailExists($email);
                    /* Register new user */
                    if (!$checkSameEmail) {
                        $userInfo = array('username' => $name, 'email' => $email, /*'isDjs'=>$dj,*/ 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'));

                       $insert_id = $this->customer_model->register($userInfo);

                       $this->db->insert('tbl_device_tokens',array('id'=>$insert_id,'token'=>$FCM));

                       $result = $this->customer_model->getExitUser($email, $FCM);

                        echo json_encode(array('status' => "success", 'msg' => "Login Success", 'userInfo' => $result));
                    } else {
                        $result = $this->customer_model->getExitUser($email, $FCM);
                        echo json_encode(array('status' => "success", 'msg' => "Login Success", 'userInfo' => $result));
                    }
                }else{
                    echo json_encode(array('status' => "failed", 'msg' => "Email or password mismatch"));
                }
                
            }
        }

        exit(1);
    }

    /**
     * This function used to generate reset password request link
     */
    // function resetPassword()
    // {
    //     $this->load->library('form_validation');

    //     $this->form_validation->set_rules('registered_email','Email','trim|required|valid_email|xss_clean');
    //     $this->form_validation->set_rules('password','Password','required|max_length[20]');

    //     if($this->form_validation->run() == FALSE)
    //     {
    //         echo json_encode(array('status' => "failed", 'msg' => "Validation failed."));
    //     }
    //     else
    //     {
    //         $email = $this->input->post('registered_email');
    //         $password = $this->input->post('password');

    //         $user = $this->customer_model->checkEmailExists($email);

    //         if($user && count($user) > 0) {
    //             $save = $this->customer_model->changePassword($email, getHashedPassword($password));
    //             echo json_encode(array('status' => "success", 'msg' => "Password was updated successfully."));
    //         }
    //         else
    //         {
    //             echo json_encode(array('status' => "failed", 'msg' => "Email doesn't exist."));
    //         }
    //     }

    //     exit(1);
    // }
}

?>