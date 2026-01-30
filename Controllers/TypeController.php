<?php

require_once __DIR__ . '/../DAO/TypeDAO.php';

class TypeController{

public static function getTypes(){
    return TypeDAO::getTypes();
}


}