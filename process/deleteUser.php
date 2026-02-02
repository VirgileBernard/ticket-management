<?php
require_once __DIR__ . '/../Controllers/UserController.php';
require_once __DIR__ . '/../DAO/config/Baseurl.php';
require_once __DIR__ . '/../helpers/AccessControl.php';

session_start();

// Only supervisors can delete users
AccessControl::requireSupervisor();

// var_dump($_POST);
// exit;

$_SESSION['flash-message delete'] = "L'utilisateur a été supprimé";

if(!isset($_POST['id_user'])){
    die ('ID user manquant');
}

$id_user = intval($_POST['id_user']);

UserController::deleteUser($id_user);

header('Location: ../views/team.php');
exit;