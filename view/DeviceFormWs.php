<?php

/**
 * Součást projektu VOIP access
 * 
 * View formuláře zařízení
 *
 * 
 * @author Petr Šauer
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
                    <p><a href="<?= $this->editLink('location/'.
                            $data['parametr'][1].'/device/remove/'.
                            $data['parametr'][4])?>">Remove this device</a></p>
                    <?php
                }
            }
            ?>
            <p><a href="<?= $this->editLink('location/'.$data['parametr'][1]).
                    '/device'?>">Back to device list</a></p>
        </div>
        <?php        
    }
}
