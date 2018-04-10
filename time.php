<?php

class time
{

    public function getTimestamp($length)
    {
        $now1 = date("Z");
        $now2 = date("Y");
        $now3 = date("i");
        $now4 = date("H");
        $now5 = date("s");
        $micro = str_replace(" ", "", number_format((microtime() + 11644477200) * 10000000, 0, '.', ''));
        $datetime = (($now1 + $now2) . ($now3 + $now4 + $now5) . $micro) * 100.0;
        
        return str_split(trim(str_replace(".", "", str_replace(",", "", number_format(round(abs($datetime / rand(1.000000,9.999999))), 23))), "00"), strlen($length));
        // no support for retreiving the era in php
    }
}
?>