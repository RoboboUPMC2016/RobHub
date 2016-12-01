<?php
require_once __DIR__ . "/../php/src/util/BehaviorFileUtils.php";
require_once __DIR__ . "/../php/src/database/dao/BehaviorDao.php";

// Get all behaviors
$behaviors = BehaviorDao::getAll();

$behaviorsResult = ["behaviors" => []];

// Create Json object for each behavior
foreach ($behaviors as $behavior)
{
  array_push(
    $behaviorsResult["behaviors"],
    [
      "id" => $behavior->id,
      "label" => $behavior->label,
      "dex_url" => BehaviorFileUtils::getExternDexPath(strval($behavior->id))
    ]
  );
}

header("Content-Type: application/json");

// Print json
echo json_encode($behaviorsResult, JSON_UNESCAPED_SLASHES);
?>