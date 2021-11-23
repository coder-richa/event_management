<?php

include_once dirname(__FILE__) . '/../../classes/EventStatus.php';
include_once dirname(__FILE__) . '/../header.php';
$redirect = $success = 0;
$redirect_link = "";
$msg = "Invalid arguments";
if (isset($_REQUEST['title']) && isset($_REQUEST['id'])) {
    $title = trim($_REQUEST['title']);
    $state_id = trim($_REQUEST['id']);
    $obj = new EventStatus($title, $state_id);
    $obj->save();
    if ($obj->getStatus_id() == -1) {
        $msg = "Duplicate entry";
    } else if ($obj->getStatus_id() >= 1) {
        $success = 1;
        $msg = "Record saved successfully";
    }else{
        $msg = "Unable to save record";
    }
}
echo json_encode(array("success" => $success, "message" => $msg));
die();
?>

