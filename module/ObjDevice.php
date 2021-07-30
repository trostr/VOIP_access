<?php

/**
 * Součást projektu VOIP access
 * 
 * Seznam zařízení a jejich parametrů.
 * Name, MAC-address, IP-address, type, datum instalace, výrobní číslo.
 * 
 * 
 * @author Petr Šauer
 */
class ObjDevice extends ObjBase{
    
    /**
     * Vrací pole dat z db tabulky
     * @param number $id_location - id lokality
     * @return array/boolean pole dat nebo false
     */
    public function getListData($id_location) {
        return Db::queryAll('SELECT id_device, name, mac_address, ip_address, type, date_instal, sn FROM device WHERE id_location = ? ORDER BY id_device', $id_location);
    }
    
    /**
     * Upravuje pole dat
     * @param array $data Pole dat
     * @return array Upravená data
     */
    public function editData($data) {
       foreach ($data as $key => $value) {
            //$data[$key]['name'] = '<a href="device/'.$data[$key]['id_device'].'">'.$data[$key]['name'].'</a>';
            $data[$key]['access'] = '<a href="device/'.$data[$key]['id_device'].'/access"><span class="glyphicon glyphicon-tags"></span></a>'; 
            $data[$key]['edit'] = '<a href="device/edit/'.$data[$key]['id_device'].'"><span class="glyphicon glyphicon-edit"></span></a>';
            //$data[$key]['remove'] = '<a href="device/'.$data[$key]['id_device'].'"><span class="glyphicon glyphicon-tags"></span></a>';
        }
        return $data; 
    }
    
    /**
     * Vrátí kompletní tabulku s daty jako pole s HTML rádky
     * @param number $id_location ID lokality
     * @return boolean/array
     */
    public function getTableData($id_location) {
        $table = new Tables();
        $tab_class = array("table", "table-striped");
        $tab_thead = array("Id", "Name", "Mac-address", "IP-address", "Type", 
            "Date instal", "SN", "Access", "Edit");
        $tab_data = $this->getListData($id_location);
        if(!$tab_data) { return false; }
        else {
            $tab_data = $this->editData($tab_data);
            return $table->buildEntireTable($tab_class, $tab_thead, $tab_data);
        }
    }
    
    /**
     * Přidá nové zařízení do tabulky
     * @param array $data Pole dat zařízení
     * @return number Počet ovlivněných řádek tabulky
     */
    public function addNewDevice($data) {
        return Db::query('
                    INSERT INTO device (id_location, name, mac_address, 
                    ip_address, type, date_instal, sn, comment)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                    ', $data['id_location']['value'], $data['name']['value'], 
                $data['mac_address']['value'], $data['ip_address']['value'], 
                $data['type']['value'], $data['date_instal']['value'], 
                $data['sn']['value'], $data['comment']['value']);
    }
    
    /**
     * Změní data zařízení v tabulce
     * @param array $data Pole dat
     * @param number $id Id zařízení 
     * @return number Počet ovlivněných řádek tabulky
     */
    public function editDevice($data, $id) {
        return Db::query('UPDATE device SET id_location = ?, name = ?, mac_address = ?, ip_address = ?, type = ?, date_instal = ?, sn = ?, comment = ?  WHERE id_device = ?', $data['id_location']['value'], $data['name']['value'], $data['mac_address']['value'], $data['ip_address']['value'], $data['type']['value'], $data['date_instal']['value'], $data['sn']['value'], $data['comment']['value'], $id);
    }
    
    /**
     * Smaže jeden řádek dat zařízení z tabulky
     * @param number $id - Id zařízení
     */
    public function removeDevice($id) {
        return Db::query('DELETE FROM device WHERE id_device = ?', $id);
    }
    
    /**
     * Vytvoří tabulku v případě její absence
     */
    public function createDbTable() {
        return Db::query('CREATE TABLE IF NOT EXISTS device(
                id_device int(11) AUTO_INCREMENT,
                id_location int(11),
                name varchar(255),
                mac_address varchar(255),
                ip_address varchar(255),
                type varchar(255),
                date_instal date,
                comment varchar(255),
                sn varchar(255),
                PRIMARY KEY (id_device)) 
                CHARACTER SET utf8 
                COLLATE utf8_czech_ci');
    }
}
