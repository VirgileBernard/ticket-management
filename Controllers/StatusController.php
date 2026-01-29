<?php

require_once __DIR__ . '/../DAO/StatusDAO.php';

class StatusController{

public static function getStatus(){
    return StatusDAO::getStatus();
}

}