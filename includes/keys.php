<?php
namespace pdglobal\dartis;
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
                    $sb .= ($math->random_float() * 100) . ",";
                }
                if ($a == 8) {
                    $sb .= ($math->random_float() * 100) . "/";
                } else {
                    $sb .= ($math->random_float() * 100) . ";";
                }
            }
        }
        $ret = $sb;
        return $ret;
    }
}
?>