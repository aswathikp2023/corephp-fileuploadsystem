<?php
namespace App\Database;
// if (!defined('BASEPATH')) exit('No direct script access allowed');
define('DB_HOST', 'localhost');
define('DB_NAME', 'file_upload_system');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHAR', 'utf8');
use PDO;
///define('CONNECTION_PATH', '/database');


class DB
{

    protected static $instance = null;

    public function __construct() {}
    public function __clone() {}

    public static function instance()
    {
        if (self::$instance === null)
        {
            $opt  = array(
                PDO::ATTR_PERSISTENT         => TRUE,
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => TRUE,
            );
            $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHAR;
            self::$instance = new PDO($dsn, DB_USER, DB_PASS, $opt);
        }
        return self::$instance;
    }

    public static function __callStatic($method, $args)
    {
        return call_user_func_array(array(self::instance(), $method), $args);
    }

    public static function run($sql, $args = [])
    {
        try{
            $stmt = self::instance()->prepare($sql);
            $stmt->execute($args);
            return $stmt;
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }
}
?>