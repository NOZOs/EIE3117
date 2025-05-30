<?php
require_once(dirname(__FILE__) . '/../model/User.class.php');
class SessionController {
    private static $instance=null;
    function __construct() {
        session_start([
            'cookie_lifetime' => 86400,
            'cookie_secure'   => false,    // HTTPS
            'cookie_httponly' => true,
            'use_strict_mode' => true
        ]);
    
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        //Check cookie for automatic login.
        if (!$this->isUserLoggedIn() && isset($_COOKIE['user_session'])) {
            $cookieData = json_decode($_COOKIE['user_session'], true);
            $user = User::getUserByUsername($cookieData['username']);
            if ($user && $user->type === $cookieData['type']) {
                $this->login($user); 
            }
        }
    }
    public static function getInstance() {
        if(self::$instance == null) {
            self::$instance = new SessionController();
        }
        return self::$instance;
    }
    function setRole(string $role) {
        $_SESSION["user_role"]=$role;
    }

    private function setUserType(string $type) {
        $_SESSION['user_type'] = $type;
    }

    function isRestaurant(): bool {
        if ($this->isUserLoggedIn()) {
            $user = $this->getUser();
            return $user && $user->type === 'restaurant';
        }
        return false;
    }

    function getRole(): string {
        $role = $_SESSION['user_role'] ?? 'guest';
        return $role;
    }
    // Make sure the user is logged in, or else, redirect to $failureRedirectPath
    function MakeSureLoggedIn(string $failureRedirectPath) {
        if(!$this->isUserLoggedIn()) {
            header("Location: " . $failureRedirectPath);
            exit();
        }
    }
    // Make sure the user is logged out, or else, redirect to $failureRedirectPath
    function makeSureLoggedOut(string $failureRedirectPath) {
        if($this->isUserLoggedIn()) {
            header("Location: " . $failureRedirectPath);
            exit();
        }
    }
    function isUserLoggedIn(): bool {
        return ($this->getRole() === "user");
    }
    function getUser(): ?User {
        return $_SESSION["user"];
    }
    function setUser(?User $user): void {
        $_SESSION["user"] = $user;
    }
    function login(User $user) {
        $this->setUser($user);
        $this->setRole('user');
        setcookie(
            'user_session',
            json_encode([
                'username' => $user->username,
                'type' => $user->type
            ]),
            time() + 3600 * 24 * 30, 
            '/'
        );
    }
    function logout() {
        $this->setRole('guest');
        $this->setUser(null);
        unset($_SESSION['user']);
        unset($_SESSION['user_type']);
        setcookie('user_session', '', time() - 3600, '/'); //Expire and delete the cookie.
    }

    public static function getCSRFToken(): string {
        return $_SESSION['csrf_token'];
    }

}
?>
