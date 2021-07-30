<?php

/** 
 * Generátor náhodého řetězce znaků.
 *
 * Modul bez pevných vazeb na další moduly (třídy)
 * 
 * 
 * @author Petr Šauer
 */
class CodeGenerator {
    
    protected $num = "0123456789";
    protected $cap_lett = "ABCDEFGHIJKLMNPQRSTUVWXYZ";
    protected $low_lett = "abcdefghijkmnopqrstuvwxyz";
 
    /**
     * Vrací náhodný řetězec znaků požadované délky a typu 
     * @param number $length Délka řetězce
     * @param string $type Typ znaků
     * @return string Řetězec znaků
     */
    public function randomCode($length, $type = 'ncl') {
        $str = "";
        $chars = $this->setChars($type);
        for($i=0; $i<$length; $i++) {
            $pos = rand(0, mb_strlen($chars)-1);
            $str .= $chars[$pos]; 
        }
        return $str;
    }
    
    /**
     * Zahešuje řetězec
     * @param string $str Řetězec pro zahešování
     * @return string Zahešovaný řetezec
     */
    public function hashCode($str) {
        return hash('sha1', $str);
    }
    
    /**
     * Sestaví základní posloupný řetězec znaků dle vybraných typů
     * @param string $type Typy znaků 
     * @return string Základní řetězec
     */
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
    /**
     * Odstraní znaky O a l z řetězce,
     * zabrání se tím záměně s číslicemy 0 a 1  
     * @param string $text Vstupní řetězec
     * @return string
     */
    protected function replaceOl($text) {
        $Ol = array("O","l");
        return str_replace($Ol,"",$text);
    }
    
    /**
     * Generuje náhodný řetězec znaků vhodných jako heslo
     * @param number $len Délka řetězce
     * @return string
     */
    public function generatePassword($len) {
        return $this->randomCode($len);
    }
    
    /**
     * Generuje náhodný řetězec znaků vhodných jako uživatelské jméno
     * @param number $low_char Délka části řetězce z malých písmen
     * @param number $num Délka části řetězce z čísel
     * @return string
     */
    public function generateUserName($low_char,$num) {
        return $this->randomCode($low_char, 'l').$this->randomCode($num, 'n');
    }
}
