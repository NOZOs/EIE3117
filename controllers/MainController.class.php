<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');
require_once(dirname(__FILE__) . '/../model/User.class.php');
require_once(dirname(__FILE__) . '/../model/Bookmark.class.php');
class MainController {
    public static function showMain() {
        // This shows the main page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedIn('/login'); // Why a logged out user want to access this page?

        $userBookmarks = Bookmark::getUserBookmarks(SessionController::getInstance()->getUser());
        $mainView = new View('main', 'Main');
        $mainView->addVar('bookmarks', $userBookmarks);
        $mainView->render();
    }
   
}
?>