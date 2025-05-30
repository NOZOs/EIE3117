<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');
require_once(dirname(__FILE__) . '/../model/User.class.php');
require_once(dirname(__FILE__) . '/../model/Foodmenu.class.php');

class MainController {
    public static function showMain() {
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedIn('/login');
        
        $allFoodmenus = Foodmenu::getAllFoodmenus();

        $mainView = new View('main', 'Main');
        $mainView->addVar('foodmenu', $allFoodmenus);
        $mainView->render();
    }
}
?>