<?php
require_once __DIR__ . "/UrlUtils.php";

/**
 * The class BehaviorFileUtils defines utily methods to
 * manipulate behavior files. 
 */
class BehaviorFileUtils
{
  /**
   * string The root target folder for behaviors.
   */
  const TARGET_BEHAVIORS = "behaviors/";

  /**
   * string The root target folder for videos of a behavior.
   */
  const TARGET_VIDEOS = "videos/";

  /**
   * string Dex extension.
   */
  const DEX_EXT = ".dex";

  /**
   * string Java extension.
   */
  const JAVA_EXT = ".java";

  /**
   * string MP4 extension.
   */
  const MP4_EXT = ".mp4";

  /**
   * string Pattern to check if a file/folder is hidden.
   */
  const REGEX_HIDDEN_FILES = "/^([^.])/";
  
  /**
   * Create the Java file corresponding to the java file behavior uploaded.
   *
   * @param integer $id The Id of the behavior.
   * @param $_FILES $postFile The Java file uploaded.
   */
  public static function createJavaFile($id, $postFile)
  {
    // Create behaviors/id
    $targetDirId = self::createTargetDirId($id);

    // Copy post file to behaviors/id/
    move_uploaded_file($postFile["tmp_name"], $targetDirId . basename($postFile["name"]));
  }

  
  /**
   * Create the video file corresponding to the video uploaded.
   *
   * @param integer $id The Id of the behavior.
   * @param string $username The username of the uploader (who is an user).
   * @param $_FILES $postFile The video file uploaded.
   */
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

  /**
   * Create the Dex file.
   *
   * @param integer $id The Id of the behavior.
   * @param string $fileName The name of the Dex file.
   * @param dexContent $dexContent The content of the Dex file.
   */
  public static function createDexFile($id, $fileName, $dexContent)
  {
    $targetDirId = self::createTargetDirId($id);

    // Create dex file to behaviors/number_id/
    file_put_contents($targetDirId . $fileName . self::DEX_EXT, $dexContent);
  }

  /**
   * Get the content of the Java file.
   *
   * @param integer $id The Id of the behavior.
   * @return string The content of the Java file.
   */
  public static function getJavaContent($id)
  {
    $javaPath = self::getInternJavaPath($id);
    return empty($javaPath) ? "" : file_get_contents($javaPath);
  }

  /**
   * Get the intern(local) Java path of the Java file corresponding to the behavior.
   *
   * @param integer $id The Id of the behavior.
   * @return string|null The intern(local) Java path of the Java file corresponding to the behavior or null if not found.
   */
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

  /**
   * Get the extern(url) Java path of the Java file corresponding to the behavior.
   *
   * @param integer $id The Id of the behavior.
   * @return string|null The extern(url) Java path of the Java file corresponding to the behavior or null if not found.
   */
  public static function getExternJavaPath($id)
  {
    return self::getExternPath($id, self::JAVA_EXT);
  }

  /**
   * Get the extern(url) Dex path of the Dex file corresponding to the behavior.
   *
   * @param integer $id The Id of the behavior.
   * @return string|null The extern(url) path of the Dex file corresponding to the behavior or null if not found.
   */
  public static function getExternDexPath($id)
  {
    return self::getExternPath($id, self::DEX_EXT);
  }

  /**
   * Get the extern(url) path of the file corresponding to the behavior.
   *
   * @param integer $id The Id of the behavior.
   * @param string $ext The extension of the file.
   * @return string|null The extern(url) path of the file corresponding to the behavior or null if not found.
   */
  private static function getExternPath($id, $ext)
  {
    $targetDirId = self::targetDirIdPath($id);

    // Get file
    foreach (glob($targetDirId . "*" . $ext) as $filename)
    {
      return UrlUtils::getBaseUrl() . self::TARGET_BEHAVIORS . $id . "/" . basename($filename);
    }

    // File not found
    return null;
  }

  /**
   * Get the URLs videos for the behavrior.
   *
   * @param integer $id The Id of the behavior.
   * @return string[] The URLs videos for the behavrior.
   */
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
          array_push($videosURL, UrlUtils::getBaseUrl() .  self::TARGET_BEHAVIORS . $id . "/" . self::TARGET_VIDEOS . $usernameDir . "/" . $video);
        }
      }
    }

    return $videosURL;
  }

  /**
   * Get the target directory behaviors.
   *
   * @return string The target directory behaviors.
   */
  private static function targetDirBehaviors()
  {
    return __DIR__ . "/../../../" . self::TARGET_BEHAVIORS;
  }

  /**
   * Get the path of the target directory of the behavior.
   *
   * @param integer $id The Id of the behavior.
   * @return string The path of the target directory of the behavior.
   */
  private static function targetDirIdPath($id)
  {
    return BehaviorFileUtils::targetDirBehaviors() . $id . "/";
  }

  /**
   * Create the target directory of the behavior.
   *
   * @param integer $id The Id of the behavior.
   * @return string The path of the target directory of the behavior.
   */
  private static function createTargetDirId($id)
  {
    // Create path => behaviors/number_id/
    $targetDirId = self::targetDirIdPath($id);

    // Create behaviors if it doesn't exist
    if (!is_dir(BehaviorFileUtils::targetDirBehaviors()))
    {
      mkdir(BehaviorFileUtils::targetDirBehaviors());
    }

    // Create folder if it doesn't exists
    if (!is_dir($targetDirId))
    {
      mkdir($targetDirId);
    }

    return $targetDirId;
  }

  /**
   * Create the target directory video of the behavior.
   *
   * @param string $targetDirId The path of the target directory of the behavior.
   * @param string $username The username of the uploader (who is an user).
   * @return string The path of the target directory video of the behavior.
   */
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