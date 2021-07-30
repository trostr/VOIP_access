<?php

/**
 * Nástroj pro tvorbu jednoduchých formulářů 
 * 
 * Modul bez pevných vazeb na další moduly (třídy)
 *
 * 
 * @author Petr Šauer
 */
class Form {
    
    protected $data;
    protected $name;
 
    /**
     * Nastaví základní atributy formuláře
     * @param string $id Id formuláře
     * @param bool $post Metoda odeslání formuláře POST=true, GET=false
     */
    public function setForm($id, $post = true) {
        $arr['id'] = $id;
        if($post) { $arr['method'] = 'post'; }
        else { $arr['method'] = 'get';}
        $this->data['form'] = $arr;
    }
       
    /**
     * Přidá Input element do formuláře
     * @param string $label Popis políčka
     * @param string $name Název políčka
     * @param string $type Typ políčka
     * @param mixed $value Hodnota políčka
     */
    public function addInput($label, $name, $type, $value) {
        $arr['label'] = $label.'<br>';
        $arr['type'] = $type;
        $arr['name'] = $name;
        $arr['value'] = $value;
        $arr['msg'] = '';
        $this->data[$name] = $arr;
        $this->name = $name;
    }
    
    /**
     * Přidá tlačítko do formuláře
     * @param string $value Popis tlačítka
     */
    public function addButton($value) {
        $arr['type'] = 'submit';
        $arr['val'] = $value;
        $this->data['button'] = $arr;
    }
        
    /**
     * Nastavení chybové hlášky
     * @param string $name Název elementu
     * @param string $text Chybová hláška
     */
    public function setMsg($name, $text) {
        $this->data[$name]['msg'] = $text;
        //echo('Zmena chybove hlasky v '.$name.' na: '.$this->data[$name]['msg']. '<br>');
        
    }
    
    /**
     * Hromadné nastavení chybových hlášek
     * @param array $msgs
     */
    public function setMsgs($msgs) {
        foreach ($msgs as $key => $value) {
            $this->data[$key]['msg'] = $value;
        }
    }
    
    /**
     * Smazání chybové hlášky
     * @param string $name
     */
    public function clearMgs($name) {
        $this->data[$name]['msg'] = '';
    }
    
    /**
     * Nastavení podmínky Input elementu formuláře
     * @param string $name Název podmínky
     * @param mixed $value Hodnota podmínky
     * @param string $msg Chybová hláška
     */
    public function setRule($name, $value, $msg) {
        //$arr['name'] = $name;
        $arr['value'] = $value;
        $arr['msg'] = $msg;
        $this->data[$this->name]['rule'][$name] = $arr; 
    }
    
    /**
     * Nastavení atributu Input elementu formuláře
     * @param string $name Název atributu
     * @param mixed $value Hodnota atributu
     */
    public function setAttribut($name, $value) {
        $this->data[$this->name]['attr'][$name] = $value; 
    }
    
    /**
     * Nastavení podmínky a atributu Input elementu formuláře
     * @param string $name Název 
     * @param mixed $value Hodnota
     * @param string $msg Chybová hláška
     */
    public function setRuleAndAttr($name, $value, $msg) {
        $this->setAttribut($name, $value);
        $this->setRule($name, $value, $msg);
    }
    
    /**
     * Nastavení atributu a podmínky 'reqired'
     */
    public function setRequired() {
        $this->setRuleAndAttr('required', true, "Vyplňte políčko.");
    }
    
    /**
     * Nastavení atributu 'autofocus'
     */ 
    public function setFocus() {
        $this->setAttribut('autofocus', true);
    }
    
    /**
     * Vrátí pole dat formuláře
     * @return array
     */
    public function getFormData() {
        return $this->data;
    }    
    
    /**
     * Vrátí atributy ve string formátu
     * @param array $data Pole atributů Input elementu
     * @return string 
     */
    protected function getAttribut($data) {
        $str = "";
        if(isset($data['attr'])){
            foreach ($data['attr'] as $key => $value) {
                $str .= $this->attributToString($key,$value);
            }
        }
        return $str;
    }
    
    /**
     * Vrací attribut ve string větě.
     * @param string $key
     * @param mixed $value
     * @return string
     */
    protected function attributToString($key, $value) {
        if(is_bool($value)) { return $str = ' '.$key; }
        else { return $str = ' '.$key.'="'.$value.'"'; }
    }
    
    /**
     * Vrátí první řádek formuláře v HTML
     * @param array $data
     * @return string
     */
    protected function buildFirstLine($data) {
        $str = '<form ';
        $str .= 'id="'.$data['id'].'" ';
        $str .= 'method="'.$data['method'].'" ';
        $str .= '>';
        return $str;
    }
    
    /**
     * Vrátí poslední řádek formuláře v HTML
     * @return string
     */
    protected function buildLastLine() {
        return $str = '</form>';
    }
    
    /**
     * Vrátí řádek Input elemnetu formuláře v HTML
     * @param array $data
     * @return string
     */
    protected function buildInput($data) {
        $str = '<span class="form-label">'.$data['label'].'</span>';
        $str .= '<input ';
        $str .= 'type="'.$data['type'].'" ';
        $str .= 'name="'.$data['name'].'" ';
        if($data['type'] == 'password'){ // clear password value
            $str .= 'value="" ';
        }
        else { 
            $ht = htmlentities($data['value']);
            $str .= 'value="'.$ht.'" ';
        }
        $str .= $this->getAttribut($data).' ><br>';
        if($data['msg']) {
            $str .= '<span class="form-err-msg">'.$data['msg'].'</span><br>';
        }
        $str .= '<br>';
        return $str;
    }
    
    /**
     * Vrátí řádek Button elementu formuláře v HTML
     * @param array $data
     * @return string
     */
    protected function buildButton($data) {
        $str = '<input ';
        $str .= 'type="'.$data['type'].'" ';
        $str .= 'value="'.$data['val'].'" ';
        $str .= '>';
        return $str;
    }
    
    /**
     * Vrátí pole s celým formulářem v HTML řádcích
     * @param array $data
     * @return array
     */
    public function buildEntireForm($data) {
        foreach ($data as $d => $val){
            if($d == 'form') {
               $out_arr[] = $this->buildFirstLine($val);
            }
            elseif($d == 'button') {
               $out_arr[] = $this->buildButton($val); 
            }
            else {
                $out_arr[] = $this->buildInput($val);
            }
        }
        $out_arr[] = $this->buildLastLine();
        return $out_arr;
    }
        
    /**
     * Výpis formuláře v HTML formátu
     * @param array $data
     */
    public function printForm($data) {
        foreach ($data as $d) {
                echo($d."\n");
        }
    }
    
    /**
     * Přepíše pole POST do pole data
     * a odstraní prázdné znaky před a za
     */   
    public function dataPostToFormData() {
        foreach ($_POST as $post => $val) {
                $this->data[$post]['value'] = trim($val);
        }
    }
    
    public function dataToFormData($data) {
        foreach ($data as $d => $val) {
            if(isset($this->data[$d])){    
                $this->data[$d]['value'] = ($val);
            }
        }
    }
    
}
