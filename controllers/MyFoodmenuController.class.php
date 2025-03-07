<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');
require_once(dirname(__FILE__) . '/../model/User.class.php');
require_once(dirname(__FILE__) . '/../model/Foodmenu.class.php');

class MyFoodmenuController {
    public static function showMyFoodmenu() {
        // This shows the user's own food menu page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedIn('/login'); // Redirect if not logged in

        // Get only the current user's food menu items
        $user = $sessionController->getUser();
        $myFoodmenu = Foodmenu::getUserFoodmenu($user); // Assumes this method returns foodmenu for specific user
        
        $myFoodmenuView = new View('my_foodmenu', 'My Food Menu');
        $myFoodmenuView->addVar('foodmenu', $myFoodmenu);
        $myFoodmenuView->render();
    }
}
?>