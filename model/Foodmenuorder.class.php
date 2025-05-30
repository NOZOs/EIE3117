<?php
require_once(dirname(__FILE__) . '/../class/Database.class.php');
require_once(dirname(__FILE__) . '/User.class.php');

class Foodmenuorder {
    public $id, $username, $customerName, $foodTitle, $price;

    public static function createNewFoodmenuorder(Foodmenuorder $fmo): bool {
        return Database::execute(
            "INSERT INTO `foodmenuorder` (`username`, `customerName`, `foodTitle`, `price`) 
             VALUES (:username, :customerName, :foodTitle, :price)",
            [
                ':username' => $fmo->username,
                ':customerName' => $fmo->customerName,
                ':foodTitle' => $fmo->foodTitle,
                ':price' => $fmo->price
            ]
        );
    }

    public static function getUserFoodmenuorder(User $user): array {
        $result = [];
        $query = Database::query(
            "SELECT * FROM `foodmenuorder` WHERE `username` = :username",
            [':username' => $user->username]
        );
        if ($query !== false) {
            $queryResult = $query->fetchAll();
            foreach ($queryResult as $r) {
                $fmo = new Foodmenuorder();
                $fmo->id = $r["id"];
                $fmo->username = $r["username"];
                $fmo->customerName = $r["customerName"];
                $fmo->foodTitle = $r["foodTitle"];
                $fmo->price = $r["price"];
                array_push($result, $fmo);
            }
        }
        return $result;
    }

    public static function getFoodmenuorderByID(int $fmo_id): ?Foodmenuorder {
        $query = Database::query(
            "SELECT * FROM `foodmenuorder` WHERE `id` = :id",
            [':id' => $fmo_id]
        );
        $result = $query->fetchAll();
        if (empty($result)) return null;

        $fmo = new Foodmenuorder();
        $fmo->id = $result[0]["id"];
        $fmo->username = $result[0]["username"];
        $fmo->customerName = $result[0]["customerName"];
        $fmo->foodTitle = $result[0]["foodTitle"];
        $fmo->price = $result[0]["price"];
        return $fmo;
    }

    public function delete(): bool {
        return Database::execute(
            "DELETE FROM `foodmenuorder` WHERE `id` = :id",
            [':id' => $this->id]
        );
    }
}
?>