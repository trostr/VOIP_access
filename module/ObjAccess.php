<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ObjAccess
 *
 * @author Petr
 */
class ObjAccess extends ObjBase{
    
    public function getListData($id_device) {
        return Db::queryAll('SELECT id_access, type, user_name, password, comment '
                . 'FROM access WHERE id_device = ? ORDER BY id_access', $id_device);
    }
    
    public function editData($data) {
        foreach ($data as $key => $value) {
            //$data[$key]['name'] = '<a href="device/'.$data[$key]['id_device'].'">'.$data[$key]['name'].'</a>';
            //$data[$key]['access'] = '<a href="device/'.$data[$key]['id_device'].'/access"><span class="glyphicon glyphicon-tags"></span></a>'; 
            $data[$key]['edit'] = '<a href="access/edit/'.$data[$key]['id_access'].'">'
                    . '<span class="glyphicon glyphicon-edit"></span></a>';
            //$data[$key]['remove'] = '<a href="device/'.$data[$key]['id_device'].'"><span class="glyphicon glyphicon-tags"></span></a>';
        }
        return $data; 
    }
    
    public function getTableData($id_device) {
        $table = new Tables();
        $tab_class = array("table", "table-striped");
        $tab_thead = array("Id", "Type", "User name", "Password", "Comment", "Edit");
        $tab_data = $this->getListData($id_device);
        if(!$tab_data) { return false; }
        else {
            $tab_data = $this->editData($tab_data);
            return $table->buildEntireTable($tab_class, $tab_thead, $tab_data);
        }
    }
    
    public function addNewAccess($data) {
        return Db::query('
                    INSERT INTO access (id_device, user_name, password, type, comment)
                    VALUES (?, ?, ?, ?, ?)
                    ', $data['id_device']['value'], $data['user_name']['value'],
                $data['password']['value'], $data['type']['value'], $data['comment']['value']);
    }
    
    public function editAccess($data, $id) {
        return Db::query('UPDATE access SET id_device = ?, user_name = ?, '
                . 'password = ?, type = ?, comment = ?  WHERE id_access = ?', 
                $data['id_device']['value'], $data['user_name']['value'], 
                $data['password']['value'], $data['type']['value'], 
                $data['comment']['value'], $id);
    }
    
    public function removeAccess($id) {
        return Db::query('DELETE FROM access WHERE id_access = ?', $id);
    }
}
