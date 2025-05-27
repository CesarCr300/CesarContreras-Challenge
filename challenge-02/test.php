<?php

require 'index.php';

function assertEqual($expected, $actual, $message)
{
    if ($expected === $actual) {
        print_r("PASS: $message\n");
    } else {
        print_r("FAIL: $message\n" +
            "Expected: " . var_export($expected, true) . "\n"
            . "Got: " . var_export($actual, true) . "\n");
    }
}

$firstExample = noIterate(["ahffaksfajeeubsne", "jefaa"]);
assertEqual('aksfaje', $firstExample, "Test case 1: should return 'aksfaje'");

$secondExample = noIterate(["aaffhkksemckelloe", "fhea"]);
assertEqual('affhkkse', $secondExample, "Test case 2: should return 'affhkkse'");