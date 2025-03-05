<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/FormErrors.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');
require_once(dirname(__FILE__) . '/../class/Validation.class.php');
require_once(dirname(__FILE__) . '/../model/User.class.php');
require_once(dirname(__FILE__) . '/../model/Foodmenu.class.php');
class FoodmenuController {

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
        
        
        if(!$formErrors->haveError() && !Validation::validateFm_fT($_POST["fm_fT"])) {
            $formErrors->add('fm_fT', 'Description must be 1-50 characters');
        }
        if(!$formErrors->haveError() && !Validation::validateFm_dD($_POST["fm_dD"])) {
            $formErrors->add('fm_dD', 'Description must be 1-50 characters');
        }
        if(!$formErrors->haveError() && !Validation::validateFm_fP($_POST["fm_fP"])) {
            $formErrors->add('fm_fP', 'Price must be a positive number');
        }
        
        
        if(!$formErrors->haveError()) {
            $newFM = new Foodmenu();
            $newFM->username = SessionController::getInstance()->getUser()->username;
            $newFM->foodTitle = $_POST["fm_fT"];
            $newFM->dishDescription = $_POST["fm_dD"];
            $newFM->price= $_POST["fm_fP"];
            
            if(Foodmenu::createNewFoodmenu($newFM)) {
                $addFoodmenuPageView = new View('add_fm_succeed', 'Add Foodmenu: Succeed');
                $addFoodmenuPageView->render();
                exit();
            } else {
                if(!Validation::validateFm_fT($_POST["fm_fT"])){
                    $formErrors->add('fm_fT', 'Unable to add Foodmenu, please try again later');
                }
                if(!Validation::validateFm_dD($_POST["fm_dD"])){
                    $formErrors->add('fm_dD', 'Unable to add Foodmenu, please try again later');
                }
                if(!Validation::validateFm_fP($_POST["fm_fP"])){
                    $formErrors->add('fm_fP', 'Unable to add Foodmenu, please try again later');
                }
                
            }
        }
        
        $addFoodmenuPageView->addVar('form_errors', $formErrors);
        $addFoodmenuPageView->render();
    }
}
?>