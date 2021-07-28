<?php

/**
 * upravuje promene a nastavuje databazi pro lokalni pouziti
 * 
 * @author Petr
 */
class Location {
    
    private $folder = "VoIP_access/"; // zmenit dle potreby
    private $null_folder = "";
    private $local = false;


    public function __construct() {
        if($_SERVER['SERVER_NAME'] === "localhost"){
            $this->local = true;
        }
    }
    
    public function setDb() {
        if($this->local){
            Db::connect('127.0.0.1', 'voip_access', 'root', '');
        }
        else { Db::connect('', '', '', ''); }
    }
        
    public function getFolder() {
        if($this->local){
            return $this->folder;
        }
        else { return $this->null_folder; }
    }
    
    public function getLocal() {
        return $this->local;
    }
    
}
