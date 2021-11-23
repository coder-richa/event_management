<?php

include_once dirname(__FILE__) . '/../../classes/EventManager.php';
include_once dirname(__FILE__) . '/../header.php';
$redirect = $success = 0;
$redirect_link = "";
$msg = "Invalid arguments";
if (isset($_REQUEST['title']) &&isset($_REQUEST['first_name']) && isset($_REQUEST['last_name']) && isset($_REQUEST['middle_name']) && isset($_REQUEST['contact_number']) && isset($_REQUEST['email_id']) && isset($_REQUEST['password']) && isset($_REQUEST['id'])) {
    $title = trim($_REQUEST['title']);
    $first_name = trim($_REQUEST['first_name']);
    $middle_name = trim($_REQUEST['middle_name']);
    $last_name = trim($_REQUEST['last_name']);
    $contact_number = trim($_REQUEST['contact_number']);
    $email_id = trim($_REQUEST['email_id']);
    $password= trim($_REQUEST['password']);
    $event_manager_id = trim($_REQUEST['id']);
    $obj = new EventManager($title, $first_name, $middle_name, $last_name, $contact_number, $password, $email_id, "",$event_manager_id);
    $obj->save();
    if ($obj->getEvent_manager_id() == -1) {
        $msg = "Duplicate entry";
    } else if ($obj->getEvent_manager_id() >= 1) {
        $success = 1;
        $msg = "Record saved successfully";
    }else{
        $msg = "Unable to save record";
    }
}
echo json_encode(array("success" => $success, "message" => $msg));
die();
?>

