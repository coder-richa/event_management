<?php

include_once dirname(__FILE__) . '/DBHelper.php';
include_once dirname(__FILE__) . '/Model.php';
include_once dirname(__FILE__) . '/State.php';
include_once dirname(__FILE__) . '/City.php';

class CustomerAddressDetails extends Model {

    var $street_no, $customer_id, $city, $pincode, $address_id;
    static $table = CUSTOMER_ADDRESS_TBL;

    function __construct($street_no, $customer_id, $city, $pincode, $address_id = NULL) {
        $this->street_no = $street_no;
        $this->customer_id = $customer_id;
        $this->city = $city;
        $this->pincode = $pincode;
        $this->address_id = $address_id;
    }

    function getStreet_no() {
        return $this->street_no;
    }

    function getCustomer_id() {
        return $this->customer_id;
    }

    function getCity() {
        return $this->city;
    }

    function getPincode() {
        return $this->pincode;
    }

    function getAddress_id() {
        return $this->address_id;
    }

    function setStreet_no($street_no) {
        $this->street_no = $street_no;
    }

    function setCustomer_id($customer_id) {
        $this->customer_id = $customer_id;
    }

    function setCity($city) {
        $this->city = $city;
    }

    function setPincode($pincode) {
        $this->pincode = $pincode;
    }

    function setAddress_id($address_id) {
        $this->address_id = $address_id;
    }

    static function getCustomerAddress($customer_id) {
        $db = new DBHelper();
        $query = "SELECT a.*,b.title as city_title,c.state_id,c.title as state_title 
                    FROM " . self::$table . " a 
                    LEFT JOIN " . CITY_TBL . " b ON b.city_id = a.city_id 
                    LEFT JOIN " . STATE_TBL . " c ON c.state_id = b.state_id 
                    WHERE a.customer_id= ?";
        $result = $db->select($query, array($customer_id));
        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new CustomerAddressDetails($row['street_no'], $row['customer_id'], new City($row['city_title'], new State($row['state_id'], $row['state_title']), $row['city_id']), $row['pincode'], $row['address_id']);
        }
        $db->closeConnection();
        return $data;
    }
    
    function add() {        
        $db = new DBHelper();
        $query = "INSERT INTO " . self::$table . " (address_id, street_no, customer_id, city_id, pincode) "
                . "VALUES (NULL,?,?,?,?)";
        $param = array($this->getStreet_no(), $this->getCustomer_id(), $this->getCity()->getCity_id(), $this->getPincode());
        $this->setCustomer_id($db->insert($query, $param));
        $db->closeConnection();
    }
    
}

?>