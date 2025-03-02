<?php
require_once(dirname(__FILE__) . '/../class/Database.class.php');
class User {
    public $username, $password, $email;

    public static function getUserByUsername(string $username): ?User {
        $query = Database::query("SELECT * FROM `users` WHERE `username`='" . $username . "'");
        $result = $query->fetchAll();
        if(count($result) == 0) return null;
        $user = new User();
        $user->username=$result[0]["username"];
        $user->password=$result[0]["password"];
        $user->email=$result[0]["email"];
        return $user;
    }
    public static function getUserByUsernameAndPassword(string $username, string $password): ?User {
        $query = Database::query("SELECT * FROM `users` WHERE `username`='" . $username . "' AND `password`='" . $password . "'");
        $result = $query->fetchAll();
        if(count($result) == 0) return null;
        $user = new User();
        $user->username=$result[0]["username"];
        $user->password=$result[0]["password"];
        $user->email=$result[0]["email"];
        return $user;
    }
    public static function createNewUser(User $user): bool {
        return Database::execute("INSERT INTO `users` (`username`, `password`, `email`) VALUES('" . $user->username . "', '" . $user->password . "', '" . $user->email . "')");
        
    }
    public static function updateUserPassword(User $user, string $newPassword): bool {
        return Database::execute("UPDATE `users` SET `password`='" . $newPassword . "' WHERE `username`='" . $user->username . "'");
    }
}
?>