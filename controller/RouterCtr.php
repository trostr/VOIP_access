<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of smerovac
 *
 * @author Petr
 */
class RouterCtr extends Ctr{
    
    protected $base_ctr = "location";
    protected $data;


    protected function editLink($link) {
        $edited_link = parse_url($link);
        $edited_link["path"] = substr($edited_link["path"], strlen($this->folder));
        $edited_link["path"] = ltrim($edited_link["path"],"/");
        $edited_link["path"] = trim($edited_link["path"]);
        return explode('/', $edited_link["path"]);
    }
    
    protected function toRedirect($link) {
        $new_link = $this->folder.$link;
        $this->redirect($new_link);
    }
    
    protected function className($text) {
	$str = str_replace('-', ' ', $text);
	$str = ucwords($str);
	$str = str_replace(' ', '', $str);
	return $str;
    }
    
    
    
    public function process($link) {
        // ---------- save user access
        //$acs = new Access();
        //$acs->addAccess($link);
        // ---------- process
        $edited_link = $this->editLink($link);
        if(empty($edited_link[0]) || $edited_link[0] == "index.php"){
            $this->toRedirect($this->base_ctr);
        }
        else { 
            $class_name = $this->className($edited_link[0])."Ctr";
            if (file_exists('controller/' . $class_name . '.php')){
		
                $this->controller = new $class_name;
                //$data["class"] = $class_name;
            }
            else {
                $this->toRedirect($this->base_ctr);
            }
            $data['parametr'] = $edited_link;
            // ----------- navratovy parametr pro prihlaseni a registraci
            /*
            if($edited_link[0] == 'prihlaseni' || $edited_link[0] == 'registrace') {
                if(isset($edited_link[1])) {
                    $data['parametr'][0] = $edited_link[1];
                }
                else { $data['parametr'][0] = 'zvadlo'; }
            }
            else{ $data['parametr'] = $edited_link; }
             * 
             */    
            // ---------- predani dat konkretnimu kontroleru
            $this->controller->process($data);
        }
    }
    
}
