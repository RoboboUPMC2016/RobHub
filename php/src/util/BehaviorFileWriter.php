<?php
class BehaviorFileWriter
{
	const TARGET_DIR = "behaviors/";
    
    public static function createPostFile($id, $postFile)
    {
    	$targetDirId = self::createTargetDirId($id);

		// Copy post file to behaviors/number_id/
    	move_uploaded_file($postFile["tmp_name"], $targetDirId . basename($postFile["name"]));
    }

    public static function createDexFile($id, $fileName, $dexContent)
    {
    	$targetDirId = self::createTargetDirId($id);

		// Create dex file to behaviors/number_id/
    	file_put_contents($targetDirId . $fileName . ".dex", $dexContent);
    }

    private static function createTargetDirId($id)
    {
    	// Create path => behaviors/number_id/
    	$targetDirId = self::TARGET_DIR . $id . "/";

    	// Create folder if it doesn't exists
    	if (!is_dir($targetDirId))
    	{
    		mkdir($targetDirId);
		}

		return $targetDirId;
    }
}
?>