<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/FormErrors.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');
require_once(dirname(__FILE__) . '/../class/Validation.class.php');
require_once(dirname(__FILE__) . '/../model/User.class.php');
require_once(dirname(__FILE__) . '/../model/Bookmark.class.php');
class BookmarkController {

    public static function showAddBookmark() {
        // This shows the add bookmark page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedIn('/login'); // Why a logged out user want to access this page?
       
        $addBookmarkPageView = new View('add_bm', 'Add Bookmark');
        $formErrors = new FormErrors(); // No errors as we do not have submitted anything yet
        $addBookmarkPageView->addVar('form_errors', $formErrors);
        $addBookmarkPageView->render();
    }

    public static function processAddBookmark() {
        // This shows the submitted add bookmark page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedIn('/login'); // Why a logged out user want to access this page?

        $addBookmarkPageView = new View('add_bm', 'Add Bookmark');
        $formErrors = new FormErrors();

        // Validation of POST fields
        // Check whether the fields are empty
        if(empty($_POST["bm_url"])) {
            $formErrors->add('bm_url', 'BM URL cannot not be blank');
        }
        // Validate BM URL Format
        // We need the absence of previous errors to check this as this may overwritten by the empty BM URL check
        if(!$formErrors->haveError() && !Validation::validateURL($_POST["bm_url"])) {
            $formErrors->add('bm_url', 'BM URL is invalid');
        }

        // Everything is good, insert Bookmark into database
        if(!$formErrors->haveError()) {
            $newBM = new Bookmark();
            $newBM->username=SessionController::getInstance()->getUser()->username;
            $newBM->url=$_POST["bm_url"];
            if(Bookmark::createNewBookmark($newBM)) {
                // Bookmark added
                $addBookmarkPageView = new View('add_bm_succeed', 'Add Bookmark: Succeed');
                $addBookmarkPageView->render();
                exit(); // Rest of the code should not be executed.
            }else{
                // Cannot add bookmark
                $formErrors->add('bm_url', 'Unable to add bookmark at the moment, please try again later');
            }
        }
        
        $addBookmarkPageView->addVar('form_errors', $formErrors);
        $addBookmarkPageView->render();
    }

    public static function deleteBookmark($bm_id) {
        // This shows the delete bookmark page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedIn('/login'); // Why a logged out user want to access this page?
        if(!empty($bm_id)) { // Bookmark ID should not be empty
            if($bm_id >= 1) { // Bookmark id should be >=1
                // Check whether this ID belongs to the logged in user
                $bm = Bookmark::getBookmarkByID($bm_id);
                if($bm !== null && $bm->username === SessionController::getInstance()->getUser()->username) {
                    // The bm_id is valid and belongs to the current user
                    // Delete it, we ignore the result of the deletion
                    $bm->delete();
                }
            }
        }
        // Silently return to the main page
        header("Location: /main");
    }
}
?>