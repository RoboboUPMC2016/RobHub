<?php
require_once __DIR__ . "/../DB.php";
require_once __DIR__ . "/../entity/Behavior.php";

/**
 * The class BehaviorDao provides functions to manipulate
 * the table Behavior from the database.
 */
class BehaviorDao
{  
    /**
     * Add a new behavior entry in the database.
     *
     * @param string $label  The label of the behavior.
     * @param string $description The description of the behavior.
     * @param string $username The author of the behavior.
     * @return integer The last insert Id or -1 in case of error.
     */
    public static function add($label, $description, $username)
    {
      $stmt = DB::prepare("INSERT INTO Behavior (Behavior_label, Behavior_description, User_username, Behavior_timestamp) VALUES (?, ?, ?, ?)");
      if ($stmt->execute([$label, $description, $username, date("Y-m-d H:i:s")]))
      {
        return DB::lastInsertId();
      }

      return -1;
    }

    /**
     * Get all the behaviors.
     *
     * @return Behavior[] $behaviors return all the behaviors.
     */
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

    /**
     * Get the behavior with a given behavior Id.
     *
     * @param integer $id The Id of the behavior.
     * @return Behavior|null $behaviors The behavior or null if not found.
     */
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