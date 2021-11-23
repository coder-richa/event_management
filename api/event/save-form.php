<?php
include_once dirname(__FILE__) . '/../../classes/Event.php';
include_once dirname(__FILE__) . '/../header.php';
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$tableObj = Event::statusFormData($id);
$tableObj->success = 1;
$tableObj->message = "Form fetched successfully";
echo json_encode($tableObj);
die();
