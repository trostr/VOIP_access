<?php

 /**
 * Součást projektu VOIP access
 * 
 * Základní view
 *
 * 
 * @author Petr Šauer
 */
class StrankaWs {
    protected $folder;
    protected $user = "";

    public function __construct() {
        $local = new Location();
        $this->folder = "/".$local->getFolder();
        $this->getSessUser();
    }
    
    protected function editLink($link) {
        return $this->folder . $link;
    }
    
    protected function getSessUser() {
        if(isset($_SESSION['name'])) {
            $this->user = $_SESSION['name'];     
        }
    }
    
    protected function header($data) {
        ?>
        <!DOCTYPE html>
            <html
                <head>
                    <title><?= $data['nazev'] ?></title>
                    <meta name="description" content="<?= $data['popisek'] ?>">
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <!-- Latest compiled and minified CSS -->
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                    <!-- jQuery library -->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
                    <!-- Latest compiled JavaScript -->
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                    <style>
                        .select1{ display: none;}
                        .form-err-msg{ color: red;}
                        .cont-mar{ margin-top: 50px; margin-bottom: 20px; }
                        .cont-padd { padding-top: 15px; padding-bottom: 5px; }
                        .bg-4 { background-color: #222; color: #9d9d9d; }
                        .minh { min-height: 590px; }
                        /* .bg-1 { background-color: #fff; } */
                    </style>
                </head>
                <body>
            <?php
    }
    
    protected function body($data) {
        ?>
        
        <div class="container cont-mar minh">
        <h2>VOIP access</h2>
        
        </div>
        <?php        
    }
    
    protected function heel() {
        ?>
        <footer id="patka">
            <!-- <div class="patka" id="patka"> -->
            <div class="container-fluid bg-4 cont-padd">
                <div class="container">
                    <p>&copy 2017 - Petr Šauer - <a href="mailto:petr.strelec@email.cz">Admin kontakt</a></p>
                </div>    
            </div>
        </footer>
        <!-- </div> -->        
        </body>
        </html>
        <?php
    }
    
    public function show($data) {
        $this->header($data);
        $this->body($data);
        $this->heel();
    }
    
    public function showArray($data) {
        foreach ($data as $d) {
                echo($d."\n");
        }
    }
    
}
