<?php

/** SITE SETTINGS * */
define('SITE_NAME', 'ABC Event Organizer');
define('SITE_EMAIL', 'info@eventmanager.com');
define('SITE_CONTACT', '022 1234 5678');
define('SITE_ADDRESS', 'XYZ Linked Road, Sydney');
define('SITE_TWITTER', '#');
define('SITE_FACEBOOK', '#');
define('SITE_INSTA', '#');
define('SITE_LINKEDIN', '#');

/** USER TYPE & MENU SETTINGS * */
define('GUEST_USER', "Guest");
define('ADMIN_USER', "Admin");
define('CUSTOMER_USER', "Customer");
define('MANAGER_USER', "Manager");
define("TARGET_FORM_MODEL", "#popupFormModal");
$guestMenu = array(
    array("title" => "Home", "link" => "#hero"),
    array("title" => "About", "link" => "#about"),
    array("title" => "Services", "link" => "#services"),
    array("title" => "Contact", "link" => "#contact"),
    array("title" => "Login", "link" => TARGET_FORM_MODEL, "custom-class" => "show-modal", "data-attr" => array("data-title" => "Login", "data-content" => "#loginFrmContainer", "data-modal" => TARGET_FORM_MODEL)),
    array("title" => "Register", "link" => TARGET_FORM_MODEL, "custom-class" => "show-modal", "data-attr" => array("data-title" => "Register", "data-content" => "#registrationFrmContainer", "data-modal" => TARGET_FORM_MODEL)),
);
$adminMenu = array(
    array("title" => "Booking", "link" => "event-bookings.php"),
    array("title" => "Manager", "link" => "event-manager.php"),
    array("title" => "Event Type", "link" => "event-type.php"),
    array("title" => "Event Status", "link" => "event-status.php"),
    array("title" => "State", "link" => "state.php"),
    array("title" => "City", "link" => "city.php"),
    array("title" => "Logout", "link" => "logout.php"),
);
$managerMenu = array(
    array("title" => "Booking", "link" => "event-bookings.php"),   
    array("title" => "Logout", "link" => "logout.php"),
);

$customerMenu = array(
     array("title" => "Bookings", "link" => "event-bookings.php"),
    array("title" => "Make Booking", "link" => "make-booking.php"),   
    array("title" => "Logout", "link" => "logout.php"),
);

$menu = array(GUEST_USER => $guestMenu, ADMIN_USER => $adminMenu, MANAGER_USER => $managerMenu, CUSTOMER_USER => $customerMenu);
define('SITE_MENU', $menu);
define('VIEW_BOOKING', "view-bookings.php");
define('CUSTOMER_DASHBOARD', SITE_MENU[CUSTOMER_USER][0]["link"]);
define('ADMIN_DASHBOARD', SITE_MENU[ADMIN_USER][0]["link"]);
define('MANAGER_DASHBOARD', SITE_MENU[MANAGER_USER][0]["link"]);


/** ADMIN LOGIN SETTINGS * */
define("ADMIN_USERNAME", "admin@gmail.com");
define("ADMIN_PASSWORD", "admin");

/** DATABASE SETTINGS * */
define("DB_USER", "root");
define("DB_PASSWORD", "");

define("DB_NAME", "event_management");
define("DB_HOST", "localhost");
define("CITY_TBL", DB_NAME . "." . "city");
define("STATE_TBL", DB_NAME . "." . "state");
define("CUSTOMER_TBL", DB_NAME . "." . "customer");
define("EVENT_MANAGER_TBL", DB_NAME . "." . "event_manager");
define("EVENT_TYPE_TBL", DB_NAME . "." . "event_type");
define("EVENT_STATUS_TBL", DB_NAME . "." . "event_status");
define("SERVICES_TBL", DB_NAME . "." . "services");
define("CUSTOMER_ADDRESS_TBL", DB_NAME . "." . "customer_address_details");
define("EVENT_TBL", DB_NAME . "." . "event");
define("EVENT_SERVICES_TBL", DB_NAME . "." . "event_services_details");
define("EVENT_LOCATION_TBL", DB_NAME . "." . "event_location_details");
define("EVENT_IMAGES_TBL", DB_NAME . "." . "event_images");

/** API PATH * */
define("API_URL", "http://localhost/event_management/api/");
define("LOGIN_API_URL", API_URL . "login.php");
define("CUSTOMER_API_URL", API_URL . "customer/");
define("CUSTOMER_ADD_API_URL", CUSTOMER_API_URL . "register.php");
// State
define("STATE_API_URL", API_URL . "state/");
define("STATE_SAVE_API_URL", STATE_API_URL . "save.php");
define("STATE_GET_API_URL", STATE_API_URL . "get.php");
define("STATE_SAVE_FORM_API_URL", STATE_API_URL . "save-form.php");
define("STATE_DELETE_API_URL", STATE_API_URL . "delete.php");
// City
define("CITY_API_URL", API_URL . "city/");
define("CITY_SAVE_API_URL", CITY_API_URL . "save.php");
define("CITY_GET_API_URL", CITY_API_URL . "get.php");
define("CITY_SAVE_FORM_API_URL", CITY_API_URL . "save-form.php");
define("CITY_DELETE_API_URL", CITY_API_URL . "delete.php");
// Manager
define("EVENT_MANAGER_API_URL", API_URL . "eventmanager/");
define("EVENT_MANAGER_SAVE_API_URL", EVENT_MANAGER_API_URL . "save.php");
define("EVENT_MANAGER_GET_API_URL", EVENT_MANAGER_API_URL . "get.php");
define("EVENT_MANAGER_SAVE_FORM_API_URL", EVENT_MANAGER_API_URL . "save-form.php");
define("EVENT_MANAGER_DELETE_API_URL", EVENT_MANAGER_API_URL . "delete.php");
// EventType
define("EVENT_TYPE_API_URL", API_URL . "eventtype/");
define("EVENT_TYPE_SAVE_API_URL", EVENT_TYPE_API_URL . "save.php");
define("EVENT_TYPE_GET_API_URL", EVENT_TYPE_API_URL . "get.php");
define("EVENT_TYPE_SAVE_FORM_API_URL", EVENT_TYPE_API_URL . "save-form.php");
define("EVENT_TYPE_DELETE_API_URL", EVENT_TYPE_API_URL . "delete.php");

// Event Status
define("EVENT_STATUS_API_URL", API_URL . "eventstatus/");
define("EVENT_STATUS_SAVE_API_URL", EVENT_STATUS_API_URL . "save.php");
define("EVENT_STATUS_GET_API_URL", EVENT_STATUS_API_URL . "get.php");
define("EVENT_STATUS_SAVE_FORM_API_URL", EVENT_STATUS_API_URL . "save-form.php");
define("EVENT_STATUS_DELETE_API_URL", EVENT_STATUS_API_URL . "delete.php");
// State
define("EVENT_API_URL", API_URL . "event/");
define("EVENT_SAVE_API_URL", EVENT_API_URL . "save.php");
define("EVENT_GET_API_URL", EVENT_API_URL . "get.php");
define("EVENT_SAVE_FORM_API_URL", EVENT_API_URL . "save-form.php");
define("EVENT_SAVE_UPDATE_API_URL", EVENT_API_URL . "edit.php");
define("EVENT_DELETE_API_URL", EVENT_API_URL . "delete.php");
/** CSS SETTINGS * */
define("EDIT_ICON", "bi bi-pencil");
define("DELETE_ICON", "bx bx-minus");
define("VIEW_ICON", "bi bi-eye-fill");
define("BTN_CLASS", "btn btn-success");
define("ROW_CLASS", "row");
define("HIDDEN_CLASS", "hidden");
define("COL6_CLASS", "col-sm-6");
define("COL12_CLASS", "col-sm-12");
define("FORM_LABEL_CLASS", "form-label");
define("FORM_SUBMIT_BTN_CLASS", BTN_CLASS . " form-submit");
define("IS_REQUIRED_CLASS", "isRequired");
define("FORM_GROUP_CLASS", "form-group");
define("FORM_ALERT_CLASS", "form-alert");
define("FORM_ALERT_SUCCESS_CLASS", "form-alert-success");
define("FORM_ALERT_FAILURE_CLASS", "form-alert-failure");
define("FORM_CONTROL_CLASS", "form-control");
?>

