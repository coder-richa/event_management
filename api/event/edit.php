<?php
@session_start();
include_once dirname(__FILE__) . '/../../classes/Event.php';
include_once dirname(__FILE__) . '/../../classes/EventImages.php';
include_once dirname(__FILE__) . '/../header.php';
$redirect = $success = 0;
$redirect_link = "";
$msg = "Invalid arguments";
if ((isset($_FILES['images']) || isset($_REQUEST['status_id']) || isset($_REQUEST['event_manager_id'])) && isset($_REQUEST['id'])) {
    $id = trim($_REQUEST['id']);
    $status_id = trim($_REQUEST['status_id']);
    $event_manager_id = isset($_REQUEST['event_manager_id'])?trim($_REQUEST['event_manager_id']):"";
    $images = $_FILES['images'];
    $obj = Event::getById($id);
    if (isset($_REQUEST['status_id'])) {
        $obj->setStatus_id($status_id);
    }
    if (isset($_REQUEST['event_manager_id'])) {
        $obj->setEvent_manager_id($event_manager_id);
    }
    $obj->save();
    $success=1;
    $msg = "Record saved successfully";
    $target_dir = dirname(__FILE__) . "/../../uploads/";
    if (isset($_FILES['images'])) {
        foreach ($_FILES['images']["tmp_name"] as  $key=>$tmp_name) {
            $target_file = basename($_FILES['images']["name"][$key]);
            $image_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if(empty($image_extension))                continue;
            $ser = new EventImages($id, $image_extension);
            $ser->add();
            $image_id = $ser->getImage_id();
            @move_uploaded_file($_FILES['images']["tmp_name"][$key], ($target_dir . $image_id . "." . $image_extension));
        }
    }
}
echo json_encode(array("success" => $success, "message" => $msg, "redirect" => $redirect, "redirect_link" => $redirect_link));
die();
?>

