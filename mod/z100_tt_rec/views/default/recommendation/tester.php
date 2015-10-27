<?php function lev($s,$t) {
    $m = strlen($s);
    $n = strlen($t);

    for($i=0;$i<=$m;$i++) $d[$i][0] = $i;
    for($j=0;$j<=$n;$j++) $d[0][$j] = $j;

    for($i=1;$i<=$m;$i++) {
        for($j=1;$j<=$n;$j++) {
            $c = ($s[$i-1] == $t[$j-1])?0:1;
            $d[$i][$j] = min($d[$i-1][$j]+1,$d[$i][$j-1]+0.1,$d[$i-1][$j-1]+$c);
        }
    }

    return $d[$m][$n];
}



function levArray($sa, $ta, $rep, $ins, $del)
{
    $replace = $rep;
    $insert = $ins;
    $delete = $del;

    $m = count($sa);
    $n = count($ta);
    $d = array();
    if ($delete >= $insert) {
        for ($i = 0; $i <= $m; $i++) $d[$i][0] = $i;
        for ($j = 0; $j <= $n; $j++) $d[0][$j] = $j;

    } else {
        for ($i = 0; $i <= $m; $i++) $d[$i][0] = $i;
        for ($j = 0; $j <= $n; $j++) $d[0][$j] = $j;
    }

    for ($i = 1; $i <= $m; $i++) {
        for ($j = 1; $j <= $n; $j++) {
            if ($sa[$i - 1] == $ta[$j - 1]) {
                $c = 0;
            } else {
                $c = $replace;
            }
            if  ( ($d[$i - 1][$j] + $insert) < ($d[$i][$j - 1] + $delete)) {
                if (($d[$i - 1][$j] + $insert) < ($d[$i - 1][$j - 1] + $c) ) {
                    echo "INSERT\n";
                } else {
                    if ( $c==0){
                        echo "KEEP\n";

                    } else  echo "REPLACE\n";
                }
            } else {
                if (($d[$i][$j - 1] + $delete) < ($d[$i - 1][$j - 1] + $c)) {
                    echo "DELETE\n";
                } else {
                    if ( $c==0){
                        echo "KEEP\n";

                    } else  echo "REPLACE\n";
                }
            }

            $d[$i][$j] = min(array($d[$i - 1][$j] + $insert, $d[$i][$j - 1] + $delete, $d[$i - 1][$j - 1] + $c));
        }
    }

    return $d[$m][$n];
}

//var_dump(lev('abd', 'abc'));
//var_dump(lev('acd', 'abc'));
//var_dump(lev('bcd', 'abc'));


#kosten dasselbe:
//var_dump(levArray(array('a', 'b', 'd'), array('a', 'b', 'c'), 2, 1, 1));
//var_dump(levArray(array('a', 'c', 'd'), array('a', 'b', 'c'), 2, 1, 1));
//var_dump(levArray(array('b', 'c', 'd'), array('a', 'b', 'c'), 2, 1, 1));

//var_dump(levArray(array('b'), array('a', 'b', 'c'), 2, 1, 1));
//var_dump(levArray(array('c'), array('a', 'b', 'c'), 2, 1, 1));
//var_dump(levArray(array('a'), array('a', 'b', 'c'), 2, 1, 1));

//var_dump(levArray(array('x', 'y', 'z', 'a'), array('a', 'b', 'c'), 2, 1, 1));
//var_dump(levArray(array('x', 'y', 'z', 'b'), array('a', 'b', 'c'), 2, 1, 1));
//var_dump(levArray(array('x', 'y', 'z', 'c'), array('a', 'b', 'c'), 2, 1, 1));

var_dump(levArray(array('a', 'y', 'z'), array('a', 'b', 'c'), 2,1,1));echo "\n";
var_dump(levArray(array('b', 'y', 'z'), array('a', 'b', 'c'), 2,1,1));echo "\n";
var_dump(levArray(array('c', 'y', 'z'), array('a', 'b', 'c'), 2,1,1));echo "\n";

echo "\n";echo "\n";echo "\n";echo "\n";echo "\n";
var_dump(levArray(array('a', 'y', 'z'), array('a', 'b', 'c'), 1, 0.5, 0.5));echo "\n";
var_dump(levArray(array('b', 'y', 'z'), array('a', 'b', 'c'), 1, 0.5, 0.5));echo "\n";
var_dump(levArray(array('c', 'y', 'z'), array('a', 'b', 'c'), 1, 0.5, 0.5));echo "\n";




