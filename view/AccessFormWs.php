<?php

 /**
 * Součást projektu VOIP access
 * 
 * View formuláře přístupů
 *
 * 
 * @author Petr Šauer
 */
class AccessFormWs extends StrankaWs{
    
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
                            $data['parametr'][1].'/device/'.
                            $data['parametr'][3].'/access/remove/'.
                            $data['parametr'][6])?>">Remove this access</a></p>
                    <?php
                }
            }
            ?>
    <p><a href="<?= $this->editLink('location/'.$data['parametr'][1].
            '/device/'.$data['parametr'][3].'/access') ?>">Back to access list</a></p>
        </div>
        <?php        
    }
}
