<?php

include_once dirname(__FILE__) . '/DBHelper.php';
include_once dirname(__FILE__) . '/Model.php';

class Services extends Model {

    // instance variable
    var $service_id, $title, $icon, $description;
    // class variable
    static $table = SERVICES_TBL;

    // Constructor Function
    function __construct($title, $icon, $description, $service_id) {
        $this->service_id = $service_id;
        $this->title = $title;
        $this->icon = $icon;
        $this->description = $description;
    }

// Getters and setters
    function getService_id() {
        return $this->service_id;
    }

    function getTitle() {
        return $this->title;
    }

    function getIcon() {
        return $this->icon;
    }

    function getDescription() {
        return $this->description;
    }

    function setService_id($service_id) {
        $this->service_id = $service_id;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setIcon($icon) {
        $this->icon = $icon;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    // Delete Record
    static function delete($id) {
        $db = new DBHelper();
        $query = "DELETE FROM " . self::$table . " WHERE service_id = ?";
        $param = array($id);
        $db->update_delete($query, $param);
        $db->closeConnection();
    }

    // Fetch all services details from table
    static function getALL() {
        $db = new DBHelper();
        $query = "SELECT * FROM " . self::$table . " ORDER BY title";
        $result = $db->select($query);
        $services = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $services[] = new Services($row['title'], $row['icon'], $row['description'], $row['service_id']);
        }
        $db->closeConnection();
        return $services;
    }

    // return record by id
    static function getById($id) {
        $db = new DBHelper();
        $query = "SELECT * FROM " . self::$table
                . " WHERE service_id=?";
        $result = $db->select($query, array($id));
        $rec = NULL;
        if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $rec = new Services($row['title'], $row['icon'], $row['description'], $row['service_id']);
        }
        $db->closeConnection();
        return $rec;
    }

}

?>