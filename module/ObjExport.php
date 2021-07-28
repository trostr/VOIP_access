<?php

/**
 * Description of Export
 *
 * @author Petr
 */
class ObjExport extends ObjBase{
    
    public $acc_file;
    public $dev_file;


    public function getListData($id) {
        return Db::queryAll('SELECT * FROM export ORDER BY id_export');
    }
    
    public function editData($param) {
        
    }
    
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
    
    public function genetateFileName() {
        $id = $this->lastExportId();
        if($id !== false){ $id++; }
        else { $id = 1; }
        $this->acc_file = "acc-".$id.".csv";
        $this->dev_file = "dev-".$id.".csv";
    }
    
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
    
    public function addNewExport() {
        $date = new DateTime('now');
        return Db::query('
                    INSERT INTO export (acc_file, dev_file, date_time)
                    VALUES (?, ?, ?)
                    ', $this->acc_file, $this->dev_file, $date->format("Y-m-d H:i:s"));
    }
    
    public function lastExportId() {
        return Db::querySingle('SELECT id_export FROM export ORDER BY id_export DESC');
    }
    
    public function tableThead($table) {
        $row = Db::queryOne('SELECT * FROM '.$table);
        foreach ($row as $key => $value) {
            $arr_thead[] = $key;
        }
        return $str = implode(",", $arr_thead)."\n";
    }
}
