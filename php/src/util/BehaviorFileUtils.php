<?php
class BehaviorFileUtils
{
    const TARGET_BEHAVIORS = "behaviors/";
    //const TARGET_DIR = __DIR__ . "/../../../" . self::TARGET_BEHAVIORS;
    const DEX_EXT = ".dex";
    const JAVA_EXT = ".java";
    
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

    public static function getJavaContent($id)
    {
      return file_get_contents(self::getInternJavaPath($id));
    }

    public static function getInternJavaPath($id)
    {
        $targetDirId = self::targetDirIdPath($id);

        // Get java file
        foreach (glob($targetDirId . "*" . self::JAVA_EXT) as $filename)
        {
            return self::TARGET_BEHAVIORS . $id . "/" . basename($filename);
        }

        // Java file not found
        return null;
    }

    public static function getExternJavaPath($id)
    {
        return self::getExternPath($id, self::JAVA_EXT);
    }

    public static function getExternDexPath($id)
    {
        return self::getExternPath($id, self::DEX_EXT);
    }

    private static function getExternPath($id, $ext)
    {
        $targetDirId = self::targetDirIdPath($id);

        // Get file
        foreach (glob($targetDirId . "*" . $ext) as $filename)
        {
            return "http://" . $_SERVER["SERVER_NAME"] . "/robhub/" . self::TARGET_BEHAVIORS . $id . "/" . basename($filename);
        }

        // File not
        return null;
    }

    private static function targetDirIdPath($id)
    {
      return __DIR__ . "/../../../" . self::TARGET_BEHAVIORS . $id . "/";
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