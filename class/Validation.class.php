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
    public static function validateURL(string $url): bool {
        $proto = strstr($url, 'http://');
        if($proto === false) return false;
        if (!(@fopen($url, 'r'))) return false; // WARNING: HUGE SECURITY VULNERABILITY, JUST FOR DEMO
        return true;
    }
}
?>