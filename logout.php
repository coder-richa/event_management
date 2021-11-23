<?php
include_once dirname(__FILE__) . '/classes/SiteSession.php';
SiteSession::destroySessionAttributes();
header("location: index.php");
?>

