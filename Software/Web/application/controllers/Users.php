<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author Will
 */
class Users extends CI_Controller {
    public function index()
    {
        parent::__construct();
            echo "This is the index!";
    }

    public function show($userId = 0)
    {
            //Always ensure an integer
    $userId = (int)$userId;
    //Load the user factory
    $this->load->library("UserFactory");
    //Create a data array so we can pass information to the view
    $data = array(
        "users" => $this->userfactory->getUser($userId)
    );
    //Dump out the data array
    var_dump($data);
    }
}
