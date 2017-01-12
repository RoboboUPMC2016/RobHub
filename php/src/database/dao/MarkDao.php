<?php
require_once __DIR__ . "/../DB.php";
require_once __DIR__ . "/../entity/Mark.php";

class MarkDao
{  
  public static function add($value, $behaviorId, $userUsername)
  {
    $stmt = DB::prepare("INSERT INTO Mark (Mark_value, Behavior_id, User_username) VALUES (?, ?, ?)");
    if ($stmt->execute([$value, $behaviorId, $userUsername]))
    {
      return DB::lastInsertId();
    }

    return -1;
  }

  public static function update($value, $behaviorId, $userUsername)
  {
    $stmt = DB::run("UPDATE Mark SET Mark_value=? WHERE Behavior_id=? AND User_username=?", [$value, $behaviorId, $userUsername]);
    return $stmt->rowCount();
  }

  public static function getByBehaviorUser($behaviorId, $userUsername)
  {
    $row = DB::run("SELECT * FROM Mark WHERE Behavior_id=? AND User_username=?", [$behaviorId, $userUsername])->fetch();
    if ($row)
    {
      $mark = new Mark();
      $mark->id = $row["Mark_id"];
      $mark->value = $row["Mark_value"];
      $mark->behaviorId = $row["Behavior_id"];
      $mark->userUsername = $row["User_username"];

      return $mark;
    }

    return null;
  }

  public static function getAverageByBehaviorId($behaviorId)
  {
    $row = DB::run("SELECT AVG(Mark_value) FROM Mark WHERE Behavior_id=? GROUP BY Behavior_id", [$behaviorId])->fetch();

    if ($row)
    {
      return $row["AVG(Mark_value)"];
    }
    
    return 0;
  }
}
?>