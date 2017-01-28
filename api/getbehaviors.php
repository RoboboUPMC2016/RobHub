<?php
require_once __DIR__ . "/../php/src/util/BehaviorFileUtils.php";
require_once __DIR__ . "/../php/src/database/dao/BehaviorDao.php";
require_once __DIR__ . "/../php/src/database/dao/MarkDao.php";
require_once __DIR__ . "/../php/src/util/UrlUtils.php";


// Get all behaviors
$behaviors = BehaviorDao::getAll();

$behaviorsResult = ["behaviors" => []];

// Create Json object for each behavior
foreach ($behaviors as $behavior)
{
  $dexUrl = BehaviorFileUtils::getExternDexPath(strval($behavior->id));
  $contentDexUrl = explode("/", $dexUrl);
  array_push(
    $behaviorsResult["behaviors"],
    [
      "id" => $behavior->id,
      "label" => $behavior->label,
      "desc" => $behavior->description,
      "dex_url" => $dexUrl,
      "mark" => MarkDao::getAverageByBehaviorId($behavior->id),
      "filename" => end($contentDexUrl),
      "behaviordetails_url" => UrlUtils::getBehaviorDetailsUrl($behavior->id)
    ]
  );
}

header("Content-Type: application/json");

// Print json
echo json_encode($behaviorsResult, JSON_UNESCAPED_SLASHES);
?>