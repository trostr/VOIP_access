<?php

/**
 * Description of NaKopecWs
 *
 * @author Petr
 */
class LocationWs extends StrankaWs{
    
    protected function body($data) {
        ?>
        <div class="container minh">
            <h4>Location list</h4>
            <?php
            if(isset($data['table'])){
                $this->showArray($data['table']);
            }
            else { ?> <p>No location.</p> <?php }
            ?>
            <p><a href="<?= $this->editLink('location/add')?>">Add new location</a></p>
            <p><a href="<?= $this->editLink('export')?>">Table export</a></p>
        </div>
        <?php        
    }
    
}
