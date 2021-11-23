<?php

include_once dirname(__FILE__) . '/../../classes/State.php';
include_once dirname(__FILE__) . '/../header.php';
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$tableObj = State::saveFormData($id);
$tableObj->success = 1;
$tableObj->message = "Form fetched successfully";
echo json_encode($tableObj);
die();
