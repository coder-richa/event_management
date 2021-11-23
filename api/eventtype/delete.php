<?php

include_once dirname(__FILE__) . '/../../classes/EventType.php';
include_once dirname(__FILE__) . '/../header.php';
$redirect = $success = 0;
$redirect_link = "";
$msg = "Invalid arguments";
if (isset($_REQUEST['id'])) {
    $id = trim($_REQUEST['id']);
    EventType::delete($id);
    $success = 1;
    $msg = "Record deleted successfully";
}
echo json_encode(array("success" => $success, "message" => $msg));
die();
?>

