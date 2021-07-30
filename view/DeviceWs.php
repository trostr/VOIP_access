<?php

/**
 * Součást projektu VOIP access
 * 
 * View seznamu zařízení
 *
 * 
 * @author Petr Šauer
 */
class DeviceWs extends StrankaWs{
    
    protected function body($data) {
        ?>
        <div class="container minh">
            <h4>Device list - location <?= $data['location']['name'] ?></h4>
            <p>Location: <?= $data['location']['name']?> , Company: 
                <?= $data['location']['company']?> , Address: 
                <?= $data['location']['address']?> </p>
            <?php
            if(isset($data['table'])){
                $this->showArray($data['table']);
            }
            else { ?> <p>No device.</p> <?php }
            ?>
            <p><a href="<?= $this->editLink('location/'.
                    $data['location']['id_location'].'/device/add')?>">
                    Add new device</a></p>
            <p><a href="<?= $this->editLink('location')?>">
                    Back to location list</a></p>
        </div>
        <?php        
    }
}
