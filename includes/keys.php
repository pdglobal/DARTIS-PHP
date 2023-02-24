<?php
include_once 'math.php';

class keys
{

    public function generate()
    {
        $math = new math();
        $sb = "";
        $size = 9999;
        for ($i = 0; $i <= $size; $i ++) {
            for ($a = 0; $a <= 9; $a ++) {
                for ($j = 0; $j <= 8; $j ++) {
                    $mf = $math->random_float();
                    $sb .= ($mf * pow(10, strlen((string)$mf))) . ",";
                }
                if ($a == 8) {
                    $mf = $math->random_float();
                    $sb .= ($mf *  pow(10, strlen((string)$mf))) . "/";
                } else {
                    $mf = $math->random_float();
                    $sb .= ($mf *  pow(10, strlen((string)$mf))) . ";";
                }
            }
        }
        $ret = $sb;
        return $ret;
    }
}
?>
