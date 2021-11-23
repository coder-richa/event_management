<?php

include_once dirname(__FILE__) . '/../../classes/Customer.php';
include_once dirname(__FILE__) . '/../../classes/SiteSession.php';
include_once dirname(__FILE__) . '/../../classes/CustomerAddressDetails.php';
include_once dirname(__FILE__) . '/../header.php';
$redirect = $success = 0;
$redirect_link = "";
$msg = "Unable to resigster";
$title = trim($_REQUEST['title']);
$first_name = trim($_REQUEST['firstName']);
$middle_name = trim($_REQUEST['middleName']);
$last_name = trim($_REQUEST['lastName']);
$email_id = trim($_REQUEST['email']);
$password = trim($_REQUEST['password']);
$contact_number = trim($_REQUEST['phone']);
$street_no = trim($_REQUEST['street']);
$pincode = trim($_REQUEST['pincode']);
$city_id = trim($_REQUEST['city']);

$customer = new Customer($title, $first_name, $middle_name, $last_name, $contact_number, $password, $email_id);
$customer->add();
$customer_id = $customer->getCustomer_id();
if ($customer_id == -1) {
    $msg = "Email Id already in use";
} else if ($customer_id == 0) {
    $msg = "Unable to register";
} else {
    $msg = "Registeration successful";
    $redirect = $success = 1;
    $redirect_link = CUSTOMER_DASHBOARD;
    $customerAddress = new CustomerAddressDetails($street_no, $customer_id, new City("", "", $city_id), $pincode);
    $customerAddress->add();
    SiteSession::startUserSession(CUSTOMER_USER, $customer_id);
}
echo json_encode(array("success" => $success, "message" => $msg, "redirect" => $redirect, "redirect_link" => $redirect_link));
die();
?>

