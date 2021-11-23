<?php

include_once dirname(__FILE__) . '/DBHelper.php';
include_once dirname(__FILE__) . '/Model.php';

// Event Status
class EventStatus extends Model {

    var $status_id, $title;
    static $table = EVENT_STATUS_TBL;

    function __construct($title, $status_id = NULL) {
        $this->status_id = $status_id;
        $this->title = $title;
    }

    function getStatus_id() {
        return $this->status_id;
    }

    function getTitle() {
        return $this->title;
    }

    function setStatus_id($status_id) {
        $this->status_id = $status_id;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    // Returns all records
    static function getALL($title = "") {
        $db = new DBHelper();
        $cond = !empty($title) ? " WHERE  a.title LIKE '%" . $title . "%' " : "";
        $query = "SELECT * FROM " . self::$table . " $cond ORDER BY title";
        $result = $db->select($query);
        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new EventStatus($row['title'], $row['status_id']);
        }
        $db->closeConnection();
        return $data;
    }

    // Delete Record
    static function delete($id) {
        $db = new DBHelper();
        $query = "DELETE FROM " . self::$table . " WHERE status_id = ?";
        $param = array($id);
        $db->update_delete($query, $param);
        $db->closeConnection();
    }

    // Insert / Update Record
    function save() {
        $existingRecord = self::getByTitle($this->getTitle());
        $isAddOperation = $this->getStatus_id() < 1;
        if (!(is_null($existingRecord) || ($existingRecord != NULL && $this->getStatus_id() == $existingRecord->getStatus_id()))) {
            $this->setStatus_id(-1);
            return;
        }
        $db = new DBHelper();
        if ($isAddOperation) {
            $query = "INSERT INTO " . self::$table . " (title) "
                    . "VALUES (?)";
            $param = array($this->getTitle());
            $this->setStatus_id($db->insert($query, $param));
        } else {
            $query = "UPDATE " . self::$table . " SET title=? "
                    . "WHERE status_id = ?";
            $param = array($this->getTitle(), $this->getStatus_id());
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
            $rec = new EventStatus($row['title'], $row['status_id']);
        }
        $db->closeConnection();
        return $rec;
    }

    // return record by id
    static function getById($id) {
        $db = new DBHelper();
        $query = "SELECT * FROM " . self::$table
                . " WHERE status_id=?";
        $result = $db->select($query, array($id));
        $rec = NULL;
        if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $rec = new EventStatus($row['title'], $row['status_id']);
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
            $data[] = array($key + 1, $record->getTitle(), self::createSpanWithLink($record->getStatus_id(), EVENT_STATUS_SAVE_FORM_API_URL),
                self::createSpanWithLink($record->getStatus_id(), EVENT_STATUS_DELETE_API_URL, "Delete", "delete"));
        }
        return self::getTableJSON($headings, $data);
    }

    // returns save form for add/edit records
    static function saveFormData($id = 0) {
        $obj = $id < 1 ? NULL : self::getById($id);
        $title = is_null($obj) ? "" : $obj->getTitle();
        return self::createAddEditTitleForm(EVENT_STATUS_SAVE_API_URL, $id, $title);
    }

}
?>

