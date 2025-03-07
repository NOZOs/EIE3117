<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/FormErrors.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');
require_once(dirname(__FILE__) . '/../class/Validation.class.php');
require_once(dirname(__FILE__) . '/../model/User.class.php');
class LoginController {
    public static function showLogin() {
        // This shows the login page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedOut('/'); // Why a logged in user want to access this page?

        $loginPageView = new View('login', 'Login');
        $formErrors = new FormErrors(); // No errors as we do not have submitted anything yet
        $loginPageView->addVar('form_errors', $formErrors);
        $loginPageView->render();
    }

    public static function processLogin() {
        // This shows the submitted login page
        $sessionController = SessionController::getInstance();
        $sessionController->makeSureLoggedOut('/'); // Why a logged in user want to access this page?

        $loginPageView = new View('login', 'Login');
        $formErrors = new FormErrors();

        // Validation of POST fields
        // Check whether the fields are empty
        if(empty($_POST["username"])) {
            $formErrors->add('username', 'Username should not be blank');
        }
        if(empty($_POST["password"])) {
            $formErrors->add('password', 'Password should not be blank');
        }
        // Validate Username Length
        // We need the absence of previous errors to check this as this may overwritten by the empty username check
        if(!$formErrors->haveError() && !Validation::validateUsernameLength($_POST["username"])) {
            $formErrors->add('username', ''); // Just show the red border around the "username"
            $formErrors->add('password', 'Incorrect username and/or password.');
        }
        // Validate Password Length
        // We need the absence of previous errors to check this as this may overwritten by the empty password check
        if(!$formErrors->haveError() && !Validation::validatePasswordLength($_POST["password"])) {
            $formErrors->add('username', ''); // Just show the red border around the "username"
            $formErrors->add('password', 'Incorrect username and/or password.');
        }
       
        // As database query is resource expensive and "time consuming"
        // We make sure we only do DB queries after all checks are good
        // We now check whether the same username exists and logs user in
        if(!$formErrors->haveError()) {
            $user = User::getUserByUsernameAndPassword($_POST["username"], sha1($_POST["password"]));
            if($user != null) { // Is a user with this username and hashed password pair already exists?
                // If yes, logs the user in
                SessionController::getInstance()->login($user);
                header("Location: /");
                exit(); // No futher execution is needed
            }else{
                // If not, username and/or password is wrong
                $formErrors->add('username', ''); // Just show the red border around the "username"
                $formErrors->add('password', 'Incorrect username and/or password.');
            }
        }
        
        $loginPageView->addVar('form_errors', $formErrors);
        $loginPageView->render();
    }
}
?>