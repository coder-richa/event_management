<?php

@session_start();
include_once dirname(__FILE__) . '/../../classes/Event.php';
include_once dirname(__FILE__) . '/../../classes/EventLocationDetails.php';
include_once dirname(__FILE__) . '/../../classes/EventServicesDetails.php';
include_once dirname(__FILE__) . '/../header.php';
$redirect = $success = 0;
$redirect_link = "";
$msg = "Invalid arguments";
if (isset($_REQUEST['event_start_on']) && isset($_REQUEST['event_end_on']) && isset($_REQUEST['type_id']) && isset($_REQUEST['street_no']) &&
        isset($_REQUEST['pincode']) && isset($_REQUEST['city_id']) && isset($_REQUEST['description']) && isset($_REQUEST['services']) && isset($_REQUEST['special_requirement'])) {
    $event_start_on = trim($_REQUEST['event_start_on']);
    $event_end_on = trim($_REQUEST['event_end_on']);
    $type_id = trim($_REQUEST['type_id']);
    $street_no = trim($_REQUEST['street_no']);
    $pincode = trim($_REQUEST['pincode']);
    $city_id = trim($_REQUEST['city_id']);
    $description = trim($_REQUEST['description']);
    $special_requirement = trim($_REQUEST['special_requirement']);
    $services = $_REQUEST['services'];
    $obj = new Event($_SESSION['USER_ID'], NULL, $description, $special_requirement, $type_id, $event_start_on, $event_end_on);
    $obj->add();
    $event_id = $obj->getEvent_id();
    if ($event_id >= 1) {
        $success = 1;
        $redirect=1;
        $redirect_link=CUSTOMER_DASHBOARD;
        $location = new EventLocationDetails($event_id, $street_no, $city_id, $pincode);
        $location->add();
        foreach ($services as $service_id) {
           $ser= new EventServicesDetails($event_id, $service_id);
           $ser->add();
        }
        $msg = "Event booked successfully!";
    } else {
        $msg = "Unable to make booking";
    }
}
echo json_encode(array("success" => $success, "message" => $msg,"redirect" => $redirect, "redirect_link" => $redirect_link));
die();
?>

