<?php

require_once __DIR__ . '/../DAO/DeviceDAO.php';

class DeviceController {

    public static function getDevices() {
        return DeviceDAO::getDevices();
    }

    public static function openDevice($id_device) {
        return DeviceDAO::openDevice($id_device);
    }
}