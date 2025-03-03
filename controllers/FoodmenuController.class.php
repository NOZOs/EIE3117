<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/FormErrors.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');
require_once(dirname(__FILE__) . '/../class/Validation.class.php');
require_once(dirname(__FILE__) . '/../model/User.class.php');
require_once(dirname(__FILE__) . '/../model/Foodmenu.class.php');
class FoodemenuController {

    public static function showAddFoodmenu() {
        // This shows the add bookmark page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedIn('/login'); // Why a logged out user want to access this page?
       
        $addFoodmenuPageView = new View('add_fm', 'Add Foodmenu');
        $formErrors = new FormErrors(); // No errors as we do not have submitted anything yet
        $addFoodmenuPageView->addVar('form_errors', $formErrors);
        $addFoodmenuPageView->render();
    }

    public static function processAddFoodmenu() {
        // This shows the submitted add bookmark page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedIn('/login'); // Why a logged out user want to access this page?
        $addFoodmenuPageView = new View('add_fm', 'Add Foodmenu');
        $formErrors = new FormErrors();

        // Validation of POST fields
        // Check whether the fields are empty
        if(empty($_POST["fm_fT"])) {
            $formErrors->add('fm_fT', 'Food Type Description cannot be blank');
        }
        if(empty($_POST["fm_dD"])) {
            $formErrors->add('fm_dD', 'Food Type Description cannot be blank');
        }
        if(empty($_POST["fm_fP"])) {
            $formErrors->add('fm_fP', 'Food Price cannot be blank');
        }
        
        // 验证字段格式
        if(!$formErrors->haveError() && !Validation::validateFm_fT($_POST["fm_fT"])) {
            $formErrors->add('fm_fT', 'Description must be 1-50 characters');
        }
        if(!$formErrors->haveError() && !Validation::validateFm_dD($_POST["fm_dD"])) {
            $formErrors->add('fm_dD', 'Description must be 1-50 characters');
        }
        if(!$formErrors->haveError() && !Validation::validateFm_fP($_POST["fm_fP"])) {
            $formErrors->add('fm_fP', 'Price must be a positive number');
        }
        
        // 数据库操作部分
        if(!$formErrors->haveError()) {
            $newFM = new Foodmenu();
            $newFM->username = SessionController::getInstance()->getUser()->username;
            $newFM->title = $_POST["fm_fT"];
            $newFM->description = $_POST["fm_dD"];
            $newFM->price = $_POST["fm_fP"];
            
            if(Foodmenu::createNewFoodmenu($newFM)) {
                $addFoodmenuPageView = new View('add_fm_succeed', 'Add Foodmenu: Succeed');
                $addFoodmenuPageView->render();
                exit();
            } else {
                $formErrors->add('fm_fTdD', 'Unable to add Foodmenu, please try again later');
            }
        }
        
        $addFoodmenuPageView->addVar('form_errors', $formErrors);
        $addFoodmenuPageView->render();
    }

    public static function viewFoodmenu($fm_id) {
        // This shows the delete bookmark page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedIn('/login'); // Why a logged out user want to access this page?
        if(!empty($fm_id)) { // Bookmark ID should not be empty
            if($fm_id >= 1) { // Bookmark id should be >=1
                // Check whether this ID belongs to the logged in user
                $fm = Foodmenu::getFoodmenuByID($fm_id);
                if($fm !== null && $fm->username === SessionController::getInstance()->getUser()->username) {
                    // The bm_id is valid and belongs to the current user
                    // Delete it, we ignore the result of the deletion
                    $fm->delete();
                }
            }
        }
        // Silently return to the main page
        header("Location: /main");
    }
}
?>