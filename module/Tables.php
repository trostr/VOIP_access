<?php

/**
 * Nástroj pro tvorbu jednoduchých tabulek 
 * 
 * Modul bez pevných vazeb na další moduly (třídy)
 *
 * 
 * @author Petr Šauer
 */
class Tables {
    
    
    /**
     * Sestaví první řádek HTML elementu Table.
     * @param array $class Pole CCS tříd
     * @return string HTML řádek
     */
    protected function buildStartLine($class) {
        $str = '<table ';
        if($class) { $str .= 'class="'. implode(' ', $class).'" '; }
        $str .= '>';
        return $str;
    }
    
    
    protected function buildRow($data) {
        foreach ($data as $value) {
            $arr[] = '<td>'.$value.'</td>';
        }
        return $arr;
    }
    
    protected function buildContent($data) {
        $arr[] = '<tbody>';
        foreach ($data as $value) {
            $arr[] = '<tr>';
            $arr = array_merge($arr, $this->buildRow($value));
            $arr[] = '</tr>';
        }
        $arr[] = '</tbody>';
        return $arr;
    }
    
    protected function buildThead($thead) {
        $arr[] = '<thead>';
        $arr[] = '<tr>';
        foreach ($thead as $value) {
            $arr[] = '<th>'.$value.'</th>';
        }
        $arr[] = '</tr>';
        $arr[] = '</thead>';
        return $arr;
    }
    
    protected function buildEndLine() {
        return $str = '</table>';
    }
    
    public function buildEntireTable($class, $thead, $data) {
        $arr[] = $this->buildStartLine($class);
        $arr = array_merge($arr, $this->buildThead($thead));
        $arr = array_merge($arr, $this->buildContent($data));
        $arr[] = $this->buildEndLine();
        return $arr;
    }
    
    /**
     * Vypíše celou tabulku po řádcích v HTML formátu.
     * @param array $data Pole elementů tabulky
     */
    public function showTable($data) {
        foreach ($data as $d) {
            echo($d."\n");
        }
    }
}
