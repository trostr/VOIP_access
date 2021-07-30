<?php

/**
 * Soubor přednastavených formulářů 
 * 
 * Modul vyžaduje třídu Form
 *
 * 
 * @author Petr Šauer
 */
class UserAssemblyForm extends Form{
    
    /**
     * Přednastavený přihlašovací formulář
     */
    public function userLoginForm() {
        $this->setForm('form-login');
        $this->addUserNameInput('Jméno');
        $this->addPasswordInput('Heslo');
        $this->addButton('Přihlásit');
    }
    
    /**
     * Přednastavený registrační formulář
     */
    public function userRegistrationForm() {
        $this->setForm('form-reg');
        $this->addUserNameInput('Jméno');
        $this->addMailInput('Email');
        $this->addPasswordInput('Heslo');
        $this->addCheckPasswordInput('Kontolní heslo');
        $this->addButton('Registrovat');
    }
    
    public function locationForm() {
        $this->setForm('form-location');
        $this->addInput('Name', 'name', 'text', '');
        $this->addInput('Company', 'company', 'text', '');
        $this->addInput('Address', 'address', 'text', '');
        $this->addButton('Save');
    }
    
    public function deviceForm($id) {
        $this->setForm('form-device');
        $this->addInput('Location', 'id_location', 'text', $id);
        $this->addInput('Name', 'name', 'text', '');
        $this->addInput('Mac-address', 'mac_address', 'text', '');
        $this->addInput('IP-address', 'ip_address', 'text', '');
        $this->addInput('Type', 'type', 'text', '');
        $this->addInput('Date-instal', 'date_instal', 'date', '');
        $this->addInput('SN', 'sn', 'text', '');
        $this->addInput('Comment', 'comment', 'text', '');
        $this->addButton('Save');
    }
    
    public function accessForm($data) {
        $this->setForm('form-access');
        $this->addInput('Device', 'id_device', 'text', $data['id']);
        $this->addInput('User name', 'user_name', 'text', $data['user_name']);
        $this->addInput('Password', 'password', 'text', $data['password']);
        $this->addInput('Type', 'type', 'text', '');
        $this->addInput('Comment', 'comment', 'text', '');
        $this->addButton('Save');
    }
    
    /**
     * Přednastavený Input element formuláře
     * @param string $label Popis políčka
     */
    public function addUserNameInput($label) {
        $this->addInput($label, 'name', 'text', '');
        $this->setFocus();
        $this->setRequired();
        $this->setRule('smin', 3, "Příliš krátký text.");
        $this->setRule('smax', 40, "Příliš dlouhý text.");
        $this->setRule('banchars', true, "Obsahuje nepovolené znaky.");
    }
    
    /**
     * Přednastavený Input element formuláře
     * @param string $label Popis políčka
     */
    public function addMailInput($label) {
        $this->addInput($label, 'mail', 'mail', '');
        $this->setRequired();
        $this->setRule('smax', 40, "Příliš dlouhý text.");
        $this->setRule('mail', true, "Neplatný formát emailu.");
    }
    
    /**
     * Přednastavený Input element formuláře
     * @param string $label Popis políčka
     */
    public function addPasswordInput($label) {
        $this->addInput($label, 'pass', 'password', '');
        $this->setRequired();
        $this->setRule('smin', 3, "Příliš krátké heslo.");
        $this->setRule('smax', 40, "Příliš dlouhé heslo.");
        $this->setRule('banchars', true, "Obsahuje nepovolené znaky.");
    }
    
    /**
     * Přednastavený Input element formuláře
     * @param string $label Popis políčka
     */
    public function addCheckPasswordInput($label) {
        $this->addInput($label, 'xpass', 'password', '');
        $this->setRequired();
        $this->setRule('samepass', 'pass', "Nestejná hesla.");
    }
}
