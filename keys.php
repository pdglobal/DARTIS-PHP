<?php class keys{
    public function generate() {
        $sb = "";
        $size = 9999;
        for ($i=0 ; $i <= $size; $i++) {
            for ($a=0 ; $a <= 9; $a++) {
                for ($j=0 ; $j <= 8; $j++) {
                    $sb .= ($this->random_float()*100).",";
                }
                if ($a == 8) {
                    $sb .= ($this->random_float()*100)."/";
                } else {
                    $sb .= ($this->random_float()*100).";";
                }
            }
        }
    $ret = $sb;
    return $ret;
    
}

    public function random_float($min = 0, $max = 1, $includeMax = false) {
        return $min + \mt_rand(0, (\mt_getrandmax() - ($includeMax ? 0 : 1))) / \mt_getrandmax() * ($max - $min);
    }
}
?>