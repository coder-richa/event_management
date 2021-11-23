<?php
// Class to present HTML element attribute to generate JSON
class Attribute{
    var $name,$value;
    function __construct($name, $value) {
        $this->name = $name;
        $this->value = $value;
    }

    function getName() {
        return $this->name;
    }

    function getValue() {
        return $this->value;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setValue($value) {
        $this->value = $value;
    }


}
