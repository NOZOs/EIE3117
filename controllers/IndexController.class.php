<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');

class IndexController {
    public static function showIndex() {
        $session = SessionController::getInstance();
        
        if ($session->isUserLoggedIn()) {
            $redirectPath = ($session->getUserType() === 'restaurant') 
                ? '/restaurant/dashboard' 
                : '/consumer/home';
            header("Location: $redirectPath");
            exit();
        }

        $view = new View('index', 'Home');
        $view->render();
    }
}
?>