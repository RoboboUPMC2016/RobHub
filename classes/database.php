<?php
define("CONFIG_DATABASE_PATH", "config/config-database.json");
define("HOST", "host");
define("DBNAME", "dbname");
define("USER", "user");
define("PASSWORD", "password");
define("DBCHAR", "dbchar");

class DB
{
    protected static $instance = null;

    protected function __construct() {}
    protected function __clone() {}

    public static function instance()
    {
        if (self::$instance === null)
        {
            $opt  = array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => FALSE,
            );

            $str = file_get_contents(CONFIG_DATABASE_PATH);
            $dbInfo = json_decode($str, true);

            $dsn = 'mysql:host=' . $dbInfo[HOST] . ';dbname=' . $dbInfo[DBNAME]. ';charset=' . $dbInfo[DBCHAR];
            self::$instance = new PDO($dsn, $dbInfo[USER], $dbInfo[PASSWORD], $opt);
        }
        return self::$instance;
    }

    public static function __callStatic($method, $args)
    {
        return call_user_func_array(array(self::instance(), $method), $args);
    }

    public static function run($sql, $args = [])
    {
        $stmt = self::instance()->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}
?>