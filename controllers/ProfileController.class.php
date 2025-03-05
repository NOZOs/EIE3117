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

        // 從 Session 獲取上傳錯誤（如果有）
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

        // 驗證文件上傳
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
                // 保存文件到指定目錄
                $uploadDir = '/var/www/html/upload_image/';
                $filename = uniqid('profile_') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                    // 更新用戶頭像
                    $user = $session->getUser();
                    $user->profile_image = $filename;
                    User::updateProfileImage($user, $filename);
                } else {
                    $formErrors->add('profile_image', 'Failed to upload image.');
                }
            }
        }

        // 存儲錯誤並重定向
        $_SESSION['upload_errors'] = $formErrors;
        header("Location: /profile");
        exit();
    }
}