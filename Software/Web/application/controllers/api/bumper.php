<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Bumper extends REST_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->library("UserFactory");
        $this->load->library("NotificationFactory");
        $this->load->library("NotificationTypeFactory");
        
        // Configure limits on our controller methods. Ensure
        // you have created the 'limits' table and enabled 'limits'
        // within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; //500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key
    
    }
  
    // gets information for a user
    public function user_get($id){
        // responds with information about a user
        $user = $this->userfactory->getUser($id);
        $this->response($user, 200); // 200 being the HTTP response code
    }

    // creates a user
    public function user_post($tag, $state, $mobile_device_id){
        // creates a user or updates information about an existing user
        $user = $this->userfactory->addUser($tag, $state, $mobile_device_id);
        if ($user){
            // User was successfully added
            $this->response($user, 200);
        }else{
            // Failed to add user
            $this->response(NULL, 400);
        }
    }
    
    // terminates a user
    public function user_delete($id){
        // deletes an existing user
        // check user exists and is active
        $user = $this->userfactory->getUser($id);
        if (!$user || $user.isTerminated()){
            $this->response("User ID " . $id . " not found", 400);
        }
        $retval =$this->userfactory->terminateUser($id);
        if ($retval){
            $this->response(true, 200);
        }
        else{
            $this->response(NULL, 404);
        }
    }
    
    // gets notifications for a user
    public function notification_get($userId){
        
        // validate user ID
        if (!$this->userfactory->getUser($userId)){
            $this->response("User ID " . $userId . " not found", 400); // bad request
        }
        
        // get notification sent to a user
        $notifications = $this->notificationfactory->getNotificationsForUser($userId);
        $this->response($notifications, 200);
    }
    
    // sends a notification
    public function notification_post($toUserId, $fromUserId, $notificationTypeId){
        
        // validate TO user
        if (!$this->userfactory->getUser($toUserId)){
            $this->response("User ID " . $toUserId . " not found", 400); // bad request
        }
        
        // validate FROM user
        if (!$this->userfactory->getUser($fromUserId)){
            $this->response("User ID " . $fromUserId . " not found", 400); // bad request
        }
        
        // validate notificaton type ID
        if (!$this->notificationtypefactory->getNotificationTypeById($notificationTypeId)){
            $this->response("Notification Type " . $notificationTypeId . " not found", 400); // bad request
        }
        
        // sends notification to a user
        if ($this->notificationfactory->sendNotificationToUser($toUserId, $fromUserId, $notificationTypeId)){
            $this->response(true, 200);
        }else{
            $this->repsonse(false, 500);
        }
    }
    
    public function acknowledge_post($notificationId, $ack){
        // validate notification Id
        $notif = $this->notificationfactory->getNotificationById($notificationId);
        if (!$notif){
            $this->response("Notification ID " . $notificationId . " not found", 404);
        }
        
        if ($notif->hasBeenAcknowledged()){
            $this->response("Notification ID " . $notificationId . " has already been acknowledged", 400);
        }
  
        if ($ack < 0 || $ack > 2){
            $this->response("Invalid ack (must be a value of 1 or 2)", 400);
        }
        
        // acknowledge
        if ($this->notificationfactory->acknowledgeNotification($notificationId, $ack)){
            $this->response(true, 200);
        }else{
            $this->response(false, 500);
        }
    }
   
}