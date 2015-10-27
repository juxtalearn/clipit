<?php

/**
 * Created by PhpStorm.
 * User: cs
 * Date: 06.08.15
 * Time: 12:18
 */
class LevenshteinCalculation
{

    public static function levArray($sa,$ta, $rep, $ins, $del) {
        $replace = $rep;
        $insert = $ins;
        $delete = $del;

        $m = count ($sa);
        $n = count ($ta);
        $d = array();
        if  ($delete >= $insert) {
            for ($i=0;$i<=$m;$i++) $d[$i][0]=$i;
            for ($j=0;$j<=$n;$j++) $d[0][$j]=$j;
        } else {
            for ($i=0;$i<=$m;$i++) $d[$i][0]=$i;
            for ($j=0;$j<=$n;$j++) $d[0][$j]=$j;
        }
        for ($i=1; $i<=$m;$i++) {
            for($j=1;$j<=$n;$j++) {
                if  ($sa[$i-1] == $ta[$j-1]) {
                    $c=0;
                } else {
                    $c=$replace;
                }
                $d[$i][$j] = min(array($d[$i-1][$j]+$insert,$d[$i][$j-1]+$delete,$d[$i-1][$j-1]+$c));
            }
        }
        return $d[$m][$n]/max($m,$n);
    }

}