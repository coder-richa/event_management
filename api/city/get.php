<?php
include_once dirname(__FILE__) . '/../../classes/City.php';
include_once dirname(__FILE__) . '/../header.php';
$title= isset($_REQUEST['name'])?$_REQUEST['name']:"";
$tableObj=City::getTableData($title);
$tableObj->success=1;
$tableObj->message="Record fetched successfully";
echo json_encode($tableObj);
die();