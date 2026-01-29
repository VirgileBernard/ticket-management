<?php

require_once(__DIR__ . "/../models/User.php");
require_once(__DIR__ . "/../DAO/config/Baseurl.php");
require_once(__DIR__ . "/../Controllers/UserController.php");

session_start();
$_SESSION['flash-message edit'] = "Les informations du membre ont été mises à jour avec succès.";

$user = new User(
    $_POST['id_user'],
    $_POST['fname'],
    $_POST['lname'],
    $_POST['email'],
    $_POST['phone'],
    null,
    $_POST['role_id']
);

UserController::updateUser($user);

header("Location: " . BASE_URL . "views/team.php");
 exit;
