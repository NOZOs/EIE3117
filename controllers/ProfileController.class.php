<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
require_once(dirname(__FILE__) . '/../class/SessionController.class.php');
require_once(dirname(__FILE__) . '/../model/User.class.php');
require_once(dirname(__FILE__) . '/../class/FormErrors.class.php');

class ProfileController {
    public static function showProfile() {
        $session = SessionController::getInstance();
        $session->makeSureLoggedIn('/login');

        $currentUser = $session->getUser();
        $formErrors = new FormErrors();

        if (isset($_SESSION['upload_errors'])) {
            $formErrors = $_SESSION['upload_errors'];
            unset($_SESSION['upload_errors']);
        }

        $view = new View('profile', 'Profile');
        $view->addVar('user', $currentUser);
        $view->addVar('form_errors', $formErrors);
        $view->render();
    }

    public static function processProfileImageUpload() {
        $session = SessionController::getInstance();
        $session->makeSureLoggedIn('/login');

        $formErrors = new FormErrors();

        if (!isset($_FILES['profile_image']) || $_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
            $formErrors->add('profile_image', 'Please select a valid image file.');
        } else {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            $file = $_FILES['profile_image'];
            if (!in_array($file['type'], $allowedTypes)) {
                $formErrors->add('profile_image', 'Only JPG, PNG, and GIF are allowed.');
            } elseif ($file['size'] > $maxSize) {
                $formErrors->add('profile_image', 'File size must be less than 2MB.');
            } else {

                $uploadDir = '/var/www/html/upload_image/';
                $filename = uniqid('profile_') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {

                    $user = $session->getUser();
                    $user->profile_image = $filename;
                    User::updateProfileImage($user, $filename);
                } else {
                    $formErrors->add('profile_image', 'Failed to upload image.');
                }
            }
        }
        $_SESSION['upload_errors'] = $formErrors;
        header("Location: /profile");
        exit();
    }
}