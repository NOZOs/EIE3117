<?php
require_once(dirname(__FILE__) . '/../class/Database.class.php');

class User {
    public $username, $password, $email, $nick_name, $type, $profile_image;

    public static function getUserByUsername(string $username): ?User {
        $query = Database::query(
            "SELECT * FROM `users` WHERE `username` = :username",
            [':username' => $username] 
        );
        $result = $query->fetchAll();
        if (count($result) == 0) return null;

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
        $user = self::getUserByUsername($username);
        
        if ($user && password_verify($password, $user->password)) {
            return $user;
        } elseif ($user && hash('sha1', $password) === $user->password) {
            self::migratePasswordToBcrypt($user, $password);
            return $user;
        }
        return null;
    }

    public static function createNewUser(User $user): bool {
        $user->password = password_hash($user->password, PASSWORD_BCRYPT);
        
        return Database::execute(
            "INSERT INTO `users` (`username`, `password`, `email`, `nick_name`, `type`) 
            VALUES (:username, :password, :email, :nick_name, :type)",
            [
                ':username' => $user->username,
                ':password' => $user->password,
                ':email' => $user->email,
                ':nick_name' => $user->nick_name,
                ':type' => $user->type
            ] 
        );
    }

    public static function updateUserPassword(User $user, string $newPassword): bool {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        return Database::execute(
            "UPDATE `users` SET `password` = :password WHERE `username` = :username",
            [
                ':password' => $hashedPassword,
                ':username' => $user->username
            ] 
        );
    }

    public static function updateProfileImage(User $user, string $filename): bool {
        return Database::execute(
            "UPDATE `users` SET `profile_image` = :filename WHERE `username` = :username",
            [
                ':filename' => $filename,
                ':username' => $user->username
            ] 
        );
    }

    private static function migratePasswordToBcrypt(User $user, string $plainPassword): void {
        $newHash = password_hash($plainPassword, PASSWORD_BCRYPT);
        self::updateUserPassword($user, $newHash);
    }
}
?>