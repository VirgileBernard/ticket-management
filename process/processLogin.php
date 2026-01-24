<?php
session_start();


require_once(__DIR__ . "/../controllers/UserController.php");
require_once(__DIR__ . "/../DAO/UserDAO.php");
require_once(__DIR__ . "/../models/User.php");

// Protection contre fixation de session
if (empty($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$pwd   = trim($_POST['password'] ?? '');

if ($email === '' || $pwd === '') {
    $_SESSION['error'] = "Veuillez remplir tous les champs";
    header("Location: ../views/login.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Format d'email invalide";
    header("Location: ../views/login.php");
    exit;
}

$user = UserController::login($email, $pwd);


if (!$user) {
    $_SESSION['error'] = "Email ou mot de passe incorrect";
    header("Location: ../views/login.php");
    exit;
}


$_SESSION["user_lname"]  = $user->getLname();
$_SESSION["user_fname"]  = $user->getFname();
$_SESSION["Email"]       = $user->getEmail();
$_SESSION["user_role"]   = $user->getRoleId();
$_SESSION["logged_in"]   = true;
$_SESSION["id_user"]     = $user->getIdUser();
$_SESSION["user_role"]   = $user->getRoleId();

echo $_SESSION["logged_in"];
echo $_SESSION;

unset($_SESSION['error']);

header("Location: ../views/index.php");
exit;
