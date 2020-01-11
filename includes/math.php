<?php
include_once '../namespace.php';
class matrixMath
{

    public function mult($a, $b)
    {
        $r = count($a);
        $c = count($b[0]);
        $p = count($b);
        if (count($a[0]) != $p) {
            echo "Incompatible matrices";
            exit(0);
        }
        $result = array(
            array()
        );
        for ($i = 0; $i < $r; $i ++) {
            for ($j = 0; $j < $c; $j ++) {
                $result[$i][$j] = 0;
                for ($k = 0; $k < $p; $k ++) {
                    $result[$i][$j] += $a[$i][$k] * $b[$k][$j];
                }
            }
        }
        return $result;
    }

    public function invert($A, $debug = FALSE)
    {
        // / @todo check rows = columns
        $n = count($A);
        // get and append identity matrix
        $I = $this->identity_matrix($n);
        for ($i = 0; $i < $n; ++ $i) {
            $A[$i] = array_merge($A[$i], $I[$i]);
        }
        if ($debug) {
            echo "\nStarting matrix: ";
            $this->print_matrix($A);
        }
        // forward run
        for ($j = 0; $j < $n - 1; ++ $j) {
            // for all remaining rows (diagonally)
            for ($i = $j + 1; $i < $n; ++ $i) {
                // if the value is not already 0
                if ($A[$i][$j] !== 0) {
                    // adjust scale to pivot row
                    // subtract pivot row from current
                    $scalar = $A[$j][$j] / $A[$i][$j];
                    for ($jj = $j; $jj < $n * 2; ++ $jj) {
                        $A[$i][$jj] *= $scalar;
                        $A[$i][$jj] -= $A[$j][$jj];
                    }
                }
            }
            if ($debug) {
                echo "\nForward iteration $j: ";
                $this->print_matrix($A);
            }
        }
        // reverse run
        for ($j = $n - 1; $j > 0; -- $j) {
            for ($i = $j - 1; $i >= 0; -- $i) {
                if ($A[$i][$j] !== 0) {
                    $scalar = $A[$j][$j] / $A[$i][$j];
                    for ($jj = $i; $jj < $n * 2; ++ $jj) {
                        $A[$i][$jj] *= $scalar;
                        $A[$i][$jj] -= $A[$j][$jj];
                    }
                }
            }
            if ($debug) {
                echo "\nReverse iteration $j: ";
                $this->print_matrix($A);
            }
        }
        // last run to make all diagonal 1s
        // / @note this can be done in last iteration (i.e. reverse run) too!
        for ($j = 0; $j < $n; ++ $j) {
            if ($A[$j][$j] !== 1) {
                $scalar = 1 / $A[$j][$j];
                for ($jj = $j; $jj < $n * 2; ++ $jj) {
                    $A[$j][$jj] *= $scalar;
                }
            }
            if ($debug) {
                echo "\n1-out iteration $j: ";
                $this->print_matrix($A);
            }
        }
        // take out the matrix inverse to return
        $Inv = array();
        for ($i = 0; $i < $n; ++ $i) {
            $Inv[$i] = array_slice($A[$i], $n);
        }
        return $Inv;
    }

    /**
     * Prints matrix
     *
     * @param array $A
     *            matrix
     * @param integer $decimals
     *            number of decimals
     */
    public function print_matrix($A, $decimals = 6)
    {
        foreach ($A as $row) {
            echo "\n\t[";
            foreach ($row as $i) {
                echo "\t" . sprintf("%01.{$decimals}f", round($i, $decimals));
            }
            echo "\t]";
        }
    }

    /**
     * Produces an identity matrix of given size
     *
     * @param integer $n
     *            size of identity matrix
     *            
     * @return array identity matrix
     */
    public function identity_matrix($n)
    {
        $I = array();
        for ($i = 0; $i < $n; ++ $i) {
            for ($j = 0; $j < $n; ++ $j) {
                $I[$i][$j] = ($i == $j) ? 1 : 0;
            }
        }
        return $I;
    }
}

class math
{

    public function random_float($min = 0, $max = 1, $includeMax = false)
    {
        return $min + \mt_rand(0, (\mt_getrandmax() - ($includeMax ? 0 : 1))) / \mt_getrandmax() * ($max - $min);
    }
}
?>