<?php

include_once dirname(__FILE__) . '/DBHelper.php';
include_once dirname(__FILE__) . '/Model.php';

// State 
class State extends Model {

    var $state_id, $title;
    static $table = STATE_TBL;

    function __construct($title, $state_id = NULL) {
        $this->state_id = $state_id;
        $this->title = $title;
    }

    function getState_id() {
        return $this->state_id;
    }

    function getTitle() {
        return $this->title;
    }

    function setState_id($state_id) {
        $this->state_id = $state_id;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    // Returns all records
    static function getALL($title = "") {
        $db = new DBHelper();
        $cond = !empty($title) ? " WHERE  a.title LIKE '%" . $title . "%' " : "";
        $query = "SELECT * FROM " . self::$table . " a $cond ORDER BY title";        
        $result = $db->select($query);
        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new State($row['title'], $row['state_id']);
        }
        $db->closeConnection();
        return $data;
    }

    // Delete Record
    static function delete($id) {
        $db = new DBHelper();
        $query = "DELETE FROM " . self::$table . " WHERE state_id = ?";
        $param = array($id);
        $db->update_delete($query, $param);
        $db->closeConnection();
    }

    // Insert / Update Record
    function save() {
        $existingRecord = self::getByTitle($this->getTitle());
        $isAddOperation = $this->getState_id() < 1;
        if (!(is_null($existingRecord) || ($existingRecord != NULL && $this->getState_id() == $existingRecord->getState_id()))) {
            $this->setState_id(-1);
            return;
        }
        $db = new DBHelper();
        if ($isAddOperation) {
            $query = "INSERT INTO " . self::$table . " (title) "
                    . "VALUES (?)";
            $param = array($this->getTitle());
            $this->setState_id($db->insert($query, $param));
        } else {
            $query = "UPDATE " . self::$table . " SET title=? "
                    . "WHERE state_id = ?";
            $param = array($this->getTitle(), $this->getState_id());
            $db->update_delete($query, $param);
        }
        $db->closeConnection();
    }

    // Returns record with given title
    static function getByTitle($title) {
        $db = new DBHelper();
        $query = "SELECT * FROM " . self::$table
                . " WHERE title=?";
        $result = $db->select($query, array($title));
        $rec = NULL;
        if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $rec = new State($row['title'], $row['state_id']);
        }
        $db->closeConnection();
        return $rec;
    }

    // return record by id
    static function getById($id) {
        $db = new DBHelper();
        $query = "SELECT * FROM " . self::$table
                . " WHERE state_id=?";
        $result = $db->select($query, array($id));
        $rec = NULL;
        if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $rec = new State($row['title'], $row['state_id']);
        }
        $db->closeConnection();
        return $rec;
    }

    // Returns Table element with state data for JSON representation
    static function getTableData($title = "") {
        $headings = array("SR No.", "Title", "Edit","Delete");
        $data = array();
        $records = self::getALL($title);
        foreach ($records as $key => $record) {
            $data[] = array($key + 1, $record->getTitle(), self::createSpanWithLink($record->getState_id(), STATE_SAVE_FORM_API_URL),
                 self::createSpanWithLink($record->getState_id(), STATE_DELETE_API_URL,  "Delete", "delete"));
        }
        return self::getTableJSON($headings, $data);
    }

    // returns save form for add/edit records
    static function saveFormData($id = 0) {
        $obj = $id < 1 ? NULL : self::getById($id);
        $title = is_null($obj) ? "" : $obj->getTitle();
        return self::createAddEditTitleForm(STATE_SAVE_API_URL, $id, $title);
    }

}
?>

