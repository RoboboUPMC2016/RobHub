<?php
class BehaviorFileWriter
{
	const TARGET_DIR = "behaviors/";
    
    public static function createPostFile($id, $postFile)
    {
    	$targetDirId = BehaviorFileWriter::createTargetDirId($id);

		// Copy post file to behaviors/number_id/
    	move_uploaded_file($this->file["tmp_name"], $targetDirId . basename($this->file["name"]));
    }

    public static function createDexFile($id, $fileName, $dexContent)
    {
    	$targetDirId = BehaviorFileWriter::createTargetDirId($id);

		// Create dex file to behaviors/number_id/
    	file_put_contents($targetDirId . $fileName . ".dex", $buf4);
    }

    private static function createTargetDirId($id)
    {
    	// Create path => behaviors/number_id/
    	$targetDirId = BehaviorFileWriter::TARGET_DIRECTORY . $id . "/";

    	// Create folder if it doesn't exists
    	if (!is_dir($this->targetDirId))
    	{
    		mkdir($this->targetDirId);
		}

		return $targetDirId;
    }
}
?>