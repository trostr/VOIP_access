<?php

/**
 * Součást projektu VOIP access
 * 
 * Router controller
 *
 * 
 * @author Petr Šauer
 */
class RouterCtr extends Ctr{
    
    protected $base_ctr = "location";
    protected $data;

    /**
     * Převede část URL adresy (path) na pole řetězců
     * @param string $link Vstupní řetězec "path"
     * @return array pole řetězců
     */
    protected function editLink($link) {
        $edited_link = parse_url($link);
        $edited_link["path"] = substr($edited_link["path"], strlen($this->folder));
        $edited_link["path"] = ltrim($edited_link["path"],"/");
        $edited_link["path"] = trim($edited_link["path"]);
        return explode('/', $edited_link["path"]);
    }
    
    /**
     * Vrátí jméno třídy
     * @param string $text Vstupní řetězec
     * @return string Jméno třídy
     */
    protected function className($text) {
	$str = str_replace('-', ' ', $text);
	$str = ucwords($str);
	$str = str_replace(' ', '', $str);
	return $str;
    }
    
    public function process($link) {
        $edited_link = $this->editLink($link);
        if(empty($edited_link[0]) || $edited_link[0] == "index.php"){
            $this->toRedirect($this->base_ctr);
        }
        else { 
            $class_name = $this->className($edited_link[0])."Ctr";
            if (file_exists('controller/' . $class_name . '.php')){
		
                $this->controller = new $class_name;
            }
            else {
                $this->toRedirect($this->base_ctr);
            }
            $data['parametr'] = $edited_link;
            // ---------- predani dat konkretnimu kontroleru
            $this->controller->process($data);
        }
    }
    
}
