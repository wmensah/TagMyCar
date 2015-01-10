<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotificationFactory
 *
 * @author Will
 */
class NotificationFactory {
    
    private $_ci;

    function __construct() {
        //When the class is constructed get an instance of codeigniter so we can access it locally
        $this->_ci = & get_instance();
        //Include the user_model so we can use it
        $this->_ci->load->model("notification_model");
        $this->_ci->load->library("NotificationTypeFactory");
    }
    
    public function getNotificationById($notificationId){
        // retrieve a notification sent to a user by the notification ID
        $query = $this->_ci->db->get_where("lu_notifications", array("notification_id"=>$notificationId));
        if ($query->num_rows() > 0){
            return $this->createObjectFromData($query->row());
        }
        return false;
    }
    
    // returns an array of notifications sent to a user
    public function getNotificationsForUser($sentToUserId, $sentFromUserId=null){
        $conditions = array('sent_to_user_id'=>$sentToUserId);
        if ($sentFromUserId != null){
            $conditions = array('sent_to_user_id'=>$sentToUserId, 'sent_from_user_id'=>$sentFromUserId);
        }
        $query = $this->_ci->db->get_where("lu_notifications", $conditions);
        $notifications = array();
        if ($query->num_rows() > 0){            
            foreach($query->result() as $row){
                $notifications[] = $this->createObjectFromData($row);
            }
        }
        return $notifications;
    } 
    
    public function sendNotificationToUser($toUserId, $fromUserId, $notificationTypeId){
        $data = array(
            'sent_to_user_id' => $toUserId,
            'sent_from_user_id'=> $fromUserId,
            'notification_type_id' => $notificationTypeId,
            'sent_date_utc' => date("Y-m-d H:i:s")              
        );        
        if ($this->_ci->db->insert('lu_notifications', $data)){
            return true;
        }
        return false;        
    }
    
    public function acknowledgeNotification($notificationId, $ack){
        $notification = $this->getNotificationById($notificationId);
        if (!$notification){
            return false;
        }
        if ($notification->acknowledge($ack)){
            return true;
        }
        return false;
    }
    
    public function createObjectFromData($row) {
        //Create a new notification_model object
        $notif = new Notification_Model();
        $notif->setNotificationId($row->notification_id);
        $notiftype = $this->_ci->notificationtypefactory->getNotificationTypeById($row->notification_type_id);
        $notif->setNotificationType($notiftype);
        $notif->setSentFromUserId($row->sent_from_user_id);        
        $notif->setSentToUserId($row->sent_to_user_id);        
        $notif->setSentDateUtc($row->sent_date_utc);        
        $notif->setReceivedDateUtc($row->received_date_utc);        
        $notif->setAcknowledged($row->acknowledged);        
        $notif->setAcknowledgedDateUtc($row->acknowledged_date_utc);        
        return $notif;
    }
}
