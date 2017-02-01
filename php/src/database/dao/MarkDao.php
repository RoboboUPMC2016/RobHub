<?php
require_once __DIR__ . "/../DB.php";
require_once __DIR__ . "/../entity/Mark.php";

/**
 * The class MarkDao provides functions to manipulate
 * the table Mark from the database.
 */
class MarkDao
{
  /**
   * Add a new mark entry in the database.
   *
   * @param integer $value The mark value given to the behavior.
   * @param integer $behaviorId The Id of the behavior.
   * @param string $userUsername The user who rates the behavior.
   * @return integer The last insert Id or -1 in case of error.
   */
  public static function add($value, $behaviorId, $userUsername)
  {
    $stmt = DB::prepare("INSERT INTO Mark (Mark_value, Behavior_id, User_username) VALUES (?, ?, ?)");
    if ($stmt->execute([$value, $behaviorId, $userUsername]))
    {
      return DB::lastInsertId();
    }

    return -1;
  }

  /**
   * Update a mark entry in the database.
   *
   * @param integer $value The mark value given to the behavior.
   * @param integer $behaviorId The Id of the behavior.
   * @param string $userUsername The user who rates the behavior.
   * @return integer The number of updated rows.
   */
  public static function update($value, $behaviorId, $userUsername)
  {
    $stmt = DB::run("UPDATE Mark SET Mark_value=? WHERE Behavior_id=? AND User_username=?", [$value, $behaviorId, $userUsername]);
    return $stmt->rowCount();
  }

  /**
   * Get the mark with a given behavior Id and a username.
   *
   * @param integer $behaviorId The Id of the behavior.
   * @param string $userUsername The user who rates the behavior.
   * @return integer The mark or null if not found.
   */
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

  /**
   * Get the average mark of a behavior.
   *
   * @param integer $behaviorId The Id of the behavior.
   * @return float The average mark or 0 if not yet rated.
   */
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