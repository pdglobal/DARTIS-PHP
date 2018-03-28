<?php 
class strings{
    public function array2str($array) {
        $tmpArr = array();
        foreach ($array as $sub) {
            $tmpArr[] = implode(',', $sub);
        }
        $result = implode(';', $tmpArr);
        return $result;
    }
}
?>