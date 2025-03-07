<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
class IndexController {
    public static function showIndex() {
        $session = SessionController::getInstance();       
        $view = new View('index', 'Home');
        $view->render();
    }
}
?>