<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/FormErrors.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');
require_once(dirname(__FILE__) . '/../model/User.class.php');
require_once(dirname(__FILE__) . '/../model/Foodmenu.class.php');
require_once(dirname(__FILE__) . '/../model/Foodmenuorder.class.php');

class FoodmenudetailController {
    public static function showFoodmenudetail() {
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedIn('/login'); // Redirect if not logged in

        // Get the 'id' from the URL query string
        $fm_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        $foodmenudetailView = new View('d_fm', 'foodmenudetail');

        if (!empty($fm_id) && $fm_id >= 1) {
            // Fetch the specific food menu item by ID
            $foodmenu = Foodmenu::getFoodmenuByID($fm_id);
            if ($foodmenu === null) {
                // Handle case where the ID doesn't exist
                $foodmenudetailView->addVar('error', 'Food menu item not found');
            } else {
                // Pass the single food menu item as an array (to match the view's expectation)
                $foodmenudetailView->addVar('foodmenu', [$foodmenu]);
            }
        } else {
            // Handle invalid or missing ID (optional: redirect or show error)
            $foodmenudetailView->addVar('error', 'Invalid or missing food menu ID');
        }

        $foodmenudetailView->render();
    }

    public static function processBuyFoodmenu() {
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedIn('/login'); // Redirect if not logged in

        $fm_id = isset($_POST['fm_id']) ? (int)$_POST['fm_id'] : null;

        if (!empty($fm_id) && $fm_id >= 1) {
            // Fetch the food menu item by ID
            $fm = Foodmenu::getFoodmenuByID($fm_id);
            if ($fm !== null) {
                // Create a new Foodmenuorder object
                $fmo = new Foodmenuorder();
                $fmo->username = $fm->username; // Use the restaurant's username from foodmenu
                $fmo->customerName = $sessionController->getUser()->username; // Logged-in user as customer
                $fmo->foodTitle = $fm->foodTitle;
                $fmo->price = $fm->price;

                // Insert into foodmenuorder table
                if (Foodmenuorder::createNewFoodmenuorder($fmo)) {
                    // Successfully ordered, redirect to main page
                    header("Location: /main");
                    exit();
                } else {
                    // Handle error
                    $errorView = new View('error', 'Error');
                    $errorView->addVar('error', 'Failed to place the order. Please try again.');
                    $errorView->render();
                    exit();
                }
            }
        }

        // If fm_id is invalid or missing, redirect to main page silently
        header("Location: /main");
        exit();
    }
}
?>