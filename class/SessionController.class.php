<?php
require_once(dirname(__FILE__) . '/../model/User.class.php');

class SessionController {
    private static $instance = null;

    function __construct() {
        session_start();
        
        if (!$this->isUserLoggedIn() && isset($_COOKIE['user_session'])) {
            $cookieData = json_decode($_COOKIE['user_session'], true);
            $user = User::getUserByUsername($cookieData['username']);
            if ($user && $user->type === $cookieData['type']) {
                $this->login($user); 
            }
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new SessionController();
        }
        return self::$instance;
    }

    private function setUserType(string $type) {
        $_SESSION['user_type'] = $type;
    }

    public function getUserType(): string {
        return $_SESSION['user_type'] ?? 'guest';
    }

    public function isUserLoggedIn(): bool {
        return isset($_SESSION['user']);
    }

    public function getUser(): ?User {
        return $_SESSION['user'] ?? null;
    }

    public function setUser(User $user): void {
        $_SESSION['user'] = $user;
        $this->setUserType($user->type);
    }

    public function login(User $user) {
        $this->setUser($user);
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

    public function logout() {
        unset($_SESSION['user']);
        unset($_SESSION['user_type']);
        setcookie('user_session', '', time() - 3600, '/');
    }

    public function makeSureLoggedIn(string $redirectPath) {
        if (!$this->isUserLoggedIn()) {
            header("Location: $redirectPath");
            exit();
        }
    }

    public function makeSureLoggedOut(string $redirectPath) {
        if ($this->isUserLoggedIn()) {
            header("Location: $redirectPath");
            exit();
        }
    }
}
?>