<?php

require_once __DIR__ . '/../DAO/RoleDAO.php';

class RoleController {


    public static function getRoles() {
        return RoleDAO::getRoles();
    }

}