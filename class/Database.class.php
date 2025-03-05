<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/ServerError.class.php');
class Database {
    private static $instance=null;
    private static $pdoObject=null;
    function __construct() {
        // Connect to the database using PDO in exception mode
        try {
            self::$pdoObject = new PDO('mysql:host=' . $GLOBALS['appConfig']['mysql']['host'] . ';dbname=' . $GLOBALS['appConfig']['mysql']['database'], $GLOBALS['appConfig']['mysql']['username'], $GLOBALS['appConfig']['mysql']['password']);
            self::$pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e) {
            self::handlePDOException($e);
        }
    }
    // Exit application when PDO Exception
    private static function handlePDOException(PDOException $e) {
        $error = "Application DB Error:" . $e->getMessage();
        ServerError::ThrowError(500, $error);
    }
    // Singleton
    public static function getInstance(): Database {
        if(self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    public function getPDO(): PDO {
        return self::$pdoObject;
    }
    public static function query(string $query): PDOStatement {
        try {
            return Database::getInstance()->getPDO()->query($query);
        }catch (PDOException $e) {
            self::handlePDOException($e);
        }
    }
    public static function execute(string $statement): bool {
        try {
            $exec = Database::getInstance()->getPDO()->exec($statement);
            if($exec === 0 || $exec === false) {
                return false;
            }
            return true;
        }catch (PDOException $e) {
            self::handlePDOException($e);
        }
    }
}
?>