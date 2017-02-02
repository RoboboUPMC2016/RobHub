<?php
/**
 * The class UploadVideoForm checks if inputs of a
 * submitted videom form are valid.
 */
class UploadVideoForm
{
  /**
   * integer The Id of the behavior.
   */
  private $behaviorId;

  /**
   * $_FILES The input video file content.
   */
  private $videoFile;


  /**
   * string The name of behavior input.
   */
  const BEHAVIOR_ID = "behavior";

  /**
   * string The name of video input.
   */
  const VIDEO_FILE = "video-file";

  /**
   * string The name of the add button.
   */
  const BTN_ADD = "btn-add";

  /**
   * string The type of files accepted for the video file input.
   */
  const ACCEPTED_FILES = "mp4";

  /**
   * [string => string] The associative array to get the messages of each input in case of error.
   */
  private $errorMessages;
 
   /**
    * Create a UploadVideoForm instance.
    *
    * @param integer $behaviorId The Id of the behavior.
    * @param $_FILES $videoFile The video file content.
    */
  public function __construct($behaviorId, $videoFile)
  {
    // Keep contents
    $this->videoFile = $videoFile;
    $this->behaviorId = $behaviorId;

    // No error
    $this->errorMessages = [
        self::VIDEO_FILE => null,
        self::BEHAVIOR_ID => null
    ];
  }

 /**
   * Check if the fields content of the form are valid.
   *  
   * @return boolean True if the fields content of the form are valid or false if they are not.
   */
  public function performValidation()
  {
    // Check valid format
    return $this->isBehaviorIdValid() && $this->isfileValid();
  }

  /**
   * Get the error message of an input.
   *
   * @param string The name of the input.
   * @return string|null The error message or null if there is not an error.
   */
  public function getErrorMessage($input)
  {
    return $this->errorMessages[$input];
  }


  /**
   * Check if the behavior Id exists.
   *
   * @return boolean True if the behavior Id exists or false if it does not.
   */ 
  private function isBehaviorIdValid()
  {
    require_once __DIR__ . "/../database/dao/BehaviorDao.php";
    // Behavior not found = invalid id
    if (!BehaviorDao::getById($this->behaviorId))
    {
      $this->errorMessages[self::BEHAVIOR_ID] = "The behavior identifier does not exist.";
      return false;
    }

    return true;
  }

  /**
   * Check if the video file is valid.
   *
   * @return boolean True if the video file is valid or false if it is not.
   */ 
  private function isfileValid()
  {
    // Check if a file has been selected
    if (!isset($this->videoFile) || $this->videoFile["error"] == UPLOAD_ERR_NO_FILE)
    {
      $this->errorMessages[self::VIDEO_FILE] = "No files have been selected.";
      return false;
    }

    // Test if it is a java file, maybe we need to do a stronger verification
    if (strcasecmp(pathinfo($this->videoFile["name"], PATHINFO_EXTENSION), self::ACCEPTED_FILES) !== 0)
    {
      $this->errorMessages[self::VIDEO_FILE] = "The file must be a ." . self::ACCEPTED_FILES . " file.";
      return false;
    }

    // MAYBE CHECK MAX SIZE OF VIDEO FILE ??

    return true;
  }
}
?>