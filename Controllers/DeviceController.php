<?php

require_once __DIR__ . '/../DAO/DeviceDAO.php';

class DeviceController {

    public static function getDevices() {
        return DeviceDAO::getDevices();
    }

    public static function getDevice($id_device) {
        return DeviceDAO::getDevice($id_device);
    }

    public static function updateDevice($device) {
        return DeviceDAO::updateDevice($device);
    }
}