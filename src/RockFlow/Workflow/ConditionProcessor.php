<?php

namespace RockFlow\Workflow;

/**
 * Description of ConditionProcessor
 *
 * @author anderson
 */
class ConditionProcessor {

    private $condition;
    private $preProcessed;
    private $stack = 0;
    private $result;
    private $nextResult;
    private $operator;

    public function __construct($condition) {
        $this->condition = $condition;

        return $this;
    }

    public function prepare() {
        $conditionsExplode = explode(" ", $this->condition);
        $this->preProcessed = $conditionsExplode;

        return $this;
    }

    /**
     * 
     * @return Bool
     * @throws \Exception
     */
    public function process() {
        $group = "";

        $generalString = "";
        $closeParenthesis = "";
        $parenthesisControl = 0;

        foreach ($this->preProcessed as $process) {
            for ($i = 0; $i < strlen($process); $i++) {
                $letter = $process[$i];

                if ($letter == "&" && $process[$i + 1] == "&") {
                    $this->operator = "&&";
                    $generalString .= " & ";
                    $i++;
                    continue;
                }
                if ($letter == "|" && $process[$i + 1] == "|") {
                    $this->operator = "||";
                    $generalString .= " | ";
                    $i++;
                    continue;
                }

                if ($letter == "(") {
                    $generalString .= "(";
                    $parenthesisControl += 1;
                } elseif ($letter == ")") {
                    $closeParenthesis = ")";
                    $parenthesisControl -= 1;
                } else {
                    $group .= $letter;
                }
            }

            if ($group != "") {                
                $preResponse = $this->processObject($group);
                if ($preResponse == false) {
                    $generalString .= " " . 0 . " ";
                } else {
                    $generalString .= " " . 1 . " ";
                }

                $generalString .= $closeParenthesis;
                $closeParenthesis = "";


                $group = "";
            }
        }
        echo "--> " . $generalString . " = ";
        if ($parenthesisControl == 0) {
            $generalString = "\$val = $generalString;";
            eval($generalString);
        } else {
            throw new \Exception("Parenthesis in excess");
        }
        echo $val . "\n";
        return $val;
    }

    public function processObject($path) {
        $objectManager = new ObjectManager($path);
        $response = $objectManager->prepare()->process();

        return $response;
    }

}
