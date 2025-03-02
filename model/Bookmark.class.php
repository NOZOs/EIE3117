<?php
require_once(dirname(__FILE__) . '/../class/Database.class.php');
require_once(dirname(__FILE__) . '/User.class.php');
class Bookmark {
    public $id, $username, $url;

    public static function createNewBookmark(Bookmark $bm): bool {
        return Database::execute("INSERT INTO `bookmarks` (`id`, `username`, `url`) VALUES(NULL, '" . $bm->username . "', '" . $bm->url . "')");
    }

    public static function getUserBookmarks(User $user) {
        $result=[];
        $query = Database::query("SELECT * FROM `bookmarks` WHERE `username`='" . $user->username . "'");
        if($query !== false) {
            $queryResult = $query->fetchAll();
            foreach($queryResult as $r) {
                $bm = new Bookmark();
                $bm->id=$r["id"];
                $bm->username=$r["username"];
                $bm->url=$r["url"];
                array_push($result, $bm);
            }
        }else{
            $result=false;
        }
        return $result;
    }

    public static function getBookmarkByID(int $bm_id): ?Bookmark {
        $result=null;
        $query = Database::query("SELECT * FROM `bookmarks` WHERE `id`='" . $bm_id . "'");
        if($query !== false) {
            $queryResult = $query->fetchAll()[0];
            $bm = new Bookmark();
            $bm->id=$queryResult["id"];
            $bm->username=$queryResult["username"];
            $bm->url=$queryResult["url"];
            return $bm;
        }
        return $result;
    }

    public function delete(): bool {
        return Database::execute("DELETE FROM `bookmarks` WHERE `id`='" . $this->id . "'");
    }
}
?>