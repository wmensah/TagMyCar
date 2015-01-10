<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotificationType_Model
 *
 * @author Will
 */
class NotificationType_Model extends CI_Model implements \JsonSerializable{
    
    private $id;
    private $name;
    private $description;
    
    public function getId(){
        return $this->id;
    }
    
    public function setId($value){
        $this->id = $value;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function setName($value){
        $this->name = $value;
    }
    
    public function getDescription(){
        return $this->description;
    }
    
    public function setDescription($value){
        $this->description = $value;
    }
    
    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }

}
