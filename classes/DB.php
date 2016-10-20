<?php
class DB
{
    protected static $instance = null;

    protected function __construct() {}
    protected function __clone() {}

    const CONFIG_DATABASE_PATH = "config/config-database.json";
    const HOST = "host";
    const DB_NAME = "dbname";
    const DB_USER = "user";
    const DB_PASSWORD = "password";
    const DB_CHAR = "dbchar";

    public static function instance()
    {
        if (self::$instance === null)
        {
            $opt  = array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => FALSE,
            );

            $str = file_get_contents(DB::CONFIG_DATABASE_PATH);
            $dbInfo = json_decode($str, true);

            $dsn = 'mysql:host=' . $dbInfo[DB::HOST] . ';dbname=' . $dbInfo[DB::DB_NAME]. ';charset=' . $dbInfo[DB::DB_CHAR];
            self::$instance = new PDO($dsn, $dbInfo[DB::DB_USER], $dbInfo[DB::DB_PASSWORD], $opt);
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