<?php

// Class to present HTML element to generate JSON
class Element{

    var $childrenList, $tag, $content, $attributeList;

    public function __construct($tag, $content = "",$attributeList=array()) {
        $this->tag = $tag;
        $this->content = $content;
        $this->childrenList = array();
        $this->attributeList = $attributeList;
        return $this;
    }

    public function addAttribute($attribute) {
        $this->attributeList[] = $attribute;
        return $this;
    }

    public function addChild($element) {
        $this->childrenList[] = $element;
        return $this;
    }

    function getChildrenList() {
        return $this->childrenList;
    }

    function getTag() {
        return $this->tag;
    }

    function getContent() {
        return $this->content;
    }

    function setChildrenList($childrenList) {
        $this->childrenList = $childrenList;
    }

    function setTag($tag) {
        $this->tag = $tag;
    }

    function setContent($content) {
        $this->content = $content;
    }

}
