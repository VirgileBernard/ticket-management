<?php

require_once __DIR__ . '/../DAO/PriorityDAO.php';

class PriorityController{
    public static function getPrioritys(){
        return PriorityDAO::getPrioritys();
    }
}