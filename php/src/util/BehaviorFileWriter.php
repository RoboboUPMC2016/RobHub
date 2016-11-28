<?php
class BehaviorFileWriter
{
    const TARGET_BEHAVIORS = "behaviors/";
    const TARGET_DIR = __DIR__ . "/../../../" . self::TARGET_BEHAVIORS;
    const DEX_EXT = ".dex";
    
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
      file_put_contents($targetDirId . $fileName . self::DEX_EXT, $dexContent);
    }

    public static function getDexFile($id)
    {
        $targetDirId = self::targetDirIdPath($id);

        // Get dex file
        foreach (glob($targetDirId . "*" . self::DEX_EXT) as $filename) {
            return $_SERVER["SERVER_NAME"] . "/robhub/" . self::TARGET_BEHAVIORS . "/" . $id . "/" . basename($filename);
        }

        // Dex file not found
        return null;
    }

    private static function targetDirIdPath($id)
    {
      return self::TARGET_DIR . $id . "/";
    }

    private static function createTargetDirId($id)
    {
      // Create path => behaviors/number_id/
      $targetDirId = self::targetDirIdPath($id);

      // Create folder if it doesn't exists
      if (!is_dir($targetDirId))
      {
        mkdir($targetDirId);
    }

    return $targetDirId;
    }
}
?>