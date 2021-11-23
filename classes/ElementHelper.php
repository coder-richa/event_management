<?php

include_once dirname(__FILE__) . '/Element.php';
include_once dirname(__FILE__) . '/Attribute.php';

trait ElementHelper {

    // Span with Link
    static function createSpanWithLink($id, $action, $title = "Edit", $type = "edit") {
        $span = new Element("span");
        $span->addChild(self::getEditDeleteFormLink($id, $action, $title, $type));
        return $span;
    }

    // get Form with Title field
    static function createAddEditTitleForm($action, $id, $title) {
        $form = self::createForm("saveForm", "saveForm", $action);
        $form->addChild(self::getFormInputField("id", "id", $id, "hidden"));
        $titleColumn = self::getColumnWithFormField(self::getFormInputField("title", "title", $title, "text", TRUE, "lettersAndSpaces", "checkNonEmpty,checkName", "every", "name"), self::createLabel("Name", array("for" => "title", "class" => FORM_LABEL_CLASS . " " . IS_REQUIRED_CLASS)), COL12_CLASS);
        $buttonColumn = self::getColumnWithFormField(self::getFormButton("saveBtn", "Save"), NULL, COL12_CLASS);
        $form->addChild(self::createRow(array($titleColumn)));
        $form->addChild(self::createRow(array($buttonColumn)));
        return $form;
    }

    // Edit/ Delete Link Element
    static function getEditDeleteFormLink($id, $url, $title = "Edit", $type = "edit") {
        $name = $type . "Form" . $id;
        $hiddenFieldName = "id";
        $showmodal = 1;
        $target = TARGET_FORM_MODEL;
        $targetBtn = "";
        $addAlertField = TRUE;
        $icon = EDIT_ICON;
        switch ($type) {
            case "delete":
                $icon = DELETE_ICON;
                $showmodal = 0;
                $target = "";
                $addAlertField = FALSE;
                $targetBtn = ".searchTableBtn";
                break;
            case "view":
                $icon = VIEW_ICON;
                $addAlertField = FALSE;
                break;
        }
        $form = self::createForm($name, $name, $url, $addAlertField);
        $form->addChild(self::getFormInputField($type . "ID" . $id, $hiddenFieldName, $id, "hidden"));
        $link = self::createElement("a", "", array("title" => $title, "href" => "javascript:void(0);"));
        $link->addChild(self::createElement("i", "", array("class" => $icon . " " . " form-submit", "data-title" => $title, "data-showmodal" => $showmodal, "data-target" => $target, "data-successtargetbtn" => $targetBtn)));
        $form->addChild($link);
        return $form;
    }

    // Hierarical representation of Table (For JSON Generation)
    static function getTableJSON($headings = array(), $data = array()) {
        $tableObj = new Element("table", "", array(new Attribute("class", "table")));
        $thead = new Element("thead");
        $row = new Element("tr");
        foreach ($headings as $heading) {
            $thead->addChild(new Element("th", $heading));
        }
        $row->addChild($thead);
        $tableObj->addChild($row);
        $tbody = new Element("tbody");
        foreach ($data as $key => $values) {
            $row = new Element("tr");

            foreach ($values as $value) {
                if (is_object($value) && $value instanceof Element) {
                    $elem = (new Element("td"))->addChild($value);
                    $row->addChild($elem);
                } else {
                    $row->addChild(new Element("td", $value));
                }
            }
            $tbody->addChild($row);
//            break;
        }
        if (count($tbody->getChildrenList()) == 0) {
            $row = (new Element("tr"))
                    ->addChild(self::createElement("td", "No records found", array("colspan" => count($thead->getChildrenList()))));
            $tbody->addChild($row);
        }
        $tableObj->addChild($tbody);
        return $tableObj;
    }

    // Form Element    
    static function createForm($name, $id, $url, $addAlertField = TRUE) {
        $formAttributes = array();
        $formAttributes["name"] = $name;
        $formAttributes["id"] = $id;
        $formAttributes["method"] = "POST";
        $formAttributes["enctype"] = "multipart/form-data";
        $formAttributes["action"] = $url;
        $form = self::createElement("form", "", $formAttributes);
        if ($addAlertField) {
            $form->addChild(self::formAlert(ROW_CLASS . " " . FORM_ALERT_CLASS . "  " . FORM_ALERT_SUCCESS_CLASS . " " . HIDDEN_CLASS, "Success"));
            $form->addChild(self::formAlert(ROW_CLASS . " " . FORM_ALERT_CLASS . " " . FORM_ALERT_FAILURE_CLASS . " " . HIDDEN_CLASS, "Error"));
        } return $form;
    }

    // Div Element
    static function createDiv($attributes = array(), $content = "") {
        return self::createElement("div", $content, $attributes);
    }

    // Label Element
    static function createLabel($content = "", $attributes = array()) {
        return self::createElement("label", $content, $attributes);
    }

    // Form Alert Element
    static function formAlert($class, $content) {
        $alert = self::createDiv(array("class" => $class));
        $alert->addChild(self::createDiv(array("class" => COL12_CLASS), $content));
        return $alert;
    }

    // return array of Attribute Elements from associated array
    static function arrayToAttributes($attributes = array()) {
        $elementAttributes = array();
        foreach ($attributes as $name => $value) {
            $elementAttributes[] = new Attribute($name, $value);
        }
        return $elementAttributes;
    }

    // Return Element
    static function createElement($tag, $content, $attributes = array()) {
        $elementAttributes = self::arrayToAttributes($attributes);
        $element = new Element($tag, $content, $elementAttributes);
        return $element;
    }

    // Return input form element
    static function getFormInputField($id, $name, $value = "", $type = "text", $isRequired = FALSE, $dataType = "", $dataValidator = "", $dataValidationType = "", $dataFormat = "", $class = FORM_CONTROL_CLASS, $multiple = False) {
        $attributes = array();
        $attributes["type"] = $type;
        $attributes["id"] = $id;
        $attributes["name"] = $name;
        $attributes["value"] = $value;
        $attributes["class"] = $class;
        if ($isRequired)
            $attributes["required"] = "required";
        if (!empty($dataType))
            $attributes["data-type"] = $dataType;
        if (!empty($dataValidator))
            $attributes["data-validator"] = $dataValidator;
        if (!empty($dataValidationType))
            $attributes["data-validationType"] = $dataValidationType;
        if ($multiple)
            $attributes["multiple"] = "multiple";
        if (!empty($dataFormat))
            $attributes["data-format"] = $dataFormat;
        return self::createElement("input", "", $attributes);
    }

    // Return input form element
    static function getFormSelectField($id, $name, $options = array(), $selected_option_id = "", $isRequired = FALSE, $dataValidator = "", $dataValidationType = "", $class = FORM_CONTROL_CLASS) {
        $attributes = array();
        $attributes["id"] = $id;
        $attributes["name"] = $name;
        $attributes["class"] = $class;
        if ($isRequired)
            $attributes["required"] = "required";
        if (!empty($dataValidator))
            $attributes["data-validator"] = $dataValidator;
        if (!empty($dataValidationType))
            $attributes["data-validationType"] = $dataValidationType;
        if (!empty($dataFormat))
            $attributes["data-format"] = $dataFormat;
        $select = self::createElement("select", "", $attributes);
        foreach ($options as $key => $value) {
            $optionAttributes = array("value" => $key);
            if ($key == $selected_option_id) {
                $optionAttributes["selected"] = "selected";
            }
            $select->addChild(self::createElement("option", $value, $optionAttributes));
        }
        return $select;
    }

    // return form button element
    static function getFormButton($id, $content, $successTargetBtn = ".searchTableBtn", $class = FORM_SUBMIT_BTN_CLASS . " form-label", $type = "button") {
        $attributes = array();
        $attributes["type"] = $type;
        $attributes["id"] = $id;
        $attributes["class"] = $class;
        $attributes["data-successTargetBtn"] = $successTargetBtn;
        return self::createElement("button", $content, $attributes);
    }

    // Column with form field
    static function getColumnWithFormField($field, $label = NULL, $column_class = COL6_CLASS) {
        $formGroup = self::createDiv(array("class" => FORM_GROUP_CLASS));
        $formGroup->addChild($field);
        $column = self::createDiv(array("class" => $column_class));
        if (!is_null($label)) {
            $column->addChild($label);
        }
        $column->addChild($formGroup);
        return $column;
    }

    // Retuen div with row element
    static function createRow($columns = array()) {
        $row = self::createDiv(array("class" => ROW_CLASS));
        foreach ($columns as $column) {
            $row->addChild($column);
        }
        return $row;
    }

}
