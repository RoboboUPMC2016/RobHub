<?php
require_once "../php/src/util/BehaviorFileWriter.php";

$behaviors = ["behaviors" => [
 	[
 		"id" => 1,
 		"label" => "Danser",
 		"name" => "DummyDex",
 		"dex_url" => $_SERVER['SERVER_NAME'] . "/" . BehaviorFileWriter::TARGET_DIR . "1" . "/" . "DummyDex.dex"
 	],
    [
 		"id" => 2,
 		"label" => "Chanter",
 		"name" => "DummyDex",
 		"dex_url" => $_SERVER['SERVER_NAME'] . "/" . BehaviorFileWriter::TARGET_DIR . "2" . "/" . "DummyDex.dex"
    ]
]];

echo json_encode($behaviors, JSON_UNESCAPED_SLASHES);
?>