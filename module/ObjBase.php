<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ObjBase
 *
 * @author Petr
 */
abstract class ObjBase {
    
    public function getRow($table, $id) {
        return Db::queryOne('SELECT * FROM '.$table.' WHERE id_'.$table.' = ?', $id);
    }
    
    public abstract function getListData($id);
    
    public abstract function editData($data);
}
