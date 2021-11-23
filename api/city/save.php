<?php

include_once dirname(__FILE__) . '/../../classes/City.php';
include_once dirname(__FILE__) . '/../header.php';
$redirect = $success = 0;
$redirect_link = "";
$msg = "Invalid arguments";
if (isset($_REQUEST['title']) && isset($_REQUEST['id']) && isset($_REQUEST['state_id'])) {
    $title = trim($_REQUEST['title']);
    $city_id = trim($_REQUEST['id']);
    $state_id=$_REQUEST['state_id'];
    $obj = new City($title,new State("", $state_id), $city_id);
    $obj->save();
    if ($obj->getCity_id() == -1) {
        $msg = "Duplicate entry";
    } else if ($obj->getCity_id() >= 1) {
        $success = 1;
        $msg = "Record saved successfully";
    }else{
        $msg = "Unable to save record";
    }
}
echo json_encode(array("success" => $success, "message" => $msg));
die();
?>

