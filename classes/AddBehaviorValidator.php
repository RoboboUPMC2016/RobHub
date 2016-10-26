<?php
require_once "DB.php";

class AddBehaviorValidator
{
    private $label;
    private $desc;
    private $file;
    private $targetFile;

    const LABEL = "label";
    const DESC = "description";
    const BEHAVIOR_FILE = "behavior-file";
    const BTN_ADD = "btn-add";

    private $errorMessages;

    const MIN_CHAR_LABEL = 2;
    const MIN_CHAR_DESC = 2;

    const ACCEPTED_FILES = "java";

    public function __construct($label, $desc, $file, $targetDir)
    {
        $this->label = $label;
        $this->desc = $desc;
        $this->file = $file;
        $this->targetFile = $targetDir . basename($this->file["name"]);

        $this->errorMessages = [
            AddBehaviorValidator::LABEL => "",
            AddBehaviorValidator::DESC => "",
            AddBehaviorValidator::BEHAVIOR_FILE => ""
        ];
    }

    public function getErrorMessage($input)
    {
        return $this->errorMessages[$input];
    }

    public function uploadFile()
    {

        return $this->isLabelValid() && $this->isDescValid() && $this->isfileValid() &&
               move_uploaded_file($this->file["tmp_name"], $this->targetFile);
    }

    private function isLabelValid()
    {
        // Check min length
        if (strlen($this->label) < AddBehaviorValidator::MIN_CHAR_LABEL)
        {
            $this->errorMessages[AddBehaviorValidator::LABEL] = "Le label doit contenir au moins " . AddBehaviorValidator::MIN_CHAR_LABEL . " caractères.";
            return false;
        }

        return true;
    }

    private function isDescValid()
    {
        // Check min length
        if (strlen($this->desc) < AddBehaviorValidator::MIN_CHAR_DESC)
        {
            $this->errorMessages[AddBehaviorValidator::DESC] = "La description doit contenir au moins " . AddBehaviorValidator::MIN_CHAR_DESC . " caractères.";
            return false;
        }

        return true;
    }

    private function isfileValid()
    {
        // Check if a file has been selected
        if (!isset($this->file) || $this->file["error"] == UPLOAD_ERR_NO_FILE)
        {
            $this->errorMessages[AddBehaviorValidator::BEHAVIOR_FILE] = "Aucun fichier n'a été sélectionné.";
            return false;
        }

        // Ttest if it is a java file, maybe we need to do a stronger verification
        if (strcasecmp(pathinfo($this->targetFile, PATHINFO_EXTENSION), AddBehaviorValidator::ACCEPTED_FILES) !== 0)
        {
            $this->errorMessages[AddBehaviorValidator::BEHAVIOR_FILE] = "Le fichier doit être de type ." . AddBehaviorValidator::ACCEPTED_FILES . ".";
            return false;
        }

        return true;
    }
}
?>