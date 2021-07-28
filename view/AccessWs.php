<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccessWs
 *
 * @author Petr
 */
class AccessWs extends StrankaWs{
    
    protected function body($data) {
        //var_dump($data['row']);
        //$row = $data['row'];
        ?>
       
         
        <div class="container minh">
            <h4>Access list - device <?= $data['device']['name'] ?></h4>
            <p>Location: <?= $data['location']['name']?> , Company: <?= $data['location']['company']?> , Address: <?= $data['location']['address']?> </p>
            <p>Device: <?= $data['device']['name']?> , MAC-address: <?= $data['device']['mac_address']?> , IP-address: <?= $data['device']['ip_address']?> , Type device: <?= $data['device']['type']?> </p>
            <?php
            if(isset($data['table'])){
                $this->showArray($data['table']);
            }
            else { ?> <p>No access.</p> <?php }
            ?>
            <p><a href="<?= $this->editLink('location/'.$data['location']['id_location'].'/device/'.$data['device']['id_device'].'/access/add')?>">Add new access</a></p>
            <p><a href="<?= $this->editLink('location/'.$data['location']['id_location'].'/device')?>">Back to device list</a></p>
        </div>
        <?php        
    }
}
