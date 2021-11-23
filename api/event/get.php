<?php

include_once dirname(__FILE__) . '/../../classes/Event.php';
include_once dirname(__FILE__) . '/../header.php';
$event_start_on = isset($_REQUEST['event_start_on']) ? $_REQUEST['event_start_on'] : "";
$event_end_on = isset($_REQUEST['event_end_on']) ? $_REQUEST['event_end_on'] : "";
$type_id = isset($_REQUEST['type_id']) && is_numeric($_REQUEST['type_id']) ? $_REQUEST['type_id'] : "";
$city_id = isset($_REQUEST['city_id']) && is_numeric($_REQUEST['city_id']) ? $_REQUEST['city_id'] : "";
$status_id = isset($_REQUEST['status_id']) && is_numeric($_REQUEST['status_id']) ? $_REQUEST['status_id'] : "";
$event_manager_id = isset($_REQUEST['event_manager_id']) && is_numeric($_REQUEST['event_manager_id']) ? $_REQUEST['event_manager_id'] : "";
$tableObj = Event::getTableData($event_start_on,$event_end_on,$type_id,$city_id,$status_id,$event_manager_id);
$tableObj->success = 1;
$tableObj->message = "Record fetched successfully";
echo json_encode($tableObj);
die();
