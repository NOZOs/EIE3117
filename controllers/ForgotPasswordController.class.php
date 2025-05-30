<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/FormErrors.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');
require_once(dirname(__FILE__) . '/../class/Validation.class.php');
require_once(dirname(__FILE__) . '/../model/User.class.php');
class ForgotPasswordController {

    public static function showForgotPassword() {
        // This shows the forgot password page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedOut('/'); // Why a logged in user want to access this page?
       
        $forgotPasswordPageView = new View('forgot_password', 'Forgot Password');
        $formErrors = new FormErrors(); // No errors as we do not have submitted anything yet
        $forgotPasswordPageView->addVar('form_errors', $formErrors);
        $forgotPasswordPageView->render();
    }

    public static function processForgotPassword() {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF fail");
        }
        // This shows the submitted forgot password page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedOut('/'); // Why a logged in user want to access this page?

        $forgotPasswordPageView = new View('forgot_password', 'Forgot Password');
        $formErrors = new FormErrors();

        // Validation of POST fields
        // Check whether the fields are empty
        if(empty($_POST["username"])) {
            $formErrors->add('username', 'Username should not be blank');
        }
        // Validate Username Length
        // We need the absence of previous errors to check this as this may overwritten by the empty username check
        if(!$formErrors->haveError() && !Validation::validateUsernameLength($_POST["username"])) {
            $formErrors->add('username', 'Incorrect username');
        }

        // As database query is resource expensive and "time consuming"
        // We make sure we only do DB queries after all checks are good
        // We now check whether the current password is correct and update the password
        if(!$formErrors->haveError()) {
            $user = User::getUserByUsername($_POST["username"]);
            if($user != null) { // Is a user with this username and password pair already exists?
                // If yes, we reset the account's password
                $newPassword=self::getRandomPassword();
                if(User::updateUserPassword($user, sha1($newPassword))) {
                    // Updated to a new password, email to user now
                    $emailFrom = "From: support@phpbookmark \r\n";
                    $emailMessage = "Your PHPBookmark password has been changed to " . $newPassword . "\r\n" . 
                    "Please change it again next time you log in.\r\n";
                    if(mail($user->email, 'PHPBookmark login information', $emailMessage, $emailFrom)) {
                        $forgotPasswordPageView = new View('forgot_password_succeed', 'Forgot Password: Succeed');
                        $forgotPasswordPageView->render();
                        exit(); // Rest of the code should not be executed.
                    }else{
                        // Updated the user password, but cannot send an email to notify him/her
                        $formErrors->add('username', 'Password updated, but email cannot be sent, please try again later');
                    }
                }else{
                    // Failed to update the user's password
                    $formErrors->add('username', 'We are unable to update your password at the moment');
                }
            }else{
                // If not, user does not exists
                $formErrors->add('username', 'Incorrect username');
            }
        }
        
        $forgotPasswordPageView->addVar('form_errors', $formErrors);
        $forgotPasswordPageView->render();
    }

    private static function getRandomPassword() {
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pieces = [];
        $max = strlen($keyspace) - 1;
        for ($i = 0; $i < random_int(6, 16); ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
        
}
?>