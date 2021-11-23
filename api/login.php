<?php
include_once dirname(__FILE__) . './../classes/SiteSession.php';
include_once dirname(__FILE__) . './../classes/Customer.php';
include_once dirname(__FILE__) . './../classes/CustomerAddressDetails.php';
//include_once dirname(__FILE__) . '/header.php';
$redirect = $success = 0;
$redirect_link = "";
$msg = "Invalid data";
if(isset($_REQUEST['email']) && isset($_REQUEST['password'])){
$msg = "Account does not exist";
$username = trim($_REQUEST['email']);
$password = trim($_REQUEST['password']);
if ($username == ADMIN_USERNAME) {
    if ($password == ADMIN_PASSWORD) {
        $success = 1;
        $redirect_link = ADMIN_DASHBOARD;
        $redirect = 1;
        SiteSession::startUserSession(ADMIN_USER, "0");
        $msg = "Login successful";
    } else {
        $msg = "Invalid username or password";
    }
} else {
    $eventManaget = EventManager::getByEmail($username);
    if (!is_null($eventManaget)) {
        if ($password == $eventManaget->getPassword()) {
            $success = 1;
            $redirect_link = MANAGER_DASHBOARD;
            $redirect = 1;
            $msg = "Login successful";
            SiteSession::startUserSession(MANAGER_USER, $eventManaget->getEvent_manager_id());
        } else {
            $msg = "Invalid username or password";
        }
    } else {
        $customer = Customer::getByEmail($username);
        if (!is_null($customer)) {
            if ($password == $customer->getPassword()) {
                $success = 1;
                $redirect_link = CUSTOMER_DASHBOARD;
                $redirect = 1;
                $msg = "Login successful";
                SiteSession::startUserSession(CUSTOMER_USER, $customer->getCustomer_id());
            } else {
                $msg = "Invalid username or password";
            }
        }
    }
}
}
echo json_encode(array("success" => $success, "message" => $msg, "redirect" => $redirect, "redirect_link" => $redirect_link));
die();
?>

