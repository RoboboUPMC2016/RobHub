<?php
session_start();

const NOT_AUTHENTICATED = "User is not authenticated";
const MISSING_PARAMETER = "Missing bid parameter";
const INVALID_BEHAVIOR_ID = "Invalid bid parameter";
const BEHAVIOR_NOT_ALREADY_RATED = "The behavior has not been already rated";
const OK = "The behavior has already been rated";


$errorCode = [
  NOT_AUTHENTICATED => -1,
  MISSING_PARAMETER => -2,
  INVALID_BEHAVIOR_ID => -3,
  BEHAVIOR_NOT_ALREADY_RATED => -4,
  OK => 0
];

$msgCode = [
  "message" => NOT_AUTHENTICATED,
  "code" => $errorCode[NOT_AUTHENTICATED]
];

require_once __DIR__ . "/../php/src/enum/SessionData.php";
if (isset($_SESSION[SessionData::LOGIN]))
{
  // Check if bid parameter is not missing
  if (isset($_GET["bid"]) && !empty($_GET["bid"]))
  {
    require_once __DIR__ . "/../php/src/util/StringUtils.php";
    $behaviorId = filter_var(StringUtils::clean($_GET["bid"]), FILTER_VALIDATE_INT);
    
    require_once __DIR__ . "/../php/src/database/dao/BehaviorDao.php";
    if ($behaviorId && BehaviorDao::getById($behaviorId))
    {
      require_once __DIR__ . "/../php/src/database/dao/MarkDao.php";
      // The current user has already rated this behavior
      $mark = MarkDao::getByBehaviorUser($behaviorId, $_SESSION[SessionData::LOGIN]);
      if ($mark)
      {
        $msgCode["message"] = $mark->value;
        $msgCode["code"] = $errorCode[OK];
      }
      else
      {
        $msgCode["message"] = BEHAVIOR_NOT_ALREADY_RATED;
        $msgCode["code"] = $errorCode[BEHAVIOR_NOT_ALREADY_RATED];
      }
    }
    else
    {
      $msgCode["message"] = INVALID_BEHAVIOR_ID;
      $msgCode["code"] = $errorCode[INVALID_BEHAVIOR_ID];
    }
  }
  else
  {
    $msgCode["message"] = MISSING_PARAMETER;
    $msgCode["code"] =  $errorCode[MISSING_PARAMETER];
  }
}

echo json_encode($msgCode, JSON_UNESCAPED_SLASHES);
?>