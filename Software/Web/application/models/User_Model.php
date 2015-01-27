<?php

date_default_timezone_set('UTC');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of users_model
 * Implements \JsonSerializable so the private properties can be serialized
 * http://stackoverflow.com/questions/7005860/php-json-encode-class-private-members
 * @author Will
 */
class User_Model extends CI_Model implements \JsonSerializable {
    
    private $id;
    private $tag;
    private $state;
    private $mobileDeviceId;
    private $joinDateUtc;
    private $termDateUtc;
    
    public function __construct(){
        $this->load->database();
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setId($value){
        $this->id = $value;
    }
    
    public function getTag(){
        return $this->tag;
    }
    
    public function setTag($value){
        $this->tag = $value;
    }
    
    public function getState(){
        return $this->state;
    }
    
    public function setState($value){
        $this->state = $value;
    }
    
    public function getMobileDeviceId(){
        return $this->mobileDeviceId;
    }
    
    public function setMobileDeviceId($value){
        $this->mobileDeviceId = $value;
    }
    
    public function getJoinDateUtc(){
        return $this->joinDateUtc;
    }
    
    public function setJoinDateUtc($value){
        $this->joinDateUtc = $value;
    }
    
    public function getTermDateUtc(){
        return $this->termDateUtc;
    }
    
    public function setTermDateUtc($value){
        $this->termDateUtc = $value;
    }
    
    public function isTerminated(){
        if (empty($this->termDateUtc)){
            return false;
        }
        $time = strtotime($this->termDateUtc);
        $date = date( 'y-m-d', $time );
        return ($date < getdate());
    }
    
    public function commit(){
        $data = array(
            'tag' => $this->tag,
            'state' => $this->state,
            'mobile_device_id' => $this->mobileDeviceId,
            'join_date_utc' => $this->joinDateUtc,
            'term_date_utc' => $this->termDateUtc
        );

        if ($this->id > 0 and $this->db->update('user', $data, array('id'=>$this->id))) {
            return true;
        }
        if ($this->db->insert('user', $data)){
            $this->id = $this->db->insert_id();
            return true;
        }
        return false;
    }
    
    // Internally only. This should not be exposed via the API. 
    public function deleteUser(){
        // delete notifications
        $this->db->delete('lu_notifications', array('sent_to_user_id'=>$this->id));
        $this->db->delete('user', array('id'=>$this->id));
        return true;
    }

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }
}
