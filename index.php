<?php
require("config.php");
require("class/ServerError.class.php");
require("class/SessionController.class.php");
require("vendor/autoload.php");

SessionController::getInstance(); // It will initialize to user_role to guest

$router = new AltoRouter();
$router->setBasePath("");

// Route definitions
$router->map('GET', '/', 'IndexController@showIndex');
$router->map('GET', '/home', 'IndexController@showIndex');
$router->map('GET', '/login', 'LoginController@showLogin');
$router->map('POST', '/login', 'LoginController@processLogin');
$router->map('GET', '/register', 'RegisterController@showRegister');
$router->map('POST', '/register', 'RegisterController@processRegister');
$router->map('GET', '/change_password', 'ChangePasswordController@showChangePassword');
$router->map('POST', '/change_password', 'ChangePasswordController@processChangePassword');
$router->map('GET', '/forgot_password', 'ForgotPasswordController@showForgotPassword');
$router->map('POST', '/forgot_password', 'ForgotPasswordController@processForgotPassword');
$router->map('GET', '/logout', 'LogoutController@logout');
$router->map('GET', '/main', 'MainController@showMain');
$router->map('GET', '/add_bm', 'BookmarkController@showAddBookmark');
$router->map('POST', '/add_bm', 'BookmarkController@processAddBookmark');
$router->map('GET', '/delete_bm/[i:bm_id]?', 'BookmarkController@deleteBookmark');
$router->map('GET', '/restaurant/dashboard', 'RestaurantController@showDashboard');
$router->map('GET', '/consumer/home', 'ConsumerController@showHome');
$router->map('GET', '/access-denied', 'ErrorController@showAccessDenied');
$router->map('GET', '/profile', 'ProfileController@showProfile');
$router->map('POST', '/profile/upload', 'ProfileController@processProfileImageUpload');


$match = $router->match();

if(!$match) { // No match, which means the user is browsing a non-defined page
    ServerError::throwError(404, 'Path not found');
}else{
    // There is a match
    if(is_callable($match['target'])) { // We are passing a anonymous function/closure
        call_user_func_array($match['target'], $match['params']); // Execute the anonymous function
    }else{
        // Test the syntax: "controller_name@function"
        list($controllerClassName, $methodName) = explode('@', $match['target']);
        if((@include_once("controllers/" . $controllerClassName . ".class.php")) == TRUE) {
            if (is_callable(array($controllerClassName, $methodName))) {
                call_user_func_array(array($controllerClassName, $methodName), ($match['params']));
            } else {
                // Internal error
                // We have defined a correct route but it is not callable
                ServerError::throwError(500, 'Route not callable');
            }
        }else{
            // Internal error
            // We have defined a correct route but the controller is not includible (and hence not callable)
            ServerError::throwError(500, 'Controller not includible');
        }
    }
}
?>