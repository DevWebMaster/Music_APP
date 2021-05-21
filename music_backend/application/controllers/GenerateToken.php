<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once(APPPATH.'libraries/agora_code/sample/RtcTokenBuilderSample.php');
require_once(APPPATH.'libraries/agora_code/src/RtcTokenBuilder.php');
use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Topic;
use sngrl\PhpFirebaseCloudMessaging\Notification;
class GenerateToken extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		 
		$this->load->library('email');
		// $this->load->model(['User_model','Common_model']);
	    $server_key = 'AIzaSyD4Tekho88a9WWDOKiFNeE7xNQC1_ffebU';
        $this->client = new Client();
        $this->client->setApiKey($server_key);
		$this->load->helper(array('form', 'url'));
		 
    }
      public $key_array = array('C','Db','D','Eb','E','F','Gb','G','Ab','A','Bb','B');
    public $player_kinds_array = array('drum','bass','piano','rhodes','organ','synth','guitar');
    
    
      public function notification_test($name,$channelName,$userId,$token,$TokenUserAccount) {
       $notification = new Notification('Notification from DJ Bitz', " \"$name\" has started a live video",$channelName,$userId,$token,$name,$TokenUserAccount);
        $notification->setBadge(1);
        $notification->setSound('default');

        $message = new Message();
        $message->setPriority('high');
        $message->setContentAvailable(true);
    
           
        
        
          $message->addRecipient(new Device("f1dZOcVDDJY:APA91bErbIggL__2XfzZuyC0uKNK0H1DqAs4KIEyTnUOfwC9zCWDtescCyuhrGikQWvLhPWeN9ttcg2E7Esz13EZTuf3TGrp6v7sRAkGA9H3ILmZK3_k87AYNV6H-QfX9PtLNrxqGQl_"));

        
        $message
            ->setNotification($notification)
            ->setData(['content_available' => 'true'])
        ;

        $response = $this->client->send($message);die;
    }
 

   
    function generate_token()
    {
        $channel = trim($this->input->get_post('channelName', TRUE));
        $userId = trim($this->input->get_post('userId', TRUE));
        $name = trim($this->input->get_post('userName', TRUE));
       
		if($userId != ''){

            // $appID = "ec8add591c804b6b85f3be78fbfe0611";
            // $appCertificate = "7400065c3c6149628d51240f44b9b178";
            
            $appID = "c7225aa4f2a84d4d9ecd6ed1eacca045";
            $appCertificate = "1b74137e4c68456bbe05b7b3c67fdf25";
            if($channel != '')
            {
                  $channelName = $channel;
                  $role = RtcTokenBuilder::RoleSubscriber;
            }
            else
            {
                 $channelName = md5(rand('1','99').$userId);
                 $role = RtcTokenBuilder::RolePublisher;
            }
            $uid = $userId;
            $uidStr = '"$userId"';
            $expireTimeInSeconds = 600;
            $currentTimestamp = (new DateTime("now"))->getTimestamp();
             
            $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
            $privilegeExpiredTs=  date('l, d-M-Y H:i:s',$privilegeExpiredTs);
            // $privilegeExpiredTs = 0;

            $token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
            $TokenUid =  $token ;

            $token = RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $uidStr, $role, $privilegeExpiredTs);
            $TokenUserAccount = $token;
                if($channel == '')
                {
                    //   $this->test($name,$channelName,$userId,$TokenUid,$TokenUserAccount); die;
                      
                      $this->sendNotification($name,$channelName,$userId,$TokenUid,$TokenUserAccount);
                               $checkDjsUser = $this->db->get_where('tbl_customers',array('id'=>$userId,'isDjs'=>1))->row_array();
                        if(!empty($checkDjsUser))
                        {
                            $this->db->update('tbl_customers',array('isLive'=>1,'live_token'=>$TokenUid,"channelName"=>$channelName),array('id'=>$userId));
                        }
                }

              
                $returnData = array("userId"=>$uid,"channelName"=>$channelName,"TokenWithUid"=>$TokenUid,"TokenWithUserAccount"=>$TokenUserAccount,"APPID"=>$appID,"userName"=>$name);
            
           
              
              
              


        echo json_encode(array('status' => 1, 'responseMessage' => 'Generated Token', "AllData"=>$returnData));die;

            }
            else {
                echo json_encode(array('status' => 0, 'responseMessage' => 'User Id can not be null.'));die;
            }
    }
    
    
    function updateLiveStatus()
    {
    
        $userId = trim($this->input->get_post('userId', TRUE));
        $liveStatus = trim($this->input->get_post('liveStatus', TRUE));
        // Live Status : 0->not Live 1-> Live
        if($liveStatus != '')
        {
            $update = $this->db->update('tbl_customers',array('isLive'=>0,'live_token'=>'',"channelName"=>""),array('id'=>$userId));
            if($update)
            {
                echo json_encode(array('status' => 1, 'responseMessage' => 'Live Status Updated.'));die;
            }
            else{
                echo json_encode(array('status' => 0, 'responseMessage' => 'Somthing Went Wrong.'));die;
            }
        }
        else{
            echo json_encode(array('status' => 0, 'responseMessage' => 'Can Not Be Null Status.'));die;
        }
    }
    
    
    function getAllLiveCustomers()
    {
          $userId = trim($this->input->get_post('userId', TRUE));
        $getData = $this->db->get_where('tbl_customers',array('isLive'=>1,'isDjs'=>1,"id !="=>$userId))->result_array();
        if($getData){
            echo json_encode(array('status' => 1, 'responseMessage' => 'All Customers','customersList'=>$getData));die;
        }
        else{
            echo json_encode(array('status' => 0, 'responseMessage' => 'No users are streaming live Now'));die;
        }

    }
    


    public function sendNotification($name,$channelName,$userId,$token,$TokenUserAccount) {
             $get_all_token = $this->db->limit(1000)->order_by('id','DESC')->get_where('userFCMToken',array('userId != '=>$userId))->result_array();
         
        $notification = new Notification('Notification from DJ Bitz', " \"$name\" has started a live video",$channelName,$userId,$token,$name,$TokenUserAccount);
        $notification->setBadge(1);
        $notification->setSound('default');

        $message = new Message();
        $message->setPriority('high');
        $message->setContentAvailable(true);
    
           
        
        foreach ($get_all_token as $key => $value) {
          $message->addRecipient(new Device($value['Token']));

        }
        $message
            ->setNotification($notification)
            ->setData(['content_available' => 'true'])
        ;

        $response = $this->client->send($message);
       
    }

    // public function send($token,$msg)
    // {
    //     // echo $tokens;die;
        
    //       $api_key = "AAAAK86rRLs:APA91bHkzoLv0Fs4NgGPWIVAlNwjYOq2_tBjOeJv8AkoYYXFqe-dYMrL1awUp1_Bz83fNKm21SE-w6NvJyrauijMOa7uG6GoGPGjbmi4vYE9axNP7xUP7jNdb_uOysHR0hpN_on1gj6u";
    //       $fcmUrl= "https://fcm.googleapis.com/fcm/send";
            
           
                
    //     //   print_r($value);
        
    //     if (!empty($token)) {

    //         $notificationData = [
    //             'title'  => $msg['title'],
    //             'body'   => $msg['body'],
    //             'userId'=> $msg['userId'],
    //             'channelName' => $msg['channelName'],
    //             'sound' => 'mySound'
    //         ];

    //         $fcmNotification = [

    //             'to'          => $token, //single token
    //             'collapseKey' => "{$token}",
    //             'data'        => $notificationData,

    //         ];
    //         $headers = [
    //             'Authorization: key=' . $api_key,
    //             'Content-Type: application/json',
    //         ];

    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_URL, $fcmUrl);
    //         curl_setopt($ch, CURLOPT_POST, true);
    //         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
    //         $result = curl_exec($ch);
            
    //         //  print_r($result);die;
    //         if ($result === FALSE) {
    //         die('FCM Send Error: ' . curl_error($ch));
    //         // print_r($result);die;
    //             }
    //         curl_close($ch);
    //         return $result;
            
    //     }
        
          
            
            
    // }
	
    

}


?>