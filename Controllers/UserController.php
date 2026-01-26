<?php
require_once(__DIR__ . "/../DAO/UserDAO.php");
require_once(__DIR__ . "/../models/User.php");

class UserController {
    // méthode pour ouvrir un user
    public static function openUser($id_user){
        return UserDAO::openUser($id_user);
    }


    static function getUsers(){
        $usersObjet = [];
        $users = UserDAO::getUsers();

        foreach($users as $user){
            $usersObjet[] = new User(
                $user["id_user"],
                $user["fname"],
                $user["lname"],
                $user["email"],
                $user["phone_number"],
                null,
                $user["role"]
            );
        }
        return $usersObjet;
    }

    static function getUser($email){
        $user = UserDAO::getUser($email);
        if($user){
            return new User(
                $user["id_user"],
                $user["fname"],
                $user["lname"],
                $user["email"],
                $user["phone_number"],
                $user["password"],
                $user["role_id"]
            );
        }
        return null;
    }

    static function login($email, $pwd){
        $user = self::getUser($email);

        if($user === null){
            $_SESSION['error'] = "user not found";
            return null;
        }

        $pwd_hashed = $user->getPassword();

   

        if (!password_verify($pwd, $pwd_hashed)) {
            $_SESSION['error'] = "wrong password";
            return null;
        }

        return $user;
    }
}


$hash = password_hash("123", PASSWORD_BCRYPT);
// echo ($hash);

