<?php

 /**
 * Součást projektu VOIP access
 * 
 * View formuláře lokalit
 *
 * 
 * @author Petr Šauer
 */
class LocationFormWs extends StrankaWs{
    
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
                    <p><a href="<?= $this->editLink('location/remove/'.
                            $data['parametr'][2])?>">Remove this location</a></p>
                    <?php
                }
            }
            ?>
            <p><a href="<?= $this->editLink('location')?>">Back to location list</a></p>
        </div>
        <?php        
    }
}
