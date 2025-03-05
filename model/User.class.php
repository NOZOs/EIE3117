<?php
require_once(dirname(__FILE__) . '/../class/Database.class.php');

class User {
    public $username, $password, $email, $nick_name, $type, $profile_image;

    public static function getUserByUsername(string $username): ?User {
        $query = Database::query("SELECT * FROM `users` WHERE `username`='" . $username . "'");
        $result = $query->fetchAll();
        if(count($result) == 0) return null;
        $user = new User();
        $user->username = $result[0]["username"];
        $user->password = $result[0]["password"];
        $user->email = $result[0]["email"];
        $user->nick_name = $result[0]["nick_name"];
        $user->type = $result[0]["type"];
        $user->profile_image = $result[0]["profile_image"];
        return $user;
    }

    public static function getUserByUsernameAndPassword(string $username, string $password): ?User {
        $query = Database::query("SELECT * FROM `users` WHERE `username`='" . $username . "' AND `password`='" . $password . "'");
        $result = $query->fetchAll();
        if(count($result) == 0) return null;
        $user = new User();
        $user->username = $result[0]["username"];
        $user->password = $result[0]["password"];
        $user->email = $result[0]["email"];
        $user->nick_name = $result[0]["nick_name"];
        $user->type = $result[0]["type"];
        $user->profile_image = $result[0]["profile_image"];
        return $user;
    }

    public static function createNewUser(User $user): bool {
        return Database::execute(
            "INSERT INTO `users` (`username`, `password`, `email`, `nick_name`, `type`) " .
            "VALUES('" . $user->username . "', " .
                   "'" . $user->password . "', " .
                   "'" . $user->email . "', " .
                   "'" . $user->nick_name . "', " .
                   "'" . $user->type . "')"
        );
    }

    public static function updateUserPassword(User $user, string $newPassword): bool {
        return Database::execute("UPDATE `users` SET `password`='" . $newPassword . "' WHERE `username`='" . $user->username . "'");
    }
}
?>