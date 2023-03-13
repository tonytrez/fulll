<?php

$numbers = range(0, 100);

foreach ($numbers as $number) {
    if ($number === 0) {
        continue;
    }
    $result = '';
    if ($number % 3 !== 0 && $number % 5 !== 0) {
        $result = $number;
    } else {
        if ($number % 3 === 0) {
            $result .= 'Fizz';
        }
        if ($number % 5 === 0) {
            $result .= 'Buzz';
        }
    }
    echo $result.PHP_EOL;
}