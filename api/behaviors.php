<?php
require_once __DIR__ . "/../php/src/util/BehaviorFileWriter.php";
require_once __DIR__ . "/../php/src/database/dao/BehaviorDao.php";

// Get all behaviors
$behaviorDao = new BehaviorDao();
$behaviors = $behaviorDao->getAll();

$behaviorsResult = ["behaviors" => []];

// Create Json object for each behavior
foreach ($behaviors as $behavior)
{
  array_push(
    $behaviorsResult["behaviors"],
    [
      "id" => $behavior->id,
      "label" => $behavior->label,
      "dex_url" => BehaviorFileWriter::getDexFile(strval($behavior->id))
    ]
  );
}

header("Content-Type: application/json");

// Print json
echo json_encode($behaviorsResult, JSON_UNESCAPED_SLASHES);
?>