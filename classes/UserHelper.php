<?php

trait UserHelper {

    function isExistingEmail($email) {
        return ($email == ADMIN_USERNAME || !is_null(EventManager::getByEmail($email)) || !is_null(Customer::getByEmail($email)) ) ? 1 : 0;
    }

}
