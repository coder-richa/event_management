<?php

@session_start();

class SiteSession {

    static function addSessionAttributes($attributes = array()) {
        foreach ($attributes as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    static function startUserSession($user_type, $user_id) {
        self::addSessionAttributes(array("USER_TYPE" => $user_type, "USER_ID" => $user_id));
    }

    static function destroySessionAttributes() {
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
    }

}

?>