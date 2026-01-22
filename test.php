<?php 
require_once(__DIR__ . "/Controllers/UserController.php");
echo __DIR__ . "/Controllers/UserController.php";



$user = UserController::getUser("alice.martin@example.com");
echo $user;