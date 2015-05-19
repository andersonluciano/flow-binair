<?php

require 'vendor/autoload.php';


echo "<pre>";


$stepsArray = array(
    "01" => array(
        "01.01" => "((RockFlow\Workflow\Rules\TrueFalseVerify->verifyTwo || RockFlow\Workflow\Rules\TrueFalseVerify->verifyOne) "
        . "&& (RockFlow\Workflow\Rules\TrueFalseVerify->verifyTwo || RockFlow\Workflow\Rules\TrueFalseVerify->verifyOne) "
        . "&& RockFlow\Workflow\Rules\TrueFalseVerify->verifyTwo)",
        "01.02" => "RockFlow\Workflow\Rules\TrueFalseVerify->verifyTwo",
    ),
    "01.01" => array(
        "01.02" => "RockFlow\Workflow\Rules\TrueFalseVerify->verifyTwo",
    ),
    "01.02" => array(
        "02" => "RockFlow\Workflow\Rules\TrueFalseVerify->verifyTwo && RockFlow\Workflow\Rules\TrueFalseVerify->verifyThree"
    ),
    "02" => array(
        "02.01" => "RockFlow\Workflow\Rules\TrueFalseVerify->verifyOne || RockFlow\Workflow\Rules\TrueFalseVerify->verifyThree",
        "02.02",
    ),
    "02.01" => array(
        "02.02" => "RockFlow\Workflow\Rules\TrueFalseVerify->verifyTwo || RockFlow\Workflow\Rules\TrueFalseVerify->verifyOne",
    ),
    "02.02" => array(
        "02.03"
    ),
    "02.03"
);

$token = "01";

$steps = new \RockFlow\Workflow\Steps($stepsArray);

$walk = new \RockFlow\Workflow\Walk($token, $steps);
try {

    echo $token . "\n";
    $token = $walk->advanceTo('01.01');
    echo $token . "\n";
    $token = $walk->advanceTo('01.02');
    echo $token . "\n";
    $token = $walk->advanceTo('02');
    echo $token . "\n";
    $token = $walk->advanceTo('02.01');
    echo $token . "\n";
    $token = $walk->advanceTo('02.02');
    echo $token . "\n";
    $token = $walk->advanceTo('02.03');
    echo $token . "\n";
} catch (\Exception $ex) {
    echo $ex->getMessage()."\n";
    exit;
}
