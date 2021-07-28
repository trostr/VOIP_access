<?php

/**
 * Description of LocationDetailWs
 *
 * @author Petr
 */
class DeviceWs extends StrankaWs{
    
    protected function body($data) {
        //var_dump($data['row']);
        //$row = $data['row'];
        ?>
       
         
        <div class="container minh">
            <h4>Device list - location <?= $data['location']['name'] ?></h4>
            <p>Location: <?= $data['location']['name']?> , Company: <?= $data['location']['company']?> , Address: <?= $data['location']['address']?> </p>
            <?php
            if(isset($data['table'])){
                $this->showArray($data['table']);
            }
            else { ?> <p>No device.</p> <?php }
            ?>
            <p><a href="<?= $this->editLink('location/'.$data['location']['id_location'].'/device/add')?>">Add new device</a></p>
            <p><a href="<?= $this->editLink('location')?>">Back to location list</a></p>
        </div>
        <?php        
    }
}
