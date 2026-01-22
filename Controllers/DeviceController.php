<?php

require_once __DIR__ . '/../DAO/DeviceDAO.php';

class DeviceController {

    public static function getDevices() {
        return DeviceDAO::getDevices();
    }
}