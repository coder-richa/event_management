<?php

include_once dirname(__FILE__) . '/../../classes/City.php';
include_once dirname(__FILE__) . '/../header.php';
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$tableObj = City::saveFormData($id);
$tableObj->success = 1;
$tableObj->message = "Form fetched successfully";
echo json_encode($tableObj);
die();
