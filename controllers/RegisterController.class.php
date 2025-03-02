<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/FormErrors.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');
require_once(dirname(__FILE__) . '/../class/Validation.class.php');
require_once(dirname(__FILE__) . '/../model/User.class.php');
class RegisterController {
    public static function showRegister() {
        // This shows the register page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedOut('/'); // Why a logged in user want to access this page?

        $registerPageView = new View('register', 'Register');
        $formErrors = new FormErrors(); // No errors as we do not have submitted anything yet
        $registerPageView->addVar('form_errors', $formErrors);
        $registerPageView->render();
    }

    public static function processRegister() {
        // This shows the submitted register page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedOut('/'); // Why a logged in user want to access this page?

        $registerPageView = new View('register', 'Register');
        $formErrors = new FormErrors();

        // Validation of POST fields
        // Check whether the fields are empty
        if(empty($_POST["username"])) {
            $formErrors->add('username', 'Username should not be blank');
        }
        if(empty($_POST["password"])) {
            $formErrors->add('password', 'Password should not be blank');
        }
        if(empty($_POST["confirm_password"])) {
            $formErrors->add('confirm_password', 'Confirm Password should not be blank');
        }
        if(empty($_POST["email"])) {
            $formErrors->add('email', 'Email should not be blank');
        }
        // Validate Email address
        // We need the absence of previous errors to check this as this may overwritten by the empty email check
        if(!$formErrors->haveError() && !Validation::validateEmailAddress($_POST["email"])) {
            $formErrors->add('email', 'Invalid email');
        }
        // Validate Username Length
        // We need the absence of previous errors to check this as this may overwritten by the empty username check
        if(!$formErrors->haveError() && !Validation::validateUsernameLength($_POST["username"])) {
            $formErrors->add('username', 'Username must be in 5-16 characters');
        }
        // Validate Password Length
        // We need the absence of previous errors to check this as this may overwritten by the empty password check
        if(!$formErrors->haveError() && !Validation::validatePasswordLength($_POST["password"])) {
            $formErrors->add('password', '');  // Just show the red border around the "password"
            $formErrors->add('confirm_password', 'Password must be in 6-16 characters');
        }
        // The two passwords need to be the same
        // We need the absence of previous errors to check this as this may overwritten by the empty password/password length check
        if(!$formErrors->haveError() && $_POST["password"] != $_POST["confirm_password"]) {
            $formErrors->add('password', '');  // Just show the red border around the "password"
            $formErrors->add('confirm_password', 'Both passwords do not match');
        }

        // As database query is resource expensive and "time consuming"
        // We make sure we only do DB queries after all checks are good
        // We now check whether the same username exists and insert into the database if not
        if(!$formErrors->haveError()) {
            if(User::getUserByUsername($_POST["username"]) == null) { // Is a user with this username already exists?
                // If no, insert a new record
                $user = new User();
                $user->username=$_POST["username"];
                $user->password=sha1($_POST["password"]);
                $user->email=$_POST["email"];
                if(User::createNewUser($user)) {
                    // Register succeed
                    $registerPageView = new View('register_succeed', 'Register Succeed');
                    $registerPageView->render();
                    exit(); // Rest of the code should not be executed.
                }else{
                    // Failed to create new user
                    $formErrors->add('username', 'We are unable to register you at the moment');
                }
            }else{
                // If yes, tell the user to choose another username
                $formErrors->add('username', 'Username already exists, please choose another one');
            }
        }
        $registerPageView->addVar('form_errors', $formErrors);
        $registerPageView->render();
    }
}
?>