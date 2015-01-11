<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserFactory
 *
 * @author Will
 */
class UserFactory {

    private $_ci;

    function __construct() {
        //When the class is constructed get an instance of codeigniter so we can access it locally
        $this->_ci = & get_instance();
        //Include the user_model so we can use it
        $this->_ci->load->model("user_model");
    }

    public function getUser($id = 0, $tag = null, $state = null, $mobile_device_id = null) {
        //Are we getting an individual user or are we getting them all
        $condition = null;
        if ($id > 0) {
            $condition = array("id" => $id);
        } else if ($tag != null && $state != null) {
            $condition = array("tag" => $tag, "state" => $state);
        } else if ($tag != null) {
            $condition = array("tag" => $tag);
        } else if ($state != null) {
            $condition = array("state" => $state);
        } else if ($mobile_device_id != null) {
            $condition = array("mobile_device_id" => $mobile_device_id);
        }
        if ($condition != null) {
            //Getting an individual user (non-termed)
            $condition += array("term_date_utc"=> NULL);
            $query = $this->_ci->db->get_where("user", $condition);
            //Check if any results were returned
            if ($query->num_rows() > 0) {
                //Pass the data to our local function to create an object for us and return this new object
                return $this->createObjectFromData($query->row());
            }
            return false;
        } else {
            //Getting all the users
            $query = $this->_ci->db->select("*")->from("user")->get();
            //Check if any results were returned
            if ($query->num_rows() > 0) {
                //Create an array to store users
                $users = array();
                //Loop through each row returned from the query
                foreach ($query->result() as $row) {
                    //Pass the row data to our local function which creates a new user object with the data provided and add it to the users array
                    $users[] = $this->createObjectFromData($row);
                }
                //Return the users array
                return $users;
            }
            return false;
        }
    }

    public function addUser($tag, $state, $mobile_device_id) {
        // Check to see if the user already exists
        $user = $this->getUser(0, $tag, $state);
        if ($user == false) {
            // add user
            $user = new User_Model();
            $user->setJoinDateUtc(date("Y-m-d H:i:s"));
        }else{
            // if no data has changed, just return
            if ($user->getTag() == $tag &&
                $user->getState() == $state &&
                $user->getMobileDeviceId() == $mobile_device_id){
                return $user;
            }
        }
        $user->setTag($tag);
        $user->setState($state);
        $user->setMobileDeviceId($mobile_device_id);
        if ($user->commit()) {
            return $user;
        } else {
            return false;
        }
    }

    public function terminateUser($id) {
        $user = $this->getUser($id);
        if ($user) {
            if (!$user->isTerminated()) {
                return true;
            }
            $user->setTermDateUtc(date("Y-m-d H:i:s"));
            if ($user->commit()) {
                return true;
            }
        }
        return false;
    }

    public function createObjectFromData($row) {
        //Create a new user_model object
        $user = new User_Model();
        //Set the ID on the user model
        $user->setId($row->id);
        //Set the username on the user model
        $user->setTag($row->tag);
        //Set the password on the user model
        $user->setState($row->state);
        //Se the mobile device id on the user model
        $user->setMobileDeviceId($row->mobile_device_id);
        //Set the join date on the user model
        $user->setJoinDateUtc($row->join_date_utc);
        //Set the term date on the user model
        $user->setTermDateUtc($row->term_date_utc);
        //Return the new user object
        return $user;
    }

}
