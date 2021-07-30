<?php

/**
 * Součást projektu VOIP access
 * 
 * Základní controller
 *
 * 
 * @author Petr Šauer
 */
abstract class Ctr {
    
    protected $controller;
    protected $folder;
    protected $islocal = false;
    protected $local;


    public function __construct() {
        $this->local = new Location();
        $this->folder = $this->local->getFolder();
        $this->islocal = $this->local->getLocal();
        $this->setDb();
    }
    
    protected function editLink($link) {
        return $this->folder . $link;
    }
    
    public function redirect($link) {
        header("Location: /$link");
        header("Connection: close");
        exit;
    }
    
    protected function toRedirect($link) {
        $new_link = $this->folder.$link;
        $this->redirect($new_link);
    }
    
    protected function setDb() {
        // nastaveni lokalnich parametru a pripojeni databeze
        //$local = new Location();
        try {
            $this->local->setDb();
        }
        catch (Exception $e){
            $this->toRedirect("errorPage.html");
        }
    }
}
