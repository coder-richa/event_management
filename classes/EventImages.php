<?php

include_once dirname(__FILE__) . '/DBHelper.php';
include_once dirname(__FILE__) . '/Model.php';

class EventImages extends Model {
    // instance variables
    var $event_id, $image_extension, $image_id;
    // class variable
    static $table = EVENT_IMAGES_TBL;
    // constructor
    function __construct($event_id, $image_extension, $image_id = NULL) {
        $this->event_id = $event_id;
        $this->image_extension = $image_extension;
        $this->image_id = $image_id;
    }
    // getter and setters
    function getEvent_id() {
        return $this->event_id;
    }

    function getImage_extension() {
        return $this->image_extension;
    }

    function getImage_id() {
        return $this->image_id;
    }

    function setEvent_id($event_id) {
        $this->event_id = $event_id;
    }

    function setImage_extension($image_extension) {
        $this->image_extension = $image_extension;
    }

    function setImage_id($image_id) {
        $this->image_id = $image_id;
    }

    // Retrieve all images of an event
    static function getALL($event_id) {
        $db = new DBHelper();
        $query = "SELECT * FROM " . self::$table . " a "
                . " WHERE a.event_id =?";
        $result = $db->select($query, array($event_id));
        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new EventImages($row['event_id'], $row['image_extension'], $row['image_id']);
        }
        $db->closeConnection();
        return $data;
    }

    // Save Event Image to database
    function add() {
        $db = new DBHelper();
        $query = "INSERT INTO " . self::$table . " (image_id, image_extension, event_id) "
                . "VALUES (NULL,?,?)";
        $param = array($this->getImage_extension(), $this->getEvent_id());
        $this->setImage_id($db->insert($query, $param));
        $db->closeConnection();
    }

}
