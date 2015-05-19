<?php

namespace RockFlow\Workflow;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Walk
 *
 * @author anderson
 */
class Walk {

    public $token;

    /**
     *
     * @var Steps 
     */
    public $steps;

    public function __construct($token, Steps $steps) {
        $this->steps = $steps;
        $this->token = $token;
    }

    public function advanceTo($requestStep) {
        try {
            if ($requestStep == $this->token) {
                throw new \Exception("Can't advance to same step");
            }
            $canAdvanceTo = $this->steps->getStep($this->token);

            if (in_array($requestStep, $canAdvanceTo)) {
                $this->token = $requestStep;
                return $requestStep;
            } elseif (array_key_exists($requestStep, $canAdvanceTo)) {
                $conditionProcessor = new ConditionProcessor($canAdvanceTo[$requestStep]);

                if ($conditionProcessor->prepare()->process()) {
                    $this->token = $requestStep;
                    return $requestStep;
                }
                throw new \Exception("Can't go to this step");
            } else {
                throw new \Exception("Can't go to this step");
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

}
