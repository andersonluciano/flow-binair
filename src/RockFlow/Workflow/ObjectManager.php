<?php

namespace RockFlow\Workflow;

/**
 * Description of ObjectManager
 *
 * @author anderson
 */
class ObjectManager {

    private $path;
    private $objectPath;
    private $method;

    public function __construct($path) {
        $this->path = $path;

        return $this;
    }

    public function prepare() {

        $pathExplode = explode("->", $this->path);

        if (count($pathExplode) > 2) {
            throw new \Exception("Can use only one method by object (" . $this->path . ")");
        }

        $this->objectPath = $pathExplode[0];
        $this->method = $pathExplode[1];

        return $this;
    }

    public function process() {
        if (class_exists($this->objectPath)) {
            $objectHandler = new $this->objectPath();
            $method = $this->method;
            $response = $objectHandler->$method();
            return $response;
        } else {
            throw new \Exception("Classe " . $this->objectPath . " não existe");
        }
    }
}
