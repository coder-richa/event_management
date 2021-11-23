<?php

include_once dirname(__FILE__) . '/DBHelper.php';
include_once dirname(__FILE__) . '/Model.php';
include_once dirname(__FILE__) . '/EventStatus.php';
include_once dirname(__FILE__) . '/EventManager.php';

class Event extends Model {

// instance variables
    var $customer_id, $event_manager_id, $description, $special_requirement, $type_id, $event_start_on, $event_end_on, $booked_on, $status_id, $event_id;
// class variables
    static $table = EVENT_TBL;

// constructor
    function __construct($customer_id, $event_manager_id, $description, $special_requirement, $type_id, $event_start_on, $event_end_on, $booked_on = "", $status_id = 1, $event_id = NULL) {
        $this->customer_id = $customer_id;
        $this->event_manager_id = $event_manager_id;
        $this->description = $description;
        $this->special_requirement = $special_requirement;
        $this->type_id = $type_id;
        $this->event_start_on = $event_start_on;
        $this->event_end_on = $event_end_on;
        $this->booked_on = empty($booked_on) ? date('Y-m-d H:i:s') : $booked_on;
        $this->event_id = $event_id;
        $this->status_id = $status_id;
    }

// getters and setters
    function getCustomer_id() {
        return $this->customer_id;
    }

    function getEvent_manager_id() {
        return $this->event_manager_id;
    }

    function getDescription() {
        return $this->description;
    }

    function getSpecial_requirement() {
        return empty($this->special_requirement) ? "N.A." : $this->special_requirement;
    }

    function getType_id() {
        return $this->type_id;
    }

    function getEvent_start_on() {
        return $this->event_start_on;
    }

    function getEvent_end_on() {
        return $this->event_end_on;
    }

    function getBooked_on() {
        return $this->booked_on;
    }

    function getEvent_id() {
        return $this->event_id;
    }

    function setCustomer_id($customer_id) {
        $this->customer_id = $customer_id;
    }

    function setEvent_manager_id($event_manager_id) {
        $this->event_manager_id = $event_manager_id;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setSpecial_requirement($special_requirement) {
        $this->special_requirement = $special_requirement;
    }

    function setType_id($type_id) {
        $this->type_id = $type_id;
    }

    function setEvent_start_on($event_start_on) {
        $this->event_start_on = $event_start_on;
    }

    function setEvent_end_on($event_end_on) {
        $this->event_end_on = $event_end_on;
    }

    function setBooked_on($booked_on) {
        $this->booked_on = $booked_on;
    }

    function setEvent_id($event_id) {
        $this->event_id = $event_id;
    }

    function getStatus_id() {
        return $this->status_id;
    }

    function setStatus_id($status_id) {
        $this->status_id = $status_id;
    }

// retrieves all event details
    static function getALL($event_start_on, $event_end_on, $type_id, $city_id, $status_id, $event_manager_id) {
        @session_start();
        $db = new DBHelper();
        $condition = array();
        if (!empty($event_start_on)) {
            $condition[] = " a.event_start_on >= '" . $event_start_on . "' ";
        }
        if (!empty($event_end_on)) {
            $condition[] = " a.event_end_on <= '" . $event_end_on . "' ";
        }
        if (!empty($type_id)) {
            $condition[] = " a.type_id ='" . $type_id . "' ";
        }
        if (!empty($city_id)) {
            $condition[] = " a.city_id ='" . $city_id . "' ";
        }
        if (!empty($status_id)) {
            $condition[] = " a.status_id ='" . $status_id . "' ";
        }
        if (!empty($event_manager_id)) {
            $condition[] = " a.event_manager_id ='" . $event_manager_id . "' ";
        }
        if ($_SESSION['USER_TYPE'] == CUSTOMER_USER) {
            $condition[] = " a.customer_id ='" . $_SESSION['USER_ID'] . "' ";
        }
        if ($_SESSION['USER_TYPE'] == MANAGER_USER) {
            $condition[] = " a.event_manager_id ='" . $_SESSION['USER_ID'] . "' ";
        }

        $cond = count($condition) == 0 ? "" : "WHERE " . implode(" AND ", $condition);
        $query = "SELECT * FROM " . self::$table . " a "
                . " ORDER BY a.event_id desc";
        $query = "SELECT a.event_id,a.description,a.special_requirement,a.event_start_on,a.event_end_on,b.title as type,
            c.title as status, CONCAT(d.title,' ',d.first_name,' ',d.middle_name,' ',d.last_name) as customer_name, d.email_id as customer_email,d.contact_number as customer_number,
            CONCAT(e.title,' ',e.first_name,' ',e.middle_name,' ',e.last_name) as manager_name, e.email_id as manager_email,e.contact_number as manager_number,
            CONCAT(f.street_no,' ',f.pincode,' ',g.title) as event_location ,GROUP_CONCAT(DISTINCT i.title SEPARATOR ', ') as services 
       FROM " . self::$table . " a
		LEFT JOIN " . EVENT_TYPE_TBL . " b ON b.type_id=a.type_id 
        LEFT JOIN " . EVENT_STATUS_TBL . " c ON c.status_id=a.status_id
        LEFT JOIN " . CUSTOMER_TBL . " d ON d.customer_id=a.customer_id 
        LEFT JOIN " . EVENT_MANAGER_TBL . " e ON e.event_manager_id = a.event_manager_id 
        LEFT JOIN " . EVENT_LOCATION_TBL . " f ON f.event_id=a.event_id 
        LEFT JOIN " . CITY_TBL . " g ON g.city_id=f.city_id
        LEFT JOIN " . EVENT_SERVICES_TBL . " h ON h.event_id=a.event_id 
        LEFT JOIN " . SERVICES_TBL . " i ON i.service_id=h.service_id $cond GROUP BY a.event_id order by a.event_id desc";
        $result = $db->select($query);
        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = array('event_id' => $row['event_id'],
                'description' => $row['description'],
                'special_requirement' => $row['special_requirement'],
                'event_start_on' => date('M d, Y', strtotime($row['event_start_on'])),
                'event_end_on' => date('M d, Y', strtotime($row['event_end_on'])),
                'type' => $row['type'],
                'status' => $row['status'],
                'customer_name' => $row['customer_name'],
                'customer_email' => $row['customer_email'],
                'customer_number' => $row['customer_number'],
                'manager_name' => (string) $row['manager_name'],
                'manager_email' => (string) $row['manager_email'],
                'manager_number' => (string) $row['manager_number'],
                'event_location' => $row['event_location'],
                'services' => (string) $row['services']);
        }
        $db->closeConnection();
        return $data;
    }

// Delete Record
    static function delete($id) {
        $db = new DBHelper();
        $query = "DELETE FROM " . self::$table . " WHERE event_id = ?";
        $param = array($id);
        $db->update_delete($query, $param);
        $db->closeConnection();
    }

    // Insert Event Details in database
    function add() {
        $db = new DBHelper();
        $query = "INSERT INTO " . self::$table . " (event_id, customer_id, description, special_requirement, type_id, event_start_on, event_end_on, booked_on) "
                . "VALUES (NULL,?,?,?,?,?,?,?)";
        $param = array($this->getCustomer_id(), $this->getDescription(), $this->getSpecial_requirement(), $this->getType_id(), $this->getEvent_start_on(), $this->getEvent_end_on(), $this->getBooked_on());
        $this->setEvent_id($db->insert($query, $param));
        $db->closeConnection();
    }

    // Update event details in database
    function save() {
        $db = new DBHelper();
        $query = "UPDATE  " . self::$table . "  SET event_manager_id=?,status_id=? where event_id=?";
        $param = array($this->getEvent_manager_id(), $this->getStatus_id(), $this->getEvent_id());
        $db->update_delete($query, $param);
        $db->closeConnection();
    }

// Get event details by event id
    static function getById($id) {
        $db = new DBHelper();
        $query = "SELECT * FROM " . self::$table
                . " WHERE event_id=?";
        $result = $db->select($query, array($id));
        $record = NULL;
        if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $record = new Event($row['customer_id'], $row['event_manager_id'], $row['description'], $row['special_requirement'], $row['type_id'], $row['event_start_on'], $row['event_end_on'], $row['booked_on'], $row['status_id'], $row['event_id']);
        }
        $db->closeConnection();
        return $record;
    }

    // Returns Table element with state data for JSON representation
    static function getTableData($event_start_on, $event_end_on, $type_id, $city_id, $status_id, $event_manager_id) {
        @session_start();
        $headings = array("SR No.", "Start On", "End On", "Location");
        $headings[] = "Customer";
        $headings[] = "Manager";
        $headings[] = "Services";
        $headings[] = "Type";
        $headings[] = "Status";
        if ($_SESSION['USER_TYPE'] == ADMIN_USER || $_SESSION['USER_TYPE'] == MANAGER_USER) {
            $headings[] = "Edit";
        }if ($_SESSION['USER_TYPE'] == ADMIN_USER) {
            $headings[] = "Delete";
        }
        $headings[] = "Details";
        $data = array();
        $records = self::getALL($event_start_on, $event_end_on, $type_id, $city_id, $status_id, $event_manager_id);
        foreach ($records as $key => $record) {
            $entry = array($key + 1, $record['event_start_on'], $record['event_end_on'], $record['event_location']);
            $entry[] = $record['customer_name'];
            $entry[] = $record['manager_name'];
            $entry[] = $record['services'];
            $entry[] = $record['type'];
            $entry[] = $record['status'];
            if ($_SESSION['USER_TYPE'] == ADMIN_USER || $_SESSION['USER_TYPE'] == MANAGER_USER) {
                $entry[] = self::createSpanWithLink($record['event_id'], EVENT_SAVE_FORM_API_URL, "Edit");
            }if ($_SESSION['USER_TYPE'] == ADMIN_USER) {
                $entry[] = self::createSpanWithLink($record['event_id'], EVENT_DELETE_API_URL, "Delete", "delete");
            }
            $link = self::createElement("a", "", array("title" => "View", "href" => VIEW_BOOKING . "?id=" . $record['event_id'], "target" => "_blank"));
            $link->addChild(self::createElement("i", "", array("class" => VIEW_ICON)));
            $entry[] = $link;
            $data[] = $entry;
        }
        return self::getTableJSON($headings, $data);
    }

// returns save form for add/edit records
    static function statusFormData($id = 0) {
        @session_start();
        $obj = $id < 1 ? NULL : self::getById($id);
        $status_id = is_null($obj) ? NULL : $obj->getStatus_id();
        $manager_id = is_null($obj) ? NULL : $obj->getEvent_manager_id();
        $form = self::createForm("saveForm", "saveForm", EVENT_SAVE_UPDATE_API_URL);
        $form->addChild(self::getFormInputField("id", "id", $id, "hidden"));
        if ($_SESSION['USER_TYPE'] == ADMIN_USER) {
            $options = array("All" => "Select Event Manager");
            $managers = EventManager::getALL();
            foreach ($managers as $manager) {

                $options[$manager->getEvent_manager_id()] = implode(" ", array($manager->getTitle(), $manager->getFirst_name(), $manager->getMiddle_name(), $manager->getLast_name()));
            }
            $managerColumn = self::getColumnWithFormField(self::getFormSelectField("event_manager_id", "event_manager_id", $options, $manager_id, FALSE, "checkNonEmpty", "every"), self::createLabel("Event Manager", array("for" => "event_manager_id", "class" => FORM_LABEL_CLASS)), COL12_CLASS);
            $form->addChild(self::createRow(array($managerColumn)));
        }
        if ($_SESSION['USER_TYPE'] == MANAGER_USER || $_SESSION['USER_TYPE'] == ADMIN_USER) {
            $options = array();
            $statuses = EventStatus::getALL();
            foreach ($statuses as $status) {
                $options[$status->getStatus_id()] = $status->getTitle();
            }
            $statusColumn = self::getColumnWithFormField(self::getFormSelectField("status_id", "status_id", $options, $status_id, TRUE, "checkNonEmpty", "every"), self::createLabel("Status", array("for" => "status_id", "class" => FORM_LABEL_CLASS . " " . IS_REQUIRED_CLASS)), COL12_CLASS);
            $form->addChild(self::createRow(array($statusColumn)));
        }
        if ($_SESSION['USER_TYPE'] == MANAGER_USER || $_SESSION['USER_TYPE'] == ADMIN_USER) {
            $imageColumn = self::getColumnWithFormField(self::getFormInputField("image", "images[]", "", "file", FALSE, "image", "checkEmpty,checkImageFiles", "some", "image", "", TRUE), self::createLabel("Image", array("for" => "image", "class" => FORM_LABEL_CLASS)), COL12_CLASS);
            $form->addChild($imageColumn);
        }

        $buttonColumn = self::getColumnWithFormField(self::getFormButton("saveBtn", "Save"), NULL, COL12_CLASS);
        $form->addChild(self::createRow(array($buttonColumn)));
        return $form;
    }

}

?>