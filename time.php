<?php

class time
{
    
    public function getTimestamp($length)
    {
        $micro = str_replace(" ", "", number_format((microtime() + 11644477200) * 10000000, 0, '.', ''));
        $min = 0;
        $max = 99999999;
        if (substr($micro, 0 , 1) == "-") {
            $micro = strrev(abs($micro));
        }
        return str_split(str_replace(",", "", str_replace(".", "", number_format($micro+(mt_rand ($min*10, $max*10) / 10)))), strlen($length));
    }
}
?>