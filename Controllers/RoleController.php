<?php

require_once __DIR__ . '/../DAO/RoleDAO.php';

class RoleController {


    public static function getRoles() {
        return RoleDAO::getRoles();
    }

    public static function getRoleById($role_id) {
    $roles = RoleDAO::getRoles();
    foreach ($roles as $role) {
        if ($role->getId() == $role_id) {
            return $role;
        }
    }
    return null;
}


}