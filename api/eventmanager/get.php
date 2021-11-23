<?php
include_once dirname(__FILE__) . '/../../classes/EventManager.php';
include_once dirname(__FILE__) . '/../header.php';
//$title= isset($_REQUEST['name'])?$_REQUEST['name']:"";
$first_name= isset($_REQUEST['first_name'])?$_REQUEST['first_name']:"";
$last_name= isset($_REQUEST['last_name'])?$_REQUEST['last_name']:"";
$contact_number= isset($_REQUEST['contact_number'])?$_REQUEST['contact_number']:"";
$email= isset($_REQUEST['email_id'])?$_REQUEST['email_id']:"";
$tableObj= EventManager::getTableData($first_name, $last_name, $contact_number, $email);
$tableObj->success=1;
$tableObj->message="Record fetched successfully";
echo json_encode($tableObj);
die();