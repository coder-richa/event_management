<?php

include_once dirname(__FILE__) . '/DBHelper.php';
include_once dirname(__FILE__) . '/Model.php';

class EventServicesDetails extends Model {

// instance variables
    var $event_id, $service_id;
    // class variable
    static $table = EVENT_SERVICES_TBL;

// constructor
    function __construct($event_id, $service_id) {
        $this->event_id = $event_id;
        $this->service_id = $service_id;
    }

    // getter and setters
    function getEvent_id() {
        return $this->event_id;
    }

    function getService_id() {
        return $this->service_id;
    }

    function setEvent_id($event_id) {
        $this->event_id = $event_id;
    }

    function setService_id($service_id) {
        $this->service_id = $service_id;
    }

// Retrieve all services of an event
    static function getALL($event_id) {
        $db = new DBHelper();
        $query = "SELECT * FROM " . self::$table . " a "
                . " WHERE a.event_id =?";
        $result = $db->select($query, array($event_id));
        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new EventServicesDetails($row['event_id'], $row['service_id']);
        }
        $db->closeConnection();
        return $data;
    }

// Save Event services to database
    function add() {
        $db = new DBHelper();
        $query = "INSERT INTO " . self::$table . " (event_id, service_id) "
                . "VALUES (?,?)";
        $param = array($this->getEvent_id(), $this->getService_id());
        $db->insert($query, $param);
        $db->closeConnection();
    }

}
