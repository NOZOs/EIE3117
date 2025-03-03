<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/FormErrors.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');
require_once(dirname(__FILE__) . '/../class/Validation.class.php');
require_once(dirname(__FILE__) . '/../model/User.class.php');
class ChangePasswordController {

    public static function showChangePassword() {
        // This shows the change password page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedIn('/login'); // Why a logged out user want to access this page?
       
        $changePasswordPageView = new View('change_password', 'Change Password');
        $formErrors = new FormErrors(); // No errors as we do not have submitted anything yet
        $changePasswordPageView->addVar('form_errors', $formErrors);
        $changePasswordPageView->render();
    }

    public static function processChangePassword() {
        // This shows the submitted change password page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedIn('/login'); // Why a logged out user want to access this page?

        $changePasswordPageView = new View('change_password', 'Change Password');
        $formErrors = new FormErrors();

        // Validation of POST fields
        // Check whether the fields are empty
        if(empty($_POST["current_password"])) {
            $formErrors->add('current_password', 'Current Password should not be blank');
        }
        if(empty($_POST["new_password"])) {
            $formErrors->add('new_password', 'Password should not be blank');
        }
        if(empty($_POST["confirm_new_password"])) {
            $formErrors->add('confirm_new_password', 'Confirm Password should not be blank');
        }
        // Validate Password Length
        // We need the absence of previous errors to check this as this may overwritten by the empty current password check
        if(!$formErrors->haveError() && !Validation::validatePasswordLength($_POST["current_password"])) {
            $formErrors->add('current_password', 'Incorrect current password');
        }
        // We need the absence of previous errors to check this as this may overwritten by the empty password check
        if(!$formErrors->haveError() && !Validation::validatePasswordLength($_POST["new_password"])) {
            $formErrors->add('new_password', '');  // Just show the red border around the "password"
            $formErrors->add('confirm_new_password', 'Password must be in 6-16 characters');
        }
        // The two passwords need to be the same
        // We need the absence of previous errors to check this as this may overwritten by the empty password/password length check
        if(!$formErrors->haveError() && $_POST["new_password"] != $_POST["confirm_new_password"]) {
            $formErrors->add('new_password', '');  // Just show the red border around the "password"
            $formErrors->add('confirm_new_password', 'Both passwords do not match');
        }

        // As database query is resource expensive and "time consuming"
        // We make sure we only do DB queries after all checks are good
        // We now check whether the current password is correct and update the password
        if(!$formErrors->haveError()) {
            $user = User::getUserByUsernameAndPassword(SessionController::getInstance()->getUser()->username, sha1($_POST["current_password"]));
            if($user != null) { // Is a user with this username and password pair already exists?
                // If yes, current password is correct, we update the account password to new one
                if(User::updateUserPassword($user, sha1($_POST["new_password"]))) {
                    SessionController::getInstance()->logout(); // As password changed, we logout the user
                    $changePasswordPageView = new View('change_password_succeed', 'Change Password: Succeed');
                    $changePasswordPageView->render();
                    exit(); // Rest of the code should not be executed.
                }else{
                    // Failed to update the user's password
                    $formErrors->add('confirm_new_password', 'We are unable to update your password at the moment');
                }
            }else{
                // If not, current password is wrong
                $formErrors->add('current_password', 'Incorrect current password.');
            }
        }
        
        $changePasswordPageView->addVar('form_errors', $formErrors);
        $changePasswordPageView->render();
        
    }
}
?>