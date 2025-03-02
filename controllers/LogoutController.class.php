<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');
class LogoutController {
    public static function logout() {
        // This shows the logout page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedIn('/login'); // Why a logged out user want to access this page?

        // Logout user
        SessionController::getInstance()->logout();
        
        $logoutView = new View('logout', 'Logout');
        $logoutView->render();
    }
}
?>