<?php
session_start();
mb_internal_encoding("UTF-8");

function autoloadFunction($class)
{
    if (preg_match('/Ctr$/', $class))	
        require("controller/" . $class . ".php");
    elseif (preg_match('/Ws$/', $class)) {
        require("view/" . $class . ".php");
    }
    else
        require("module/" . $class . ".php");
}
spl_autoload_register("autoloadFunction");
// nastaveni lokalnich parametru a pripojeni databaze
//$local = new Location();
//$local->setDb();
// smerovani url
$router = new RouterCtr();
$router->process($_SERVER['REQUEST_URI']);
