<?php
class DB
{
    protected static $instance = null;

    protected function __construct() {}
    protected function __clone() {}

    //const CONFIG_PATH = __DIR__ . "/../../../config/config-database.json";
    const HOST = "host";
    const NAME = "dbname";
    const USER = "user";
    const PASSWORD = "password";
    const CHARSET = "dbchar";

    public static function instance()
    {
        if (self::$instance === null)
        {
            $opt  = array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => FALSE,
            );

            $str = file_get_contents(__DIR__ . "/../../../config/config-database.json");
            $dbInfo = json_decode($str, true);

            $dsn = 'mysql:host=' . $dbInfo[DB::HOST] . ';dbname=' . $dbInfo[DB::NAME]. ';charset=' . $dbInfo[DB::CHARSET];
            self::$instance = new PDO($dsn, $dbInfo[DB::USER], $dbInfo[DB::PASSWORD], $opt);
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