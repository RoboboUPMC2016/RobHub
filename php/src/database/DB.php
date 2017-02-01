<?php

/**
 * The class DB allows to run SQL commands.
 */
class DB
{
  /**
   * The instance of the database (singleton).
   */
  protected static $instance = null;

  /**
   * The host key.
   */
  const HOST = "host";

  /**
   * The dbname key.
   */
  const NAME = "dbname";

  /**
   * The user key.
   */
  const USER = "user";

  /**
   * The password key.
   */
  const PASSWORD = "password";

  /**
   * The charset key.
   */
  const CHARSET = "dbchar";

  /**
   * Remove constructor.
   */
  protected function __construct() {}

  /**
   * Remove copy.
   */
  protected function __clone() {}

  /**
   * Get the instance of the database.
   * 
   * @return PDO The database instance.
   */
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

  /**
   * Execute a SQL command.
   *
   * @param  string $sql The SQL command to execute.
   * @param mixed[] $args The arguments of the PDOStatement.
   * @return PDOStatement The PDOStatement resulting.
   */
  public static function run($sql, $args = [])
  {
      $stmt = self::instance()->prepare($sql);
      $stmt->execute($args);
      return $stmt;
  }
}
?>