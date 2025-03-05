<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');

class ConsumerController {
    public static function showHome() {
        $session = SessionController::getInstance();
        $session->makeSureLoggedIn('/login');

        if ($session->getUserType() !== 'consumer') {
            header("Location: /access-denied");
            exit();
        }

        $view = new View('consumer_home', 'Home');
        $view->render();
    }
}
?>