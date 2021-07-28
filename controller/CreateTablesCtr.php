<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateDB
 *
 * @author Petr
 */
class CreateTablesCtr extends Ctr{
    
    public function process($data) {
        
        //$this->createLocationTable();
        //$this->createDeviceTable();
        //$this->createAccessTable();
        //$this->createContactPersonTable();
        $this->createExportTable();
        //$table[] = "Tables is created.";
        
        $data['nazev'] = "Table Creator";
        $data['popisek'] = "nic";
        //$data['table'] = "Tables is created.";
        $view = new CreateWs();
        // výpis formuláře
        $view->show($data);
    }
    
    protected function existsTable() {
        return $test = Db::query('SHOW TABLES LIKE users');
        //var_dump($test);
    }
    
    public function createLocationTable() {
        return Db::query('CREATE TABLE IF NOT EXISTS location(
                id_location int(11) AUTO_INCREMENT,
                name varchar(255),
                company varchar(255),
                address varchar(255),
                PRIMARY KEY (id_location)) 
                CHARACTER SET utf8 
                COLLATE utf8_czech_ci');
    }
    
    public function createDeviceTable() {
        return Db::query('CREATE TABLE IF NOT EXISTS device(
                id_device int(11) AUTO_INCREMENT,
                id_location int(11),
                name varchar(255),
                mac_address varchar(255),
                ip_address varchar(255),
                type varchar(255),
                date_instal date,
                comment varchar(255),
                PRIMARY KEY (id_device)) 
                CHARACTER SET utf8 
                COLLATE utf8_czech_ci');
    }
    
    public function createAccessTable() {
        return Db::query('CREATE TABLE IF NOT EXISTS access(
                id_access int(11) AUTO_INCREMENT,
                id_device int(11),
                user_name varchar(255),
                password varchar(255),
                type varchar(255),
                comment varchar(255),
                PRIMARY KEY (id_access)) 
                CHARACTER SET utf8 
                COLLATE utf8_czech_ci');
    }
    
    public function createContactPersonTable() {
        return Db::query('CREATE TABLE IF NOT EXISTS contact_person(
                id_cp int(11) AUTO_INCREMENT,
                id_location int(11),
                f_name varchar(255),
                l_name varchar(255),
                position varchar(255),
                phone1 varchar(255),
                phone2 varchar(255),
                email varchar(255),
                comment varchar(255),
                PRIMARY KEY (id_cp)) 
                CHARACTER SET utf8 
                COLLATE utf8_czech_ci');
    }
    
     public function createExportTable() {
        return Db::query('CREATE TABLE IF NOT EXISTS export(
                id_export int(11) AUTO_INCREMENT,
                acc_file varchar(255),
                dev_file varchar(255),
                date_time datetime,
                PRIMARY KEY (id_export)) 
                CHARACTER SET utf8 
                COLLATE utf8_czech_ci');
    }
}
