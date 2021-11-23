<?php

include_once dirname(__FILE__) . '/DBHelper.php';
include_once dirname(__FILE__) . '/Model.php';
include_once dirname(__FILE__) . '/EventManager.php';
include_once dirname(__FILE__) . '/UserHelper.php';

class Customer extends Model {
    // instance variable
    var $title, $first_name, $middle_name, $last_name, $contact_number, $password, $email_id, $joined_on, $customer_id;
    // class cariable 
    static $table = CUSTOMER_TBL;
    // User Helper to check email id of admin, customer and event manager
    use UserHelper;

    // constructor
    function __construct($title, $first_name, $middle_name, $last_name, $contact_number, $password, $email_id, $joined_on = "", $customer_id = Null) {
        $this->title = $title;
        $this->first_name = $first_name;
        $this->middle_name = $middle_name;
        $this->last_name = $last_name;
        $this->contact_number = $contact_number;
        $this->password = $password;
        $this->email_id = $email_id;
        $this->joined_on = empty($joined_on) ? date('Y-m-d H:i:s') : $joined_on;
        $this->customer_id = $customer_id;
    }

    // getters and setters
    function getTitle() {
        return $this->title;
    }

    function getFirst_name() {
        return $this->first_name;
    }

    function getMiddle_name() {
        return $this->middle_name;
    }

    function getLast_name() {
        return $this->last_name;
    }

    function getContact_number() {
        return $this->contact_number;
    }

    function getPassword() {
        return $this->password;
    }

    function getEmail_id() {
        return $this->email_id;
    }

    function getJoined_on() {
        return $this->joined_on;
    }

    function getCustomer_id() {
        return $this->customer_id;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setFirst_name($first_name) {
        $this->first_name = $first_name;
    }

    function setMiddle_name($middle_name) {
        $this->middle_name = $middle_name;
    }

    function setLast_name($last_name) {
        $this->last_name = $last_name;
    }

    function setContact_number($contact_number) {
        $this->contact_number = $contact_number;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setEmail_id($email_id) {
        $this->email_id = $email_id;
    }

    function setJoined_on($joined_on) {
        $this->joined_on = $joined_on;
    }

    function setCustomer_id($customer_id) {
        $this->customer_id = $customer_id;
    }

    // Retrieve all customer data
    static function getALL() {
        $db = new DBHelper();
        $query = "SELECT * FROM " . self::$table . " a "
                . " ORDER BY a.customer_id desc";
        $result = $db->select($query);
        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new Customer($row['title'], $row['first_name'], $row['middle_name'], $row['last_name'], $row['contact_number'], $row['password'], $row['email_id'], $row['joined_on'], $row['customer_id']);
        }
        $db->closeConnection();
        return $data;
    }

    // insert customer record
    function add() {
        if ($this->isExistingEmail($this->getEmail_id())) {
            $this->setCustomer_id(-1);
            return;
        }
        $db = new DBHelper();
        $query = "INSERT INTO " . self::$table . " (customer_id, title, first_name, middle_name, last_name, contact_number, password, email_id, joined_on) "
                . "VALUES (NULL,?,?,?,?,?,?,?,?)";
        $param = array($this->getTitle(), $this->getFirst_name(), $this->getMiddle_name(), $this->getLast_name(), $this->getContact_number(), $this->getPassword(), $this->getEmail_id(), $this->getJoined_on());
        $this->setCustomer_id($db->insert($query, $param));
        $db->closeConnection();
    }

    // retrieve customer record by email
    static function getByEmail($email) {
        $db = new DBHelper();
        $query = "SELECT * FROM " . self::$table
                . " WHERE email_id=?";
        $result = $db->select($query, array($email));
        $customer = NULL;
        if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $customer = new Customer($row['title'], $row['first_name'], $row['middle_name'], $row['last_name'], $row['contact_number'], $row['password'], $row['email_id'], $row['joined_on'], $row['customer_id']);
        }
        $db->closeConnection();
        return $customer;
    }

    // retrieve customer record by id
    static function getById($id) {
        $db = new DBHelper();
        $query = "SELECT * FROM " . self::$table
                . " WHERE customer_id=?";
        $result = $db->select($query, array($id));
        $customer = NULL;
        if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $customer = new Customer($row['title'], $row['first_name'], $row['middle_name'], $row['last_name'], $row['contact_number'], $row['password'], $row['email_id'], $row['joined_on'], $row['customer_id']);
        }
        $db->closeConnection();
        return $customer;
    }

}

?>