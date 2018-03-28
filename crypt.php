<?php 
include_once 'construct.php';
include_once 'strings.php';
class crypt {
    public function inject($data, $key){
        $construct_ob = new construct;
        $strings = new strings;
        $temp = str_split($data,1);
        $insert = array(array());
        $n = 0; 
        $l = 0;
        for ($i = 0; $i<= count($temp)-1; $i++) {
            $insert[$l][$n] = $strings->ordutf8($temp[$i]);
            $n += 1;
            if($n > 9) {$n = 0;  $l += 1;}
        }
        while($n < 10) {$insert[$l][$n] = 1;$n += 1; }
        $matrix_ob = new matrixMath;
        $time_ob = new time;
        $timestamp = $time_ob->getTimestamp(count($key)-2);
        $result =$matrix_ob->mult($insert, $construct_ob->hologram($key[ltrim($timestamp[0], "0")]));
        $id = ltrim($timestamp[0], "0").";";
        for ($i=1; $i <= count($timestamp)-1 ; $i++) {
            if ($timestamp[$i] == 0 || $timestamp[$i] == "0") { $timestamp[$i] = 1;}
            $id .= ltrim($timestamp[$i], "0").";";
            $result = $matrix_ob->mult($result, $construct_ob->hologram($key[ltrim($timestamp[$i], "0")]));
            
        }
        $ret = $strings->array2str($result)."~".$id;
        $verify = $this->extract($ret, $key);
        while ($verify != $data) {
            $timestamp = $time_ob->getTimestamp(count($key)-2);
            $result =$matrix_ob->mult($insert, $construct_ob->hologram($key[ltrim($timestamp[0], "0")]));
            $id = ltrim($timestamp[0], "0").";";
            for ($i=1; $i <= count($timestamp)-1 ; $i++) {
                if ($timestamp[$i] == 0 || $timestamp[$i] == "0") { $timestamp[$i] = 1;}
                $id .= ltrim($timestamp[$i], "0").";";
                $result = $matrix_ob->mult($result, $construct_ob->hologram($key[ltrim($timestamp[$i], "0")]));
                
            }
            $ret = $strings->array2str($result)."~".$id;
            $verify = $this->extract($ret, $key);
        }
        return $ret;
    }
    public function extract($data, $key) {
    $properties = explode("~", $data);
    $construct_ob = new construct;
    $strings = new strings;
    $film = $construct_ob->hologram($properties[0]);
    $indexList = explode(";", $properties[1]);
    $matrix_ob = new matrixMath;
    for ($i=1;$i<=count($indexList)-1;$i++) {
        $film = $matrix_ob->mult($film, $matrix_ob->invert($construct_ob->hologram($key[$indexList[(count($indexList)-1-$i)]])));
    }
    $flat = $strings->array2str($film);
    $line = explode(",", str_replace(";", ",", $flat));
    $ascii = "";
    for($i = 0;$i<=count($line)-1;$i++) {
        $chrvalue = round($line[$i]);
        if ($chrvalue > 1.1 &&  $chrvalue < 500000) {
            $chr = $chrvalue;
            $ascii .= chr($chr);
        }
    }
    return $ascii;
    }
}
?>