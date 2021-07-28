<?php

/**
 * Description of ExpotrWs
 *
 * @author Petr
 */
class ExportWs extends StrankaWs{
    
    protected function body($data) {
        ?> 
        <div class="container minh">
            <h4>Export device and access tebles</h4>
            <?php
            if(isset($data['table'])){
                $this->showArray($data['table']);
            }
            else { ?> <p>No export.</p> <?php }
            ?>
            <br>
            <form method="post" >
                <input style="display: none" type="text" name="name" value="">
                <input type="submit" value="Export" >
            </form>
            <br> 
            
            <p><a href="<?= $this->editLink('location')?>">Back to location list</a></p>
        </div>
        <?php        
    }
}
