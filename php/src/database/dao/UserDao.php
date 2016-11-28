<?php
require_once "php/src/database/DB.php";
require_once "php/src/database/entity/User.php";

class UserDao
{  
    public static function add($user)
    {
      $stmt = DB::prepare("INSERT INTO User (User_username, User_password, User_firstname, User_lastname) VALUES (?, ?, ?, ?)");
      if ($stmt->execute([$user->username, $user->password, $user->firstname, $user->lastname))
      {
        return $user->username;
      }

      return -1;
    }

    public static function get($user)
    {
      $result = DB::run("SELECT User_username, User_firstname, User_lastname FROM User WHERE User_username=? AND User_password=?", [$user->login, $user->password])->fetch());
      if ($result)
      {
          $user->username = $result["User_username"];
          $user->firstname = $result["User_firstname"];
          $user->lastname = $result["User_lastname"];

          return $user;
      }
      
      return null;
    }
}
?>