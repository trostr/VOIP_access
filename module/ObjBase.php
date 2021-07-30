<?php

/**
 * Součást projektu VOIP access
 * 
 * Abstraktní třída obsahující společné methody tříd ObjXxxxxx
 *
 * 
 * @author Petr Šauer
 */
abstract class ObjBase {
    
    public function __construct() {
        $this->createDbTable();
    }
    
    public function getRow($table, $id) {
        return Db::queryOne('SELECT * FROM '.$table.' WHERE id_'.$table.' = ?', $id);
    }
    
    public abstract function getListData($id);
      
    public abstract function editData($data);
    
    public abstract function createDbTable();
}
