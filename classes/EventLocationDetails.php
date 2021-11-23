<?php

include_once dirname(__FILE__) . '/DBHelper.php';
include_once dirname(__FILE__) . '/Model.php';

class EventLocationDetails extends Model {

// instance variables
    var $event_id, $street_no, $city_id, $pincode, $location_id;
    // class variable
    static $table = EVENT_LOCATION_TBL;

// constructor
    function __construct($event_id, $street_no, $city_id, $pincode, $location_id = NULL) {
        $this->event_id = $event_id;
        $this->street_no = $street_no;
        $this->city_id = $city_id;
        $this->pincode = $pincode;
        $this->location_id = $location_id;
    }

    // getter and setters
    function getEvent_id() {
        return $this->event_id;
    }

    function getStreet_no() {
        return $this->street_no;
    }

    function getCity_id() {
        return $this->city_id;
    }

    function getPincode() {
        return $this->pincode;
    }

    function getLocation_id() {
        return $this->location_id;
    }

    function setEvent_id($event_id) {
        $this->event_id = $event_id;
    }

    function setStreet_no($street_no) {
        $this->street_no = $street_no;
    }

    function setCity_id($city_id) {
        $this->city_id = $city_id;
    }

    function setPincode($pincode) {
        $this->pincode = $pincode;
    }

    function setLocation_id($location_id) {
        $this->location_id = $location_id;
    }

    // Retrieve all location of an event
    static function getALL($event_id) {
        $db = new DBHelper();
        $query = "SELECT * FROM " . self::$table . " a "
                . " WHERE a.event_id =?";
        $result = $db->select($query, array($event_id));
        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new EventLocationDetails($row['event_id'], $row['street_no'], $row['city_id'], $row['pincode'], $row['location_id']);
        }
        $db->closeConnection();
        return $data;
    }

    // Delete Record
    static function delete($id) {
        $db = new DBHelper();
        $query = "DELETE FROM " . self::$table . " WHERE location_id = ?";
        $param = array($id);
        $db->update_delete($query, $param);
        $db->closeConnection();
    }

// Save Event location to database
    function add() {
        $db = new DBHelper();
        $query = "INSERT INTO " . self::$table . " (location_id, street_no, event_id, city_id, pincode) "
                . "VALUES (NULL,?,?,?,?)";
        $param = array($this->getStreet_no(), $this->getEvent_id(), $this->getCity_id(), $this->getPincode());
        $this->setLocation_id($db->insert($query, $param));
        $db->closeConnection();
    }

}
