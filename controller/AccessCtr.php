<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccessCtr
 *
 * @author Petr
 */
class AccessCtr extends Ctr{
    
    protected $access;

    public function process($data) {
        $this->access = new ObjAccess();
        $way = $data['parametr'];
        if(isset($way[5])) {
            if($way[5] === "add"){
                $this->addNewAccess($data);
            }
            elseif($way[5] === "edit"){
                $this->editAccess($data);
            }
            elseif ($way[5] === "remove") {
                $this->removeAccess($data);
            }
            else { $this->redirect($this->folder.'location/'.$data['location']['id_location'].'/device/'.$data['device']['id_device'].'/access'); }
        }
        else {
            $this->accessList($data);
        }
    }
    
    public function accessList($data) {
        $data['nazev'] = "Access list";
        $data['popisek'] = "nic"; 
        $table_data = $this->access->getTableData($data['device']['id_device']);
        if($table_data) {
            $data['table'] = $table_data;
        }
        $view = new AccessWs();
        $view->show($data);
    }
   
    public function addNewAccess($data) {
        $data['nazev'] = "Add new access";
        $data['popisek'] = "nic";
        $form = new UserAssemblyForm();
        $code = new CodeGenerator();
        $form_data['id'] = $data['parametr'][3];
        $form_data['user_name'] = $code->generateUserName(5, 3);
        $form_data['password'] = $code->generatePassword(12);
        $form->accessForm($form_data);
        if($_POST) {
            $form->dataPostToFormData(); 
            $this->access->addNewAccess($form->getFormData());
            $this->redirect($this->folder.'location/'.$data['parametr'][1].'/device/'.$data['parametr'][3].'/access');
        }
        $data['form'] = $form->buildEntireForm($form->getFormData());
        $view = new AccessFormWs();
        $view->show($data);
    }
   
    public function editAccess($data) {
        if(is_numeric($data['parametr'][6])) {
            $row = $this->access->getRow('access', $data['parametr'][6]);
            if($row) {
                $data['nazev'] = "Edit Access";
                $data['popisek'] = "nic";
                $data['remove'] = true;
                $form = new UserAssemblyForm();
                $form_data['id'] = '';
                $form_data['user_name'] = '';
                $form_data['password'] = '';
                $form->accessForm($form_data);
                $form->dataToFormData($row);
                if($_POST) {
                    $form->dataPostToFormData(); 
                    $this->access->editAccess($form->getFormData(), $row['id_access']);
                    $this->redirect($this->folder.'location/'.$data['location']['id_location'].'/device/'.$data['device']['id_device'].'/access');
                }
                $data['form'] = $form->buildEntireForm($form->getFormData());
                $view = new AccessFormWs();
                $view->show($data);
            }
            else { $this->redirect($this->folder.'location/'.$data['location']['id_location'].'/device/'.$data['device']['id_device'].'/access'); } 
        }
        else { $this->redirect($this->folder.'location/'.$data['location']['id_location'].'/device/'.$data['device']['id_device'].'/access'); } 
    }
    
    public function removeAccess($data) {
        if(is_numeric($data['parametr'][6])) {
            $this->access->removeAccess($data['parametr'][6]);
        }
        $this->redirect($this->folder.'location/'.$data['location']['id_location'].'/device/'.$data['device']['id_device'].'/access');
    }
}
