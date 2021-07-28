<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeviceFormWs
 *
 * @author Petr
 */
class DeviceFormWs extends StrankaWs{
    
    protected function body($data) {
        ?>
        <div class="container minh">
            <h4><?= $data['nazev'] ?></h4>
            <?php
            if(isset($data['form'])){
                $this->showArray($data['form']);
            }  
            ?>
            <br>
            <?php
            if(isset($data['remove'])) {
                if($data['remove']) {
                    ?>
                    <p><a href="<?= $this->editLink('location/'.$data['parametr'][1].'/device/remove/'.$data['parametr'][4])?>">Remove this device</a></p>
                    <?php
                }
            }
            ?>
            <p><a href="<?= $this->editLink('location/'.$data['parametr'][1]).'/device'?>">Back to device list</a></p>
        </div>
        <?php        
    }
}
