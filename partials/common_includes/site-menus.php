<?php
$userType = isset($_SESSION['USER_TYPE']) ? $_SESSION['USER_TYPE'] : GUEST_USER;
$siteMenu = SITE_MENU[$userType];
$allowed_links = array_column($siteMenu, 'link', 'title');
$url = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
// Redirect user to home page when opening non-authorized page
if (!(in_array($url, $allowed_links) || $url == "index.php" || ($userType != GUEST_USER && $url = "view-bookings"))) {
    header("location:" . $siteMenu[0]['link']);
}
?>