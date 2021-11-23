<?php

include_once dirname(__FILE__) . '/DBHelper.php';
include_once dirname(__FILE__) . '/Model.php';
include_once dirname(__FILE__) . '/State.php';

class City extends Model {

    var $title, $state, $city_id;
    static $table = CITY_TBL;

    function __construct($title, $state = Null, $city_id = Null) {
        $this->title = $title;
        $this->state = $state;
        $this->city_id = $city_id;
    }

    function getTitle() {
        return $this->title;
    }

    function getState() {
        return $this->state;
    }

    function getCity_id() {
        return $this->city_id;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setState($state) {
        $this->state = $state;
    }

    function setCity_id($city_id) {
        $this->city_id = $city_id;
    }

    static function getALL($title = "") {
        $db = new DBHelper();
        $cond = !empty($title) ? " WHERE  a.title LIKE '%" . $title . "%' " : "";
        $query = "SELECT a.*,b.title as state_title  FROM " . self::$table . " a "
                . " LEFT JOIN " . STATE_TBL . " b ON b.state_id=a.state_id "
                . " $cond"
                . " ORDER BY a.title";
        $result = $db->select($query);
        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new City($row['title'], new State($row['state_title'], $row['state_id']), $row['city_id']);
        }
        $db->closeConnection();
        return $data;
    }

// Delete Record
    static function delete($id) {
        $db = new DBHelper();
        $query = "DELETE FROM " . self::$table . " WHERE city_id = ?";
        $param = array($id);
        $db->update_delete($query, $param);
        $db->closeConnection();
    }

    // Insert / Update Record
    function save() {
        $existingRecord = self::getByTitle($this->getTitle());
        $isAddOperation = $this->getCity_id() < 1;
        if (!(is_null($existingRecord) || ($existingRecord != NULL && $this->getCity_id() == $existingRecord->getCity_id()))) {
            $this->setCity_id(-1);
            return;
        }
        $db = new DBHelper();
        if ($isAddOperation) {
            $query = "INSERT INTO " . self::$table . " (title,state_id) "
                    . "VALUES (?,?)";
            $param = array($this->getTitle(), $this->getState()->getState_id());
            $this->setCity_id($db->insert($query, $param));
        } else {
            $query = "UPDATE " . self::$table . " SET title=?, state_id=? "
                    . "WHERE city_id = ?";
            $param = array($this->getTitle(), $this->getState()->getState_id(), $this->getCity_id());
            $db->update_delete($query, $param);
        }
        $db->closeConnection();
    }

    // Returns record with given title
    static function getByTitle($title) {
        $db = new DBHelper();
        $query = "SELECT a.*,b.title as state_title  FROM " . self::$table . " a "
                . " LEFT JOIN " . STATE_TBL . " b ON b.state_id=a.state_id"
                . " WHERE a.title=?";
        $result = $db->select($query, array($title));
        $rec = NULL;
        if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $rec = new City($row['title'], new State($row['state_title'], $row['state_id']), $row['city_id']);
        }
        $db->closeConnection();
        return $rec;
    }

    // return record by id
    static function getById($id) {
        $db = new DBHelper();
        $query = "SELECT a.*,b.title as state_title  FROM " . self::$table . " a "
                . " LEFT JOIN " . STATE_TBL . " b ON b.state_id=a.state_id"
                . " WHERE a.city_id=?";
        $result = $db->select($query, array($id));
        $rec = NULL;
        if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $rec = new City($row['title'], new State($row['state_title'], $row['state_id']), $row['city_id']);
        }
        $db->closeConnection();
        return $rec;
    }

    // Returns Table element with state data for JSON representation
    static function getTableData($title = "") {
        $headings = array("SR No.", "City", "State", "EDIT","DELETE");
        $data = array();
        $records = self::getALL($title);
        foreach ($records as $key => $record) {
            $data[] = array($key + 1, $record->getTitle(), $record->getState()->getTitle(), self::createSpanWithLink($record->getCity_id(), CITY_SAVE_FORM_API_URL),
                self::createSpanWithLink($record->getCity_id(), CITY_DELETE_API_URL,  "Delete", "delete"));
        }
        return self::getTableJSON($headings, $data);
    }

    // returns save form for add/edit records
    static function saveFormData($id = 0) {
        $obj = $id < 1 ? NULL : self::getById($id);
        $title = is_null($obj) ? "" : $obj->getTitle();
        $state_id = is_null($obj) ? NULL : $obj->getState()->getState_id();
        $form = self::createForm("saveForm", "saveForm", CITY_SAVE_API_URL);
        $form->addChild(self::getFormInputField("id", "id", $id, "hidden"));
        $titleColumn = self::getColumnWithFormField(self::getFormInputField("title", "title", $title, "text", TRUE, "lettersAndSpaces", "checkNonEmpty,checkName", "every", "name"), self::createLabel("Name", array("for" => "title", "class" => FORM_LABEL_CLASS . " " . IS_REQUIRED_CLASS)), COL12_CLASS);
        $options = array();
        $states = State::getALL();
        foreach ($states as $state) {
            $options[$state->getState_id()] = $state->getTitle();
        }
        $stateColumn = self::getColumnWithFormField(self::getFormSelectField("state_id", "state_id", $options, $state_id, TRUE, "checkNonEmpty", "every"), self::createLabel("State", array("for" => "state_id", "class" => FORM_LABEL_CLASS . " " . IS_REQUIRED_CLASS)), COL12_CLASS);
        $buttonColumn = self::getColumnWithFormField(self::getFormButton("saveBtn", "Save"), NULL, COL12_CLASS);
        $form->addChild(self::createRow(array($titleColumn)));
        $form->addChild(self::createRow(array($stateColumn)));
        $form->addChild(self::createRow(array($buttonColumn)));
        return $form;
    }

}

?>