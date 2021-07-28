<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ObjLocation
 *
 * @author Petr
 */
class ObjLocation extends ObjBase{
    
    public function getListData($id) {
        return Db::queryAll('SELECT id_location, name, company FROM location ORDER BY id_location');
    }
    
    public function editData($data) {
        foreach ($data as $key => $value) {
            //$data[$key]['name'] = '<a href="location/'.$data[$key]['id_location'].'/device">'.$data[$key]['name'].'</a>'; //glyphicon glyphicon-phone
            $data[$key]['device'] = '<a href="location/'.$data[$key]['id_location'].'/device"><span class="glyphicon glyphicon-phone"></span></a>';
            $data[$key]['person'] = '<a href="location/'.$data[$key]['id_location'].'/person"><span class="glyphicon glyphicon-user"></span></a>';
            $data[$key]['edit'] = '<a href="location/edit/'.$data[$key]['id_location'].'"><span class="glyphicon glyphicon-edit"></span></a>';
            //$data[$key]['remove'] = '<a href="location/remove/'.$data[$key]['id_location'].'"><span class="glyphicon glyphicon-remove"></span></a>';
        }
        return $data;
    }
    
    public function getTableData() {
        $table = new Tables();
        $tab_class = array("table", "table-striped");
        $tab_thead = array("Id", "Name", "Company", "Device", "Person", "Edit");
        $tab_data = $this->getListData(0);
        if(!$tab_data) { return false; }
        else {
            $tab_data = $this->editData($tab_data);
            return $table->buildEntireTable($tab_class, $tab_thead, $tab_data);
        }
    }
    
    public function addNewLocation($data) {
        return Db::query('
                    INSERT INTO location (name, company, address)
                    VALUES (?, ?, ?)
                    ', $data['name']['value'], $data['company']['value'], $data['address']['value']);
    }
    
    public function editLocation($data, $id) {
        return Db::query('UPDATE location SET name = ?, company = ?, address = ? WHERE id_location = ?', $data['name']['value'], $data['company']['value'], $data['address']['value'], $id);
    }
    
    public function removeLocation($id) {
        return Db::query('DELETE FROM location WHERE id_location = ?', $id);
    }
}
