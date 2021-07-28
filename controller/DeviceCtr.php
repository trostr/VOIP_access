<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeviceCtr
 *
 * @author Petr
 */
class DeviceCtr extends Ctr{
    
    protected $device;

    public function process($data) {
        $this->device = new ObjDevice();
        $way = $data['parametr'];
        if(isset($way[3])) {
            if(is_numeric($way[3])) {
                $this->detailDevice($data);
            }
            elseif($way[3] === "add"){
                $this->addNewDevice($data);
            }
            elseif($way[3] === "edit"){
                $this->editDevice($data);
            }
            elseif ($way[3] === "remove") {
                $this->removeDevice($data);
            }
            else { $this->redirect($this->folder.'location/'.$way[1].'/device'); }
        }
        else {
            $this->deviceList($data);
        }
    }
    
    public function deviceList($data) {
        $data['nazev'] = "Device list";
        $data['popisek'] = "nic"; 
        $table_data = $this->device->getTableData($data['location']['id_location']);
        if($table_data) {
            $data['table'] = $table_data;
        }
        $view = new DeviceWs();
        $view->show($data);
    }
    
    public function detailDevice($data) {
        $row = $this->device->getRow("device", $data['parametr'][3]);
        if($row) { 
            $data['device'] = $row;
            $this->linkSwitch($data);
        }
        else { $this->redirect($this->folder.'location/'.$data['parametr'][1].'/device'); } 
    }
    
    public function linkSwitch($data) {
        if(isset($data['parametr'][4])) {
            if($data['parametr'][4] === "access") {
                $access_ctr = new AccessCtr();
                $access_ctr->process($data);
            }
            elseif ($data['parametr'][2] === "person") {

            }
            else { $this->redirect($this->folder.'location'); } 
        }
    }
   
    public function addNewDevice($data) {
        $data['nazev'] = "Add new device ";
        $data['popisek'] = "nic";
        $form = new UserAssemblyForm();
        //$form_data['id_location'] = ;
        $form->deviceForm($data['parametr'][1]);
        if($_POST) {
            $form->dataPostToFormData(); 
            $this->device->addNewDevice($form->getFormData());
            $this->redirect($this->folder.'location/'.$data['parametr'][1].'/device');
        }
        $data['form'] = $form->buildEntireForm($form->getFormData());
        $view = new DeviceFormWs();
        $view->show($data);
    }
   
    public function editDevice($data) {
        if(is_numeric($data['parametr'][4])) {
            $row = $this->device->getRow('device', $data['parametr'][4]);
            if($row) {
                $data['nazev'] = "Edit device";
                $data['popisek'] = "nic";
                $data['remove'] = true;
                $form = new UserAssemblyForm();
                $form->deviceForm('');
                $form->dataToFormData($row);
                if($_POST) {
                    $form->dataPostToFormData(); 
                    $this->device->editDevice($form->getFormData(), $row['id_device']);
                    $this->redirect($this->folder.'location/'.$data['location']['id_location'].'/device');
                }
                $data['form'] = $form->buildEntireForm($form->getFormData());
                $view = new DeviceFormWs();
                $view->show($data);
            }
            else { $this->redirect($this->folder.'location'.$data['location']['id_location'].'/device'); } 
        }
        else { $this->redirect($this->folder.'location'.$data['location']['id_location'].'/device'); } 
    }
    
    public function removeDevice($data) {
        if(is_numeric($data['parametr'][4])) {
            $this->device->removeDevice($data['parametr'][4]);
        }
        $this->redirect($this->folder.'location/'.$data['parametr'][1].'/device');
    }
}
