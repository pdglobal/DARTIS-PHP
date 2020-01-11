<?php
namespace pdglobal\dartis;

class construct
{

    public function hologram($blueprint)
    {
        $baseArray = explode(";", $blueprint);
        $cluster[0][0] = "";
        for ($i = 0; $i <= count($baseArray) - 1; $i ++) {
            $temp = explode(",", $baseArray[$i]);
            for ($n = 0; $n <= count($temp) - 1; $n ++) {
                $cluster[$i][$n] = $temp[$n];
            }
        }
        return $cluster;
    }

    public function load($key)
    {
        $kfb = explode("/", $key);
        return $kfb;
    }
}
?>