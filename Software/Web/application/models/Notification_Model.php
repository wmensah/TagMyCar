<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Notification_Model
 *
 * @author Will
 */
class Notification_Model extends CI_Model implements \JsonSerializable {
    
    private $notificationId;
    private $notificationType;
    private $sentFromUserId;
    private $sentToUserId;
    private $sentDateUtc;
    private $receivedDateUtc;
    private $acknowledged;
    private $acknowledgedDateUtc;
    
    public function __construct(){
        $this->load->database();
        $this->load->model("notificationtype_model");
    }
    
    public function getNotificationId(){
        return $this->notificationId;
    }
    
    public function setNotificationId($value){
        $this->notificationId = $value;
    }
    
    public function getNotificationType(){
        return $this->notificationType;
    }
    
    public function setNotificationType($value){
        $this->notificationType = $value;
    }
    
    public function getSentFromUserId(){
        return $this->sentFromUserId;
    }
    
    public function setSentFromUserId($value){
        $this->sentFromUserId = $value;
    }
    
    public function getSentToUserId(){
        return $this->sentToUserId;
    }
    
    public function setSentToUserId($value){
        $this->sentToUserId = $value;
    }
    
    public function getSentDateUtc(){
        return $this->sentDateUtc;
    }
    
    public function setSentDateUtc($value){
        $this->sentDateUtc = $value;
    }
    
    public function getReceivedDateUtc(){
        return $this->receivedDateUtc;
    }
    
    public function setReceivedDateUtc($value){
        $this->receivedDateUtc = $value;
    }
    
    public function getAcknowledged(){
        return $this->acknowledged;
    }
    
    public function setAcknowledged($value){
        $this->acknowledged = $value;
    }
    
    public function gteAcknowledgedDateUtc(){
        return $this->acknowledgedDateUtc;
    }
    
    public function setAcknowledgedDateUtc($value){
        $this->acknowledgedDateUtc = $value;
    }
    
    public function acknowledge($ack){
        if ($ack < 0){
            return false; // invalid ack value
        }
        if ($this->hasBeenAcknowledged()){
            return false; //already acknowledged
        }
        
        $ackdate = date("Y-m-d H:i:s");
        $data = array(
            'acknowledged'=>$ack,
            'acknowledged_date_utc'=> $ackdate
        );
        
        if ($this->db->update('lu_notifications', $data, array('notification_id'=>$this->notificationId))){
            $this->acknowledged = $ack;
            $this->acknowledged_date_utc = $ackdate;
            return true;
        }
        return false;
    }
    
    public function hasBeenAcknowledged(){
        return ($this->acknowledged > 0);
    }
   
    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }

}
