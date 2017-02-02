<?php
require_once __DIR__ . "/../DB.php";
require_once __DIR__ . "/../entity/User.php";

/**
 * The class UserDao provides functions to manipulate
 * the table User from the database.
 */
class UserDao
{

  /**
   * Add a new user entry in the database.
   *
   * @param string $username The username of the user.
   * @param string $password The password of the user.
   * @param string $firstname The first name of the user.
   * @param string $lastname The last name of the user.
   * @return boolean True if the entry has been created or false if an error has occured.
   */
    public static function add($username, $password, $firstname, $lastname)
    {
      $stmt = DB::prepare("INSERT INTO User (User_username, User_password, User_firstname, User_lastname) VALUES (?, ?, ?, ?)");
      if ($stmt->execute([$username, $password, $firstname, $lastname]))
      {
        return true;
      }

      return false;
    }

  /**
   * Get the user with a given login and a password.
   *
   * @param string $login The login(=username) of the user.
   * @param string $password The password of the user.
   * @return \src\database\entity\User|null The user with a given login and a password or null if not found.
   */
    public static function get($login, $password)
    {
      $result = DB::run("SELECT User_username, User_firstname, User_lastname FROM User WHERE User_username=? AND User_password=?", [$login, $password])->fetch();
      if ($result)
      {
          $user->username = $result["User_username"];
          $user->firstname = $result["User_firstname"];
          $user->lastname = $result["User_lastname"];

          return $user;
      }
      
      return null;
    }

    /**
     * Get the user with a given login.
     *
     * @param string $login The login(=username) of the user.
     * @return \src\database\entity\User|null The user with a given login and a password or null if not found.
     */
    public static function find($login)
    {
      $result = DB::run("SELECT * FROM User WHERE User_username=?", [$login])->fetchColumn();
      return $result;
    }
}
?>