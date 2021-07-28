<?php

/**
 * Description of ExportCtr
 *
 * @author Petr
 */
class ExportCtr extends Ctr{
    
    protected $export;
    
    public function process($data) {
        $this->export = new ObjExport();
        $data['nazev'] = "Tables export";
        $data['popisek'] = "nic";
        if($_POST) {
            $this->export->genetateFileName();
            $this->export->tableToFile($this->export->acc_file, 'access');
            $this->export->tableToFile($this->export->dev_file, 'device');
            $this->export->addNewExport();
        }
        $table_data = $this->export->getTableData();
        if($table_data) {
            $data['table'] = $table_data;
        }
        $view = new ExportWs();
        $view->show($data);
    }
}
