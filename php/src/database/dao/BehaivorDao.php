<?php
require_once "php/src/database/DB.php";
require_once "php/src/database/entity/Behavior.php";

class BehaviorDao
{  
    public static function add($behavior)
    {
      $stmt = DB::prepare("INSERT INTO Behavior (Behavior_label, Behavior_description, User_username, Behavior_timestamp) VALUES (?, ?, ?, ?)");
      if ($stmt->execute([$behavior->label, $behavior->description, $behavior->username, date("Y-m-d H:i:s")]))
      {
        return DB::lastInsertId();
      }

      return -1;
    }
}
?>