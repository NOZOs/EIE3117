<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');

class RestaurantController {
    public static function showDashboard() {
        $session = SessionController::getInstance();
        $session->makeSureLoggedIn('/login');

        //if user type not restaurant, exit
        if ($session->getUserType() !== 'restaurant') {
            header("Location: /access-denied");
            exit();
        }

        $view = new View('restaurant_dashboard', 'Restaurant Dashboard');
        $view->render();
    }
}
?>