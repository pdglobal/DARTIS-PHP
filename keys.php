<?php class keys{
    public function generate() {
        $sb = "";
        $size = 9999;
        for ($i=0 ; $i <= $size; $i++) {
            for ($a=0 ; $a <= 9; $a++) {
                for ($j=0 ; $j <= 8; $j++) {
                    $sb .= ((mt_rand() / mt_getrandmax())*10).",";
                }
                if ($a == 8) {
                    $sb .= ((mt_rand() / mt_getrandmax())*10)."/";
                } else {
                    $sb .= ((mt_rand() / mt_getrandmax())*10).";";
                }
            }
        }
    $ret = $sb;
    return $ret;
    
}
}
?>