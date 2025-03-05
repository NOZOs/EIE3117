<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');
require_once(dirname(__FILE__) . '/../model/User.class.php');
require_once(dirname(__FILE__) . '/../model/Bookmark.class.php');
require_once(dirname(__FILE__) . '/../model/Foodmenu.class.php');
require_once(dirname(__FILE__) . '/../model/Foodmenuorder.class.php');
class FoodmenuorderController {
    public static function showFoodmenuorder() {
        // This shows the order page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedIn('/login'); // Why a logged out user want to access this page?

        $userFoodmenuorder = Foodmenuorder::getUserFoodmenuorder(SessionController::getInstance()->getUser());
        $foodmenuorderView = new View('foodmenuorder', 'foodmenuorder');
        $foodmenuorderView->addVar('foodmenuorder', $userFoodmenuorder);
        $foodmenuorderView->render();
    }
   
    public static function deleteFoodmenuorder($fmo_id) {
        // This shows the delete bookmark page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedIn('/login'); // Why a logged out user want to access this page?
        if(!empty($fmo_id)) { // Bookmark ID should not be empty
            if($fmo_id >= 1) { // Bookmark id should be >=1
                // Check whether this ID belongs to the logged in user
                $fmo = Foodmenuorder::getFoodmenuorderByID($fmo_id);
                if($fmo !== null && $fmo->username === SessionController::getInstance()->getUser()->username) {
                    // The bm_id is valid and belongs to the current user
                    // Delete it, we ignore the result of the deletion
                    $fmo->delete();
                }
            }
        }   
        // Silently return to the main page
        header("Location: /main");
    }
}
?>