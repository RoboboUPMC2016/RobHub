<?php
require_once __DIR__ . "/../DB.php";
require_once __DIR__ . "/../entity/Behavior.php";

class BehaviorDao
{  
    public static function add($label, $description, $username)
    {
      $stmt = DB::prepare("INSERT INTO Behavior (Behavior_label, Behavior_description, User_username, Behavior_timestamp) VALUES (?, ?, ?, ?)");
      if ($stmt->execute([$label, $description, $username, date("Y-m-d H:i:s")]))
      {
        return DB::lastInsertId();
      }

      return -1;
    }

    public static function getAll()
    {
      $behaviors = [];
      
      // Get all behaviors
      $stmt = DB::run("SELECT * FROM Behavior");
      while ($row = $stmt->fetch(PDO::FETCH_LAZY))
      {
        $behavior = new Behavior();
        $behavior->id = $row["Behavior_id"];
        $behavior->label = $row["Behavior_label"];
        $behavior->description = $row["Behavior_description"];
        $behavior->username = $row["User_username"];
        $behavior->timestamp = $row["Behavior_timestamp"];

        array_push($behaviors, $behavior);
      }

      return $behaviors;
    }

    public static function getById($id)
    {
      $row = DB::run("SELECT * FROM Behavior WHERE Behavior_id=?", [$id])->fetch();
      if ($row)
      {
        $behavior = new Behavior();
        $behavior->id = $row["Behavior_id"];
        $behavior->label = $row["Behavior_label"];
        $behavior->description = $row["Behavior_description"];
        $behavior->username = $row["User_username"];
        $behavior->timestamp = $row["Behavior_timestamp"];

        return $behavior;
      }

      return null;
    }
}
?>