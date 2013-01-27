<?php

function getBeauty($word)
{
    $frequences = array();
    for ($i = 0; $i < strlen($word); ++$i) {
        $letter = $word[$i];
        if (ctype_alpha($letter)) {
            if (isset($frequences[$letter])) $frequences[$letter]++;
            else $frequences[$letter] = 1;
        }
    }

    arsort($frequences);
    $sum = 0;
    $value = 26;
    foreach ($frequences as $frequence) {
        $sum += $value * $frequence;
        --$value;
    }
    return $sum;
}

function getMaxBeauty($line)
{
    $line = strtolower($line);

    $words = explode(' ', $line);

    $maxBeauty = 0;
    foreach ($words as $word) {
        $maxBeauty = max($maxBeauty, getBeauty($word));
    }
    return $maxBeauty;
}

$lines = file('php://stdin');

unset($lines[0]);

foreach ($lines as $number => $line) {
    echo 'Case #' . $number . ': ' . getBeauty(strtolower($line)) . PHP_EOL;
}

