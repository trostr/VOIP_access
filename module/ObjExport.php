<?php

/**
 * Součást projektu VOIP access
 * 
 * Export dat tabulek do csv souboru
 *
 * 
 * @author Petr Šauer
 */
class ObjExport extends ObjBase{
    
    public $acc_file;
    public $dev_file;

    /**
     * Načte data z Db tabulky
     * @param type $id - nepoužito
     */
    public function getListData($id) {
        return Db::queryAll('SELECT * FROM export ORDER BY id_export');
    }
    
    /**
     * Abstraktní funkce - zde nopoužito 
     * @param type $param
     */
    public function editData($param) {
        
    }
    
    /**
     * Vrátí kompletní tabulku s daty jako pole s HTML rádky
     * @return boolean/array
     */
    public function getTableData() {
        $table = new Tables();
        $tab_class = array("table", "table-striped");
        $tab_thead = array("Id", "Access file", "Device file", "Date");
        $tab_data = $this->getListData(0);
        if(!$tab_data) { return false; }
        else {
            return $table->buildEntireTable($tab_class, $tab_thead, $tab_data);
        }
    }
    
    /**
     * Vztvoří nové názvy csv souborů
     */
    public function genetateFileName() {
        $id = $this->lastExportId();
        if($id !== false){ $id++; }
        else { $id = 1; }
        $this->acc_file = "acc-".$id.".csv";
        $this->dev_file = "dev-".$id.".csv";
    }
    
    /**
     * Exportuje data z db tabulky do csv souboru
     * @param string $file_name - Název csv souboru
     * @param string $table - Název db tabulky 
     */
    public function tableToFile($file_name, $table) {
        $data = Db::queryAll('SELECT * FROM '.$table.' ORDER BY id_'.$table);
        $file = fopen($file_name,"a");
        fwrite($file,  $this->tableThead($table));
        foreach ($data as $key => $value) {
            $str = implode(",", $data[$key])."\n";
            fwrite($file,$str);
        }
        fclose($file);
    }
    
    /**
     * Zapíše do db tabulky názvy nově vytvořených scv souborů s datem vzniku 
     * @return number or boolean
     */
    public function addNewExport() {
        $date = new DateTime('now');
        return Db::query('
                    INSERT INTO export (acc_file, dev_file, date_time)
                    VALUES (?, ?, ?)
                    ', $this->acc_file, $this->dev_file, $date->format("Y-m-d H:i:s"));
    }
    
    /**
     * Vrátí id posledního exportu
     * @return number or boolean
     */
    public function lastExportId() {
        return Db::querySingle('SELECT id_export FROM export ORDER BY id_export DESC');
    }
    
    /**
     * Vrátí string s názvy sloupců tabulky oddělené čárkou
     * @param string $table - Název db tabulky
     * @return string - Názvy sloupců tabulky
     */
    public function tableThead($table) {
        $row = Db::queryOne('SELECT * FROM '.$table);
        foreach ($row as $key => $value) {
            $arr_thead[] = $key;
        }
        return $str = implode(",", $arr_thead)."\n";
    }
    
    /**
     * Vytvoří tabulku v případě její absence
     */
    public function createDbTable() {
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
