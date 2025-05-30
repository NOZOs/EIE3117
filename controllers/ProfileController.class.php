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
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF fail");
        }
        $session = SessionController::getInstance();
        $session->makeSureLoggedIn('/login');
        $formErrors = new FormErrors();
    
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $formErrors->add('profile_image', 'illegal request');
            $_SESSION['upload_errors'] = $formErrors;
            header("Location: /profile");
            exit();
        }
    
        if (!isset($_FILES['profile_image']) || $_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
            $formErrors->add('profile_image', 'please select a vaild image file');
        } else {
            $file = $_FILES['profile_image'];
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $maxSize = 2 * 1024 * 1024; // 2MB
    
            $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                $formErrors->add('profile_image', 'only allow JPG/PNG/GIF format');
            }
    
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file['tmp_name']);
            $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($mime, $allowedMimes)) {
                $formErrors->add('profile_image', 'file type illegal');
            }
    
            if ($file['size'] > $maxSize) {
                $formErrors->add('profile_image', 'file size cannot bigger than 2MB');
            }
    
            if (!$formErrors->haveError()) {
                $filename = uniqid('profile_', true) . '.' . $fileExtension;
                $uploadDir = '/var/www/html/upload_image/'; 
    
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
    
                if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                    $user = $session->getUser();
                    $user->profile_image = $filename;
                    if (User::updateProfileImage($user, $filename)) {
                        $session->setUser($user);
                    } else {
                        $formErrors->add('profile_image', 'upload databse fail');
                    }
                } else {
                    $formErrors->add('profile_image', 'upload fail');
                }
            }
        }
    
        $_SESSION['upload_errors'] = $formErrors;
        header("Location: /profile");
        exit();
    }
}