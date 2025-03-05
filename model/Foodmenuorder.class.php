<?php
require_once(dirname(__FILE__) . '/../class/Database.class.php');
require_once(dirname(__FILE__) . '/User.class.php');
class Foodmenuorder {
    public $id, $username, $customerName, $foodTitle, $dishDescription, $price, $amount;

    public static function createNewFoodmenuorder(Foodmenuorder $fmo): bool {
        return Database::execute("INSERT INTO `foodMenu` (`id`,`username` , `customerName`,`foodTitle`, `dishDescription`, `price`, `amount`) VALUES(NULL, '" . $fmo->username . "', '" . $fmo->customerName . "', '" . $fmo->foodTitle . "', '" . $fmo->dishDescription . "', '" . $fmo->price . "' , '" . $fmo->amount . "' )");
    }

    public static function getUserFoodmenuorder(User $user) {
        $result=[];
        $query = Database::query("SELECT * FROM `foodmenuorder` WHERE `username`='" . $user->username . "'");
        if($query !== false) {
            $queryResult = $query->fetchAll();
            foreach($queryResult as $r) {
                $fmo = new Foodmenuorder();
                $fmo->id=$r["id"];
                $fmo->username=$r["username"];
                $fmo->customerName=$r["customerName"];
                $fmo->foodTitle=$r["foodTitle"];
                $fmo->price=$r["price"];
                $fmo->amount=$r["amount"];
                array_push($result, $fmo);
            }
        }else{
            $result=false;
        }
        return $result;
    }

    public static function getFoodmenuorderByID(int $fmo_id): ?Foodmenuorder {
        $result=null;
        $query = Database::query("SELECT * FROM `foodmenuorder` WHERE `id`='" . $fmo_id . "'");
        if($query !== false) {
            $queryResult = $query->fetchAll()[0];
            $fmo = new Foodmenuorder();
            $fmo->id=$queryResult["id"];
            $fmo->username=$queryResult["username"];
            $fmo->customerName=$queryResult["customerName"];
            $fmo->foodTitle=$queryResult["foodTitle"];
            $fmo->price=$queryResult["price"];
            $fmo->amount=$queryResult["amount"];
            return $fmo;
        }
        return $result;
  
    }

    public function delete(): bool {
        return Database::execute("DELETE FROM `foodmenuorder` WHERE `id`='" . $this->id . "'");
    }
}
?>