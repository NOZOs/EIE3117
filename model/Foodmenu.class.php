<?php
require_once(dirname(__FILE__) . '/../class/Database.class.php');
require_once(dirname(__FILE__) . '/User.class.php');

class Foodmenu {
    public $id, $username, $foodTitle, $dishDescription, $price;

    public static function createNewFoodmenu(Foodmenu $fm): bool {
        return Database::execute(
            "INSERT INTO `foodMenu` (`username`, `foodTitle`, `dishDescription`, `price`) 
             VALUES (:username, :foodTitle, :dishDescription, :price)",
            [
                ':username' => $fm->username,
                ':foodTitle' => $fm->foodTitle,
                ':dishDescription' => $fm->dishDescription,
                ':price' => $fm->price
            ]
        );
    }

    public static function getAllFoodmenus(): array {
        $result = [];
        $query = Database::query("SELECT * FROM `foodMenu`");
        if ($query !== false) {
            $queryResult = $query->fetchAll();
            foreach ($queryResult as $r) {
                $fm = new Foodmenu();
                $fm->id = $r["id"];
                $fm->username = $r["username"];
                $fm->foodTitle = $r["foodTitle"];
                $fm->dishDescription = $r["dishDescription"];
                $fm->price = $r["price"];
                array_push($result, $fm);
            }
        }
        return $result;
    }

    public static function getUserFoodmenu(User $user): array {
        $result = [];
        $query = Database::query(
            "SELECT * FROM `foodMenu` WHERE `username` = :username",
            [':username' => $user->username]
        );
        if ($query !== false) {
            $queryResult = $query->fetchAll();
            foreach ($queryResult as $r) {
                $fm = new Foodmenu();
                $fm->id = $r["id"];
                $fm->username = $r["username"];
                $fm->foodTitle = $r["foodTitle"];
                $fm->dishDescription = $r["dishDescription"];
                $fm->price = $r["price"];
                array_push($result, $fm);
            }
        }
        return $result;
    }

    public static function getFoodmenuByID(int $fm_id): ?Foodmenu {
        $query = Database::query(
            "SELECT * FROM `foodMenu` WHERE `id` = :id",
            [':id' => $fm_id]
        );
        $result = $query->fetchAll();
        if (empty($result)) return null;

        $fm = new Foodmenu();
        $fm->id = $result[0]["id"];
        $fm->username = $result[0]["username"];
        $fm->foodTitle = $result[0]["foodTitle"];
        $fm->dishDescription = $result[0]["dishDescription"];
        $fm->price = $result[0]["price"];
        return $fm;
    }

    public function buy(): bool {
        return Database::execute(
            "DELETE FROM `foodmenuorder` WHERE `id` = :id",
            [':id' => $this->id]
        );
    }
}
?>