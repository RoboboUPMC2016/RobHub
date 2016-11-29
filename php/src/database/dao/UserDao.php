<?php
require_once __DIR__ . "/../DB.php";
require_once __DIR__ . "/../entity/User.php";

class UserDao
{  
    public static function add($username, $password, $firstname, $lastname)
    {
      $stmt = DB::prepare("INSERT INTO User (User_username, User_password, User_firstname, User_lastname) VALUES (?, ?, ?, ?)");
      if ($stmt->execute([$username, $password, $firstname, $lastname]))
      {
        return true;
      }

      return false;
    }

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

    public static function find($login)
    {
      $result = DB::run("SELECT * FROM User WHERE User_username=?", [$login])->fetchColumn();
      return $result;
    }
}
?>