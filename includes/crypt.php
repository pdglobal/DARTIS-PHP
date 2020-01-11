<?php
namespace pdglobal\dartis;

include_once 'construct.php';
include_once 'strings.php';

class crypt
{

    /*
     * NOTICE: As a result of the way computers measure time, it is nessecary to pass a value to the crypt function in order to generate a uniqnue
     * timestamp for every possible measurment. It is reccomended that if you operate this function in a loop, that you define a value somewhere
     * on the computer/server and increment that value each time you encrypt data, then pass the value to the crypt function as the 3rd value.
     * You can reset the number back to 0 every 250 ms so that it doesn't grow unreasonably large, or you can just reset it after it has reached
     * a value of at least 1000
     */
    public function inject($data, $key, $binary = 1, $count = 0)
    {
        if ($count == 0) {
            $count = (mt_rand(1111111 * 10, 9999999 * 10) / 10);
        }
        $construct_ob = new construct();
        $strings = new strings();
        $temp = $strings->str_split_unicode($data, 1);
        $tempbin = $data;
        $insert = array(
            array()
        );
        $n = 0;
        $l = 0;
        if ($binary == 0) {
            for ($i = 0; $i <= count($temp) - 1; $i ++) {
            $insert[$l][$n] = mb_ord($temp[$i], "UTF-8");
            $n += 1;
            if ($n > 9) {
                $n = 0;
                $l += 1;
            }
            }
        } else {
            for ($i = 1; $i <= count($tempbin); $i ++) {
                $insert[$l][$n] = $tempbin[$i];
            $n += 1;
            if ($n > 9) {
                $n = 0;
                $l += 1;
            }
            }
              
        }
        while ($n < 10) {
            $insert[$l][$n] = 1337997331;
            $n += 1;
        }
        $matrix_ob = new matrixMath();
        $time_ob = new time();
        $timestamp = $time_ob->getTimestamp(count($key) - 2, $count);
        $result = $matrix_ob->mult($insert, $construct_ob->hologram($key[ltrim($timestamp[0], "0")]));
        $id = ltrim($timestamp[0], "0") . ";";
        for ($i = 1; $i <= count($timestamp) - 1; $i ++) {
            if ($timestamp[$i] == 0 || $timestamp[$i] == "0") {
                $timestamp[$i] = 1;
            }
            $id .= ltrim($timestamp[$i], "0") . ";";
            $result = $matrix_ob->mult($result, $construct_ob->hologram($key[ltrim($timestamp[$i], "0")]));
        }
        $ret = $strings->array2str($result) . "~" . $id;
        $verify = $this->extract($ret, $key, $binary);
        while (($verify == $data) === FALSE) {
            $count += 1;
            $timestamp = $time_ob->getTimestamp(count($key) - 2, $count);
            $result = $matrix_ob->mult($insert, $construct_ob->hologram($key[ltrim($timestamp[0], "0")]));
            $id = ltrim($timestamp[0], "0") . ";";
            for ($i = 1; $i <= count($timestamp) - 1; $i ++) {
                if ($timestamp[$i] == 0 || $timestamp[$i] == "0") {
                    $timestamp[$i] = 1;
                }
                $id .= ltrim($timestamp[$i], "0") . ";";
                $result = $matrix_ob->mult($result, $construct_ob->hologram($key[ltrim($timestamp[$i], "0")]));
            }
            $ret = $strings->array2str($result) . "~" . $id;
            $verify = $this->extract($ret, $key, $binary);
        }
        return $ret;
    }

    public function extract($data, $key, $binary = 1)
    {
        $properties = explode("~", $data);
        if (count($properties) < 2) {
            return "Malformated encryption string!";
        }
        $construct_ob = new construct();
        $strings = new strings();
        $film = $construct_ob->hologram($properties[0]);
        $indexList = explode(";", $properties[1]);
        $matrix_ob = new matrixMath();
        for ($i = 1; $i <= count($indexList) - 1; $i ++) {
            $film = $matrix_ob->mult($film, $matrix_ob->invert($construct_ob->hologram($key[$indexList[(count($indexList) - 1 - $i)]])));
        }
        $flat = $strings->array2str($film);
        $line = array_filter(explode(",", str_replace(";", ",", $flat)));
        if ($binary == 1) {
            $ret = array();
            for ($i = 0; $i <= count($line) - 1; $i ++) {
                $chrvalue = round($line[$i]);
                if ($chrvalue == 1337997331 || $chrvalue == -0) {
                    break;
                }
                    $ret[$i+1] .= $chrvalue;
            }
        } else {
            for ($i = 0; $i <= count($line) - 1; $i ++) {
                $chrvalue = round($line[$i]);
                    if ($chrvalue > 1.1 && $chrvalue < 500000) {
                        $chr = $chrvalue;
                        $ret .= mb_chr($chr, "UTF-8");
                    }
            }
        }
        return $ret;
    }
}
?>