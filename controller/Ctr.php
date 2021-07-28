<?php

/**
 * Description of Kontroler
 *
 * @author Petr
 */
abstract class Ctr {
    
    protected $controller;
    protected $folder;
    protected $islocal = false;


    public function __construct() {
        $local = new Location();
        $this->folder = $local->getFolder();
        $this->islocal = $local->getLocal();
    }
    
    protected function editLink($link) {
        return $this->folder . $link;
    }
    
    public function redirect($link) {
        header("Location: /$link");
        header("Connection: close");
        exit;
    }
}
