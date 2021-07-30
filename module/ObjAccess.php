<?php

/**
 * Součást projektu VOIP access
 * 
 * Seznam přístupových práv k jednotlivým zařízením.
 * Jméno, heslo a typ přístupu.
 * 
 * 
 * @author Petr Šauer
 */
class ObjAccess extends ObjBase{
    
    /**
     * Vrací pole dat z db tabulky
     * @param number $id_device - id zařízení
     * @return array/boolean pole dat nebo false
     */
    public function getListData($id_device) {
        return Db::queryAll('SELECT id_access, type, user_name, password, comment '
                . 'FROM access WHERE id_device = ? ORDER BY id_access', $id_device);
    }
    
    /**
     * Upravuje pole dat
     * @param array $data Pole dat
     * @return array Upravená data
     */
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
    
    /**
     * Vrátí kompletní tabulku s daty jako pole s HTML rádky
     * @return boolean/array
     */
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
    
    /**
     * Přidá nová přístupová práva zařízení do tabulky
     * @param array $data Pole dat přístupu
     * @return number Počet ovlivněných řádek tabulky
     */
    public function addNewAccess($data) {
        return Db::query('
                    INSERT INTO access (id_device, user_name, password, type, comment)
                    VALUES (?, ?, ?, ?, ?)
                    ', $data['id_device']['value'], $data['user_name']['value'],
                $data['password']['value'], $data['type']['value'], $data['comment']['value']);
    }
    
    /**
     * Změní data přístupu v tabulce
     * @param array $data Pole dat
     * @param number $id Id přístupu 
     * @return number Počet ovlivněných řádek tabulky
     */
    public function editAccess($data, $id) {
        return Db::query('UPDATE access SET id_device = ?, user_name = ?, '
                . 'password = ?, type = ?, comment = ?  WHERE id_access = ?', 
                $data['id_device']['value'], $data['user_name']['value'], 
                $data['password']['value'], $data['type']['value'], 
                $data['comment']['value'], $id);
    }
    
    /**
     * Smaže jeden řádek dat přístupu konkrétního zařízení z tabulky
     * @param number $id - Id přístupu
     */
    public function removeAccess($id) {
        return Db::query('DELETE FROM access WHERE id_access = ?', $id);
    }
    
    /**
     * Vytvoří tabulku v případě její absence
     */
    public function createDbTable() {
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
}
