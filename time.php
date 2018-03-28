<?php 
class time {
    public function getTimestamp($length) {
        $now1 = date("Z");
        $now2 = date("Y");
        $now3 = date("is");
        $now4 = date("H");
        $datetime = $now1+$now2+$now3+$now4;
        $micro = explode(".", microtime());
        $micro = explode(" ", $micro[1]);
        return str_split(trim($datetime.$micro[0], "00").$micro[1], strlen($length)); 
        //no support for retreiving the era in php
    }
}
?>