<?php

/**
 * Součást projektu VOIP access
 * 
 * Controller pro práci s daty lokalit
 *
 * 
 * @author Petr Šauer
 */
class LocationCtr extends Ctr{
    
    protected $location;

    public function process($data) {
        $this->location = new ObjLocation();
        $way = $data['parametr'];
        if(isset($way[1])) {
            if(is_numeric($way[1])) {
                $this->detailLocation($data);
            }
            elseif($way[1] === "add"){
                $this->addNewLocation($data);
            }
            elseif($way[1] === "edit"){
                $this->editLocation($data);
            }
            elseif ($way[1] === "remove") {
                $this->removeLocation($data);
            }
            else { $this->redirect($this->folder.'location'); }
        }
        else {
            $this->locationList($data);
        }
    }
   
    public function locationList($data) {
        $data['nazev'] = "VoIP Access - Location";
        $data['popisek'] = "nic"; 
        $table_data = $this->location->getTableData();
        if($table_data) {
            $data['table'] = $table_data;
        }
        $view = new LocationWs();
        $view->show($data);
    }
   
    public function detailLocation($data) {
        $row = $this->location->getRow("location", $data['parametr'][1]);
        if($row) { 
            $data['location'] = $row;
            $this->linkSwitch($data);
        }
        else { $this->redirect($this->folder.'location'); } 
    }
    
    public function linkSwitch($data) {
        if(isset($data['parametr'][2])) {
                if($data['parametr'][2] === "device") {
                    $device_ctr = new DeviceCtr();
                    $device_ctr->process($data);
                }
                elseif ($data['parametr'][2] === "person") {
                    
                }
                else { $this->redirect($this->folder.'location'); } 
            }
    }
    
    public function addNewLocation($data) {
        $data['nazev'] = "Add new location ";
        $data['popisek'] = "nic";
        $form = new UserAssemblyForm();
        $form->locationForm();
        if($_POST) {
            $form->dataPostToFormData(); 
            $this->location->addNewLocation($form->getFormData());
            $this->redirect($this->folder.'location');
        }
        $data['form'] = $form->buildEntireForm($form->getFormData());
        $view = new LocationFormWs();
        $view->show($data);
    }
   
    public function editLocation($data) {
        if(is_numeric($data['parametr'][2])) {
            $row = $this->location->getRow('location', $data['parametr'][2]);
            if($row) {
                $data['nazev'] = "Edit location ";
                $data['popisek'] = "nic";
                $data['remove'] = true;
                $form = new UserAssemblyForm();
                $form->locationForm();
                $form->dataToFormData($row);
                if($_POST) {
                    $form->dataPostToFormData(); 
                    $this->location->editLocation($form->getFormData(), $row['id_location']);
                    $this->redirect($this->folder.'location');
                }
                $data['form'] = $form->buildEntireForm($form->getFormData());
                $view = new LocationFormWs();
                $view->show($data);
            }
            else { $this->redirect($this->folder.'location'); } 
        }
        else { $this->redirect($this->folder.'location'); } 
    }
    
    public function removeLocation($data) {
        if(is_numeric($data['parametr'][2])) {
            $this->location->removeLocation($data['parametr'][2]);
        }
        $this->redirect($this->folder.'location');
    }
    
    
}
