<?php
class UploadVideoForm
{
    // Names/Id of each inputs
    const VIDEO_FILE = "video-file";
    const BEHAVIOR_ID = "behavior";
    const BTN_ADD = "btn-add";

    // Values
    private $videoFile;
    private $behaviorId;

    private $errorMessages;

    // Criteria
    const ACCEPTED_FILES = "mp4";

    public function __construct($behaviorId, $videoFile)
    {
        $this->videoFile = $videoFile;
        $this->behaviorId = $behaviorId;

        $this->errorMessages = [
            self::VIDEO_FILE => null,
            self::BEHAVIOR_ID => null
        ];
    }

    public function getErrorMessage($input)
    {
        return $this->errorMessages[$input];
    }

    public function performValidation()
    {
        // Check valid format
        return $this->isBehaviorIdValid() && $this->isfileValid();
    }

    private function isBehaviorIdValid()
    {
      require_once __DIR__ . "/../database/dao/BehaviorDao.php";
      // Behavior not found = invalid id
      if (!BehaviorDao::getById($this->behaviorId))
      {
        $this->errorMessages[self::BEHAVIOR_ID] = "L'identifiant du comportement n'existe pas.";
        return false;
      }

      return true;
    }

    private function isfileValid()
    {
        // Check if a file has been selected
        if (!isset($this->videoFile) || $this->videoFile["error"] == UPLOAD_ERR_NO_FILE)
        {
            $this->errorMessages[self::VIDEO_FILE] = "Aucun fichier n'a été sélectionné.";
            return false;
        }

        // Test if it is a java file, maybe we need to do a stronger verification
        if (strcasecmp(pathinfo($this->videoFile["name"], PATHINFO_EXTENSION), self::ACCEPTED_FILES) !== 0)
        {
            $this->errorMessages[self::VIDEO_FILE] = "Le fichier doit être de type ." . self::ACCEPTED_FILES . ".";
            return false;
        }

        return true;
    }
}
?>