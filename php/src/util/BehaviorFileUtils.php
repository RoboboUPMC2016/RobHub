<?php
class BehaviorFileUtils
{
    const TARGET_BEHAVIORS = "behaviors/";
    //const TARGET_DIR = __DIR__ . "/../../../" . self::TARGET_BEHAVIORS;
    const TARGET_VIDEOS = "videos/";

    const DEX_EXT = ".dex";
    const JAVA_EXT = ".java";
    const MP4_EXT = ".mp4";

    const REGEX_HIDDEN_FILES = "/^([^.])/";
    
    public static function createJavaFile($id, $postFile)
    {
      // Create behaviors/id
      $targetDirId = self::createTargetDirId($id);

      // Copy post file to behaviors/id/
      move_uploaded_file($postFile["tmp_name"], $targetDirId . basename($postFile["name"]));
    }

    public static function createVideoFile($id, $username, $postFile)
    {
      // Create behaviors/id
      $targetDirId = self::createTargetDirId($id);

      // Create behaviors/id/username
      $targetDirVideo = self::createTargetDirVideo($targetDirId, $username);

      // Create behaviors/id/username/videoname(.mp4)
      $dest = $targetDirVideo . basename($postFile["name"]);

      // While a video with the same name exists, add a number at the end of its name
      $i = 1;
      while (file_exists($dest))
      {
        $dest = $targetDirVideo . basename($postFile["name"], self::MP4_EXT) . strval($i++) . self::MP4_EXT;
      }

      // Copy post file to behaviors/id/
      move_uploaded_file($postFile["tmp_name"], $dest);
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
            return self::constructBaseUrl() . self::TARGET_BEHAVIORS . $id . "/" . basename($filename);
        }

        // File not found
        return null;
    }

    public static function getVideosURL($id)
    {
      $videosURL = [];

      // Get behavior/id/videos/
      $dirVideos = self::targetDirIdPath($id) . self::TARGET_VIDEOS;

      // Get videos only if one videos has already been uploaded
      if (is_dir($dirVideos))
      {
        // Get all sub folders from videos
        $usernameDirs = preg_grep(self::REGEX_HIDDEN_FILES, scandir($dirVideos));
        foreach ($usernameDirs as $usernameDir)
        {
          // Get videos from the sub folder
          $videos = preg_grep(self::REGEX_HIDDEN_FILES, scandir($dirVideos . $usernameDir));

          foreach ($videos as $video)
          {
            array_push($videosURL, self::constructBaseUrl() .  self::TARGET_BEHAVIORS . $id . "/" . self::TARGET_VIDEOS . $usernameDir . "/" . $video);
          }
        }
      }

      return $videosURL;
    }

    private static function constructBaseUrl()
    {
      $protocol = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off" ? "https" : "http";
      return $protocol . "://" . $_SERVER["SERVER_NAME"] . "/robhub/";
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

    private static function createTargetDirVideo($targetDirId, $username)
    {
      // Create path => behaviors/id/videos/
      $targetDirVideo = $targetDirId . self::TARGET_VIDEOS;

      // Create folder if it doesn't exists
      if (!is_dir($targetDirVideo))
      {
        mkdir($targetDirVideo);
      }

      // Create path => behaviors/id/videos/username
      $targetDirVideo .= $username . "/";

      // Create folder if it doesn't exists
      if (!is_dir($targetDirVideo))
      {
        mkdir($targetDirVideo);
      }

      return $targetDirVideo;
    }
}
?>