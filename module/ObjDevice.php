<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Device
 *
 * @author Petr
 */
class ObjDevice extends ObjBase{
    
    public function getListData($id_location) {
        return Db::queryAll('SELECT id_device, name, mac_address, ip_address, type, date_instal, sn FROM device WHERE id_location = ? ORDER BY id_device', $id_location);
    }
    
    public function editData($data) {
       foreach ($data as $key => $value) {
            //$data[$key]['name'] = '<a href="device/'.$data[$key]['id_device'].'">'.$data[$key]['name'].'</a>';
            $data[$key]['access'] = '<a href="device/'.$data[$key]['id_device'].'/access"><span class="glyphicon glyphicon-tags"></span></a>'; 
            $data[$key]['edit'] = '<a href="device/edit/'.$data[$key]['id_device'].'"><span class="glyphicon glyphicon-edit"></span></a>';
            //$data[$key]['remove'] = '<a href="device/'.$data[$key]['id_device'].'"><span class="glyphicon glyphicon-tags"></span></a>';
        }
        return $data; 
    }
    
    public function getTableData($id_location) {
        $table = new Tables();
        $tab_class = array("table", "table-striped");
        $tab_thead = array("Id", "Name", "Mac-address", "IP-address", "Type", "Date instal", "SN", "Access", "Edit");
        $tab_data = $this->getListData($id_location);
        if(!$tab_data) { return false; }
        else {
            $tab_data = $this->editData($tab_data);
            return $table->buildEntireTable($tab_class, $tab_thead, $tab_data);
        }
    }
    
    public function addNewDevice($data) {
        return Db::query('
                    INSERT INTO device (id_location, name, mac_address, ip_address, type, date_instal, sn, comment)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                    ', $data['id_location']['value'], $data['name']['value'], $data['mac_address']['value'], $data['ip_address']['value'], $data['type']['value'], $data['date_instal']['value'], $data['sn']['value'], $data['comment']['value']);
    }
    
    public function editDevice($data, $id) {
        return Db::query('UPDATE device SET id_location = ?, name = ?, mac_address = ?, ip_address = ?, type = ?, date_instal = ?, sn = ?, comment = ?  WHERE id_device = ?', $data['id_location']['value'], $data['name']['value'], $data['mac_address']['value'], $data['ip_address']['value'], $data['type']['value'], $data['date_instal']['value'], $data['sn']['value'], $data['comment']['value'], $id);
    }
    
    public function removeDevice($id) {
        return Db::query('DELETE FROM device WHERE id_device = ?', $id);
    }
}
