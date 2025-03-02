<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../class/View.class.php');
class IndexController {
    public static function showIndex() {
        $homePageView = new View('index', 'Home');
        $homePageView->render();
    }
}
?>