<?php
require_once(dirname(__FILE__) . '/../class/Database.class.php');
require_once(dirname(__FILE__) . '/User.class.php');
class Foodmenu {
    public $id, $username, $foodTitle, $dishDescription, $price;

    public static function createNewFoodmenu(Foodmenu $fm): bool {
        return Database::execute("INSERT INTO `foodMenu` (`id`,`username` , `foodTitle`, `dishDescription`, `price`) VALUES(NULL, '" . $fm->username . "', '" . $fm->foodTitle . "', '" . $fm->dishDescription . "', '" . $fm->price . "')");
    }

    public static function getUserFoodmenu(User $user) {
        $result=[];
        $query = Database::query("SELECT * FROM `foodMenu` WHERE `username`='" . $user->username . "'");
        if($query !== false) {
            $queryResult = $query->fetchAll();
            foreach($queryResult as $r) {
                $fm = new Foodmenu();
                $fm->id=$r["id"];
                $fm->username=$r["username"];
                $fm->foodTitle=$r["foodTitle"];
                $fm->dishDescription=$r["dishDescription"];
                $fm->price=$r["price"];
                array_push($result, $fm);
            }
        }else{
            $result=false;
        }
        return $result;
    }

    public static function getFoodmenuByID(int $fm_id): ?Foodmenu {
        $result=null;
        $query = Database::query("SELECT * FROM `foodMenu` WHERE `id`='" . $fm_id . "'");
        if($query !== false) {
            $queryResult = $query->fetchAll()[0];
            $fm = new Foodmenu();
            $fm->id=$queryResult["id"];
            $fm->username=$queryResult["username"];
            $fm->foodTitle=$queryResult["foodTitle"];
            $fm->dishDescription=$queryResult["dishDescription"];
            $fm->price=$queryResult["price"];
            return $fm;
        }
        return $result;
  
    }
}
?>