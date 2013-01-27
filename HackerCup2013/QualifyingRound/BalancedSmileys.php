<?php

/**
 * @param string $line
 * @return array
 */
function tokenize($line)
{
    $tokens = [];
    $length = strlen($line);
    for ($i = 0; $i < $length; ++$i) {
        if ($line[$i] === '('){
            $tokens[] =  ($i > 0 && $line[$i-1] === ':')? 'o':'(';
        } elseif ($line[$i] === ')') {
            $tokens[] =  ($i > 0 && $line[$i-1] === ':')? 'c':')';
        }
    }

    return $tokens;
}

/**
 * @param string $originalLine
 * @return bool
 * @throws Exception
 */
function isBalanced($originalLine)
{
    $line = tokenize($originalLine);
    $open = 0;
    $openS = 0;
    $closeS = 0;
    foreach ($line as $elem) {
           if ('(' === $elem) {
            ++$open;
        } elseif ('o' === $elem) {
            ++$openS;
        } elseif (')' === $elem) {
            if (0 === $open) {
                if ($openS > 0) {
                    --$openS;
                    if (0 === $openS) {
                        $closeS = 0;
                    }
                } else {
                    return false;
                }
            } else {
                --$open;
            }
        } elseif ('c' === $elem) {
            if ($open > $closeS) {
                ++$closeS;
            }
        } else {
            throw new Exception("Tokenize process went bad");
        }
    }

    return $open <= $closeS;
}

$lines = file('php://stdin');

for ($number = 1; $number <= $lines[0]; ++$number) {
    $line = $lines[$number];
    echo 'Case #' . $number . ': ' . ((isBalanced($line))?'YES':'NO') . PHP_EOL;

}

