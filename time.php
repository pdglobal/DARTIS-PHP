<?php

class time
{

    public function getTimestamp($length)
    {
        $now1 = date("Z");
        $now2 = date("Y");
        $now3 = date("is");
        $now4 = date("H");
        $datetime = $now1 + $now2 * $now3 * $now4;
        $micro = str_replace(" ", "", number_format((microtime() + 11644477200) * 10000000, 0, '.', ''));
        return str_split(trim(str_replace(".", "", str_replace(",", "", number_format((trim($micro, "00") * trim($datetime, "00")) / rand(), 5))), "00"), strlen($length));
        // no support for retreiving the era in php
    }
}
?>