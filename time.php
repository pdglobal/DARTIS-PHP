<?php

class time
{

    public function getTimestamp($length)
    {
        $now1 = date("Z");
        $now2 = date("Y");
        $now3 = date("is");
        $now4 = date("H");
        $micro = str_replace(" ", "", number_format((microtime() + 11644477200) * 10000000, 0, '.', ''));
        $datetime = (((($now1 + $now2) * 100.0) * (($now3 . $now4) * 100.0) * $micro) * 100.0);
        
        return str_split(abs(trim(str_replace(".", "", str_replace(",", "", number_format(trim($datetime, "00") / rand(), 5))), "00")), strlen($length));
        // no support for retreiving the era in php
    }
}
?>