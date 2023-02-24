<?php
class time
{
    public function getTimestamp($length, $count)
    {
		$mttmp = (float) number_format(str_replace(" ", "",microtime()), 20, '.', '');;
        $micro = $mttmp*pow(10, strlen((string)$mttmp));
        if (substr($micro, 0, 1) == "-") {
            $micro = strrev(abs($micro)); // I know this isn't anywhere near an optimal solution, looking for any suggestions on a better way to handle this
        }
        return str_split(str_replace(",", "", str_replace(".", "", number_format($micro + $count))), strlen($length));
    }
}
?>
