<?php
session_start();

const MISSING_PARAMETER = "Missing bid parameter";
const INVALID_BEHAVIOR_ID = "Invalid bid parameter";
const OK = "Average result";


$errorCode = [
  MISSING_PARAMETER => -1,
  INVALID_BEHAVIOR_ID => -2,
  OK => 0
];

$msgCode = [
  "message" => MISSING_PARAMETER,
  "code" => $errorCode[MISSING_PARAMETER]
];

// Check if bid parameter is not missing
if (isset($_GET["bid"]) && !empty($_GET["bid"]))
{
  require_once __DIR__ . "/../php/src/util/StringUtils.php";
  $behaviorId = filter_var(StringUtils::clean($_GET["bid"]), FILTER_VALIDATE_INT);
  
  require_once __DIR__ . "/../php/src/database/dao/BehaviorDao.php";
  if ($behaviorId && BehaviorDao::getById($behaviorId))
  {
    require_once __DIR__ . "/../php/src/database/dao/MarkDao.php";
    // Get average
    $msgCode["message"] = round(MarkDao::getAverageByBehaviorId($behaviorId), 0, PHP_ROUND_HALF_DOWN);
    $msgCode["code"] = $errorCode[OK];
  }
  else
  {
    $msgCode["message"] = INVALID_BEHAVIOR_ID;
    $msgCode["code"] = $errorCode[INVALID_BEHAVIOR_ID];
  }
}

echo json_encode($msgCode, JSON_UNESCAPED_SLASHES);
?>