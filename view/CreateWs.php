<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateWs
 *
 * @author Petr
 */
class CreateWs extends StrankaWs{
   
    public function show($data) {
        $this->header($data);
        //$this->navigation($data['parametr']);
        $this->body($data);
        $this->heel();
    }
    
     protected function body($data) {
        ?>
        
        <div class="container cont-mar minh">
        <h2>Na pokec na kopec</h2>
        <?php
                var_dump($data);
        /*
        if(isset($data['table'])) {
            foreach ($data['table'] as $value) {
                echo($value);
            }
        }
         * 
         */
        ?>
        </div>
        <?php        
    }
}
