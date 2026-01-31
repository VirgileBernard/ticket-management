<?php

require_once __DIR__ . '/../Controllers/UserController.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../DAO/config/Baseurl.php';
session_start();


if(
    !isset($_POST['fname']) ||
    !isset($_POST['lname']) ||
    !isset($_POST['email']) ||
    !isset($_POST['phone_number']) ||
    !isset($_POST['password']) ||
    !isset($_POST['role_id'])
) {
var_dump($_POST);
die("Champs manquants");
}

$user = new User(
    null,
    $_POST['fname'],
    $_POST['lname'],
    $_POST['email'],
    $_POST['phone_number'],
    $_POST['password'],
    $_POST['role_id'],
);

$newId = UserController::createUser($user);

$_SESSION['flash_message_success'] = "Client créé avec succès";

header("Location: " . BASE_URL . "views/team.php");
exit;
