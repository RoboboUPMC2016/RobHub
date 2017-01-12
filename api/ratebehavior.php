<?php
session_start();

const MIN_MARK = 1;
const MAX_MARK = 5;

const NOT_AUTHENTICATED = "User is not authenticated";
const MISSING_PARAMETERS = "Missing bid and/or mark parameters";
const BEHAVIOR_ALREADY_RATED = "The behavior has already been rated";
const INVALID_MARK = "Invalid mark parameter (not in [" . MIN_MARK . ", " . MAX_MARK . "])";
const INVALID_BEHAVIOR_ID = "Invalid bid parameter";
const OK = "The behavior has been rated";


$errorCode = [
  NOT_AUTHENTICATED => -1,
  MISSING_PARAMETERS => -2,
  BEHAVIOR_ALREADY_RATED => -3,
  INVALID_MARK => -4,
  INVALID_BEHAVIOR_ID => -5,
  OK => 0
];

$msgCode = [
  "message" => NOT_AUTHENTICATED,
  "code" => $errorCode[NOT_AUTHENTICATED]
];

require_once __DIR__ . "/../php/src/enum/SessionData.php";
if (isset($_SESSION[SessionData::LOGIN]))
{
  require_once __DIR__ . "/../php/src/util/StringUtils.php";

  // Check if mark and bid are defined
  if (isset($_GET["mark"]) && !empty($_GET["mark"]) &&
      isset($_GET["bid"]) && !empty($_GET["bid"]))
  {
    // We have to check that mark is in [MIN_MARK, MAX_MARK]
    $mark = filter_var(StringUtils::clean($_GET["mark"]), FILTER_VALIDATE_INT);
    if ($mark && $mark >= MIN_MARK && $mark <= MAX_MARK)
    {
      $behaviorId = filter_var(StringUtils::clean($_GET["bid"]), FILTER_VALIDATE_INT);
      require_once __DIR__ . "/../php/src/database/dao/BehaviorDao.php";
      if ($behaviorId && BehaviorDao::getById($behaviorId))
      {
        require_once __DIR__ . "/../php/src/database/dao/MarkDao.php";
        // User has not yet rate this behavior
        if (!MarkDao::getByBehaviorUser($behaviorId, $_SESSION[SessionData::LOGIN]))
        {
          MarkDao::add($mark, $behaviorId, $_SESSION[SessionData::LOGIN]);
        }
        else
        {
          MarkDao::update($mark, $behaviorId, $_SESSION[SessionData::LOGIN]);
        }

        $msgCode["message"] = OK;
        $msgCode["code"] = $errorCode[OK];
      }
      else
      {
        $msgCode["message"] = INVALID_BEHAVIOR_ID;
        $msgCode["code"] = $errorCode[INVALID_BEHAVIOR_ID];
      }
    }
    else
    {
      $msgCode["message"] = INVALID_MARK;
      $msgCode["code"] = $errorCode[INVALID_MARK];
    }
  }
  else
  {
    $msgCode["message"] = MISSING_PARAMETERS;
    $msgCode["code"] =  $errorCode[MISSING_PARAMETERS];
  }
}

echo json_encode($msgCode, JSON_UNESCAPED_SLASHES);
?>