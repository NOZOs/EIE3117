<?php
class Validation {
    // Check whether an email address is correct
    public static function validateEmailAddress(string $email): bool {
        $filtered=filter_var($email, FILTER_VALIDATE_EMAIL);
        return (!empty($filtered) && $filtered !== false);
    }
    // Check whether a username is in valid length: 5-16 characters
    public static function validateUsernameLength(string $username): bool {
        return (strlen($username) >= 5 && strlen($username) <= 16);
    }
    // Check whether a password is in valid length: 6-16 characters
    public static function validatePasswordLength(string $password): bool {
        return (strlen($password) >= 6 && strlen($password) <= 16);
    }
    // Check whether a URL is in valid format and reachable

    public static function validateFm_fT(string $fT): bool {
        return (strlen($fT) >= 1 && strlen($fT) <= 50);
    }
    public static function validateFm_dD(string $dD): bool {
        return (strlen($dD) >= 1 && strlen($dD) <= 50);
    }
    public static function validateFm_fP(string $fP): bool {
        if(is_numeric($fP) && $fP > 0){
            return true;
        }
        return false;
    }

    public static function validateFm_fA(string $fA): bool {
        if(is_numeric($fA) && $fA > 0){
            return true;
        }
        return false;
    }
}
?>