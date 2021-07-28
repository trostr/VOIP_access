<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CodeGenerator
 *
 * @author Petr
 */
class CodeGenerator {
    
    protected $num = "0123456789";
    protected $cap_lett = "ABCDEFGHIJKLMNPQRSTUVWXYZ";
    protected $low_lett = "abcdefghijkmnopqrstuvwxyz";

    public function randomCode($length, $type = 'ncl') {
        $str = "";
        $chars = $this->setChars($type);
        for($i=0; $i<$length; $i++) {
            $pos = rand(0, mb_strlen($chars)-1);
            $str .= $chars[$pos]; 
        }
        return $str;
    }
    
    public function hashCode($str) {
        return hash('sha1', $str);
    }
    
    public function setChars($type) {
        $chars = "";
        if(strpos($type, 'c') !== false) {
            $chars .= $this->cap_lett;
        }
        if(strpos($type, 'l') !== false) {
            $chars .= $this->low_lett;
        }
        if(strpos($type, 'n') !== false) {
            $chars .= $this->num;
        }
        return $chars;
    }
    
    protected function replaceOl($text) {
        $Ol = array("O","l");
        return str_replace($Ol,"",$text);
    }
    
    public function generatePassword($len) {
        return $this->randomCode($len);
    }
    
    public function generateUserName($low_char,$num) {
        return $this->randomCode($low_char, 'l').$this->randomCode($num, 'n');
    }
}
