<?php

class intHeap extends SplHeap {
    function compare($a, $b)
    {
        if ($a < $b) return 1;
        elseif ($a > $b) return -1;
        return 0;
    }
}


/**
 * @param int $k
 * @param int $a
 * @param int $b
 * @param int $c
 * @param int $r
 * @return array
 */
function getM($k, $a, $b, $c, $r)
{
    $mKeys = array($a => 1);
    $mValues = array(0 => $a);
    for ($i = 1; $i < $k; ++$i) {
        $value = ($b * $mValues[$i - 1] + $c) % $r;
        $mValues[] = $value;
        if (isset($mKeys[$value])) {
            ++$mKeys[$value];
        } else {
            $mKeys[$value] = 1;
        }
    }

    return array(
        'keys' => $mKeys,
        'values' => $mValues,
    );
}

/**
 * @param array $m
 * @param int $pos
 * @param int $k
 * @return int
 */
function getPosNOfArray(array $m, $pos, $k)
{
    $naturals = range(0, $k);

    $available = array_diff($naturals, $m['values']);

    $heap = new intHeap();
    foreach ($available as $elem) {
        $heap->insert($elem);
    }

    for ($i = 0; $i <= $pos; ++$i) {
        $last = $heap->extract();

        $first = $m['values'][$i];

        if (1 === $m['keys'][$first]) {
            $heap->insert($first);
        } else {
            --$m['keys'][$first];
        }
    }
    
    return $last;
}

function getNthElem($k, $n, $a, $b, $c, $r)
{
    $m = getM($k, $a, $b, $c, $r);

    $pos = ($n - $k - 1)%($k + 1);

    return getPosNOfArray($m, $pos, $k);
}

$lines = file('php://stdin');

for ($i = 1; $i/2 <= $lines[0]; $i += 2) {
    $line1 = explode(' ', $lines[$i]);
    $n = (int) $line1[0];
    $k = (int) $line1[1];

    $line2 = explode(' ', $lines[$i + 1]);
    $a = (int) $line2[0];
    $b = (int) $line2[1];
    $c = (int) $line2[2];
    $r = (int) $line2[3];

    echo 'Case #' . floor($i/2+1) . ': ' . getNthElem($k, $n, $a, $b, $c, $r) . PHP_EOL;
}
