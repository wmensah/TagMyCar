<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotificationTypeFactory
 *
 * @author Will
 */
class NotificationTypeFactory {
    private $_ci;

    function __construct() {
        //When the class is constructed get an instance of codeigniter so we can access it locally
        $this->_ci = & get_instance();
        //Include the notificationtype_model so we can use it
        $this->_ci->load->model("notificationtype_model");
    }
    
    public function getNotificationTypeById($id){
        $query = $this->_ci->db->get_where("lu_notification_type", array('notification_type_id'=>$id));
        if ($query->num_rows() > 0){
            return $this->createObjectFromData($query->row());
        }
        return false;
    }
    
    public function createObjectFromData($row) {
        $notifType = new NotificationType_Model();
        $notifType->setId($row->notification_type_id);
        $notifType->setName($row->name);
        $notifType->setDescription($row->description);
        return $notifType;
    }
}
