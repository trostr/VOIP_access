<?php

/**
 * Součást projektu VOIP access
 * 
 * Seznam lokalit.
 * 
 * 
 * @author Petr Šauer
 */
class ObjLocation extends ObjBase{
    
    /**
     * Vrací pole dat z db tabulky
     * @param number $id - zde nepoužito
     * @return array/boolean pole dat nebo false
     */
    public function getListData($id) {
        return Db::queryAll('SELECT id_location, name, company FROM location '
                . 'ORDER BY id_location');
    }
    
    /**
     * Upravuje pole dat
     * @param array $data Pole dat
     * @return array Upravená data
     */
    public function editData($data) {
        foreach ($data as $key => $value) {
            //$data[$key]['name'] = '<a href="location/'.$data[$key]['id_location'].'/device">'.$data[$key]['name'].'</a>'; //glyphicon glyphicon-phone
            $data[$key]['device'] = '<a href="location/'
                    .$data[$key]['id_location'].'/device">'
                    . '<span class="glyphicon glyphicon-phone"></span></a>';
            //$data[$key]['person'] = '<a href="location/'.$data[$key]['id_location'].'/person"><span class="glyphicon glyphicon-user"></span></a>';
            $data[$key]['edit'] = '<a href="location/edit/'
                    .$data[$key]['id_location'].'">'
                    . '<span class="glyphicon glyphicon-edit"></span></a>';
            //$data[$key]['remove'] = '<a href="location/remove/'.$data[$key]['id_location'].'"><span class="glyphicon glyphicon-remove"></span></a>';
        }
        return $data;
    }
    
    /**
     * Vrátí kompletní tabulku s daty jako pole s HTML rádky
     * @return boolean/array
     */
    public function getTableData() {
        $table = new Tables();
        $tab_class = array("table", "table-striped");
        $tab_thead = array("Id", "Name", "Company", "Device", "Edit");
        $tab_data = $this->getListData(0);
        if(!$tab_data) { return false; }
        else {
            $tab_data = $this->editData($tab_data);
            return $table->buildEntireTable($tab_class, $tab_thead, $tab_data);
        }
    }
    
    /**
     * Přidá novou lokalitu do tabulky
     * @param array $data Pole dat lokality
     * @return number Počet ovlivněných řádek tabulky
     */
    public function addNewLocation($data) {
        return Db::query('
                    INSERT INTO location (name, company, address)
                    VALUES (?, ?, ?)
                    ', $data['name']['value'], $data['company']['value'], $data['address']['value']);
    }
    
    /**
     * Změní data lokality v tabulce
     * @param array $data Pole dat
     * @param number $id Id lokality 
     * @return number Počet ovlivněných řádek tabulky
     */
    public function editLocation($data, $id) {
        return Db::query('UPDATE location SET name = ?, company = ?, address = ? WHERE id_location = ?', $data['name']['value'], $data['company']['value'], $data['address']['value'], $id);
    }
    
    /**
     * Smaže lokalitu z tabulky
     * @param number $id - Id lokality
     */
    public function removeLocation($id) {
        return Db::query('DELETE FROM location WHERE id_location = ?', $id);
    }
    
    /**
     * Vytvoří tabulku za podmínky její absence
     */
    public function createDbTable() {
        return Db::query('CREATE TABLE IF NOT EXISTS location(
                id_location int(11) AUTO_INCREMENT,
                name varchar(255),
                company varchar(255),
                address varchar(255),
                PRIMARY KEY (id_location)) 
                CHARACTER SET utf8 
                COLLATE utf8_czech_ci');
    }
}
