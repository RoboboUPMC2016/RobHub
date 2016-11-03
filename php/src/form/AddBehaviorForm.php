<?php
require_once "php/src/database/DB.php";

class AddBehaviorForm
{
    private $user;
    private $label;
    private $desc;
    private $file;
    private $targetFile;

    const LABEL = "label";
    const DESC = "description";
    const BEHAVIOR_FILE = "behavior-file";
    const BTN_ADD = "btn-add";

    const TARGET_DIR = "behaviors/";

    private $errorMessages;

    const MIN_CHAR_LABEL = 2;
    const LABEL_REGEX = "/^[a-zA-Z]+$/";

    const MIN_CHAR_DESC = 2;

    const ACCEPTED_FILES = "java";

    public function __construct($user, $label, $desc, $file)
    {
        $this->user = $user;
        $this->label = $label;
        $this->desc = $desc;
        $this->file = $file;

        // Name file with user and label and add timestamp to not erase other files
        // File name example : user-file12346898956
        $this->targetFile = AddBehaviorForm::TARGET_DIR . $user . "-" . basename($label) . time() .
                            "." . AddBehaviorForm::ACCEPTED_FILES;
        $this->errorMessages = [
            AddBehaviorForm::LABEL => "",
            AddBehaviorForm::DESC => "",
            AddBehaviorForm::BEHAVIOR_FILE => ""
        ];
    }

    public function getErrorMessage($input)
    {
        return $this->errorMessages[$input];
    }

    public function uploadFile()
    {
        if ($this->isLabelValid() && $this->isDescValid() && $this->isfileValid()) {
            // Insert Behavior in DB
            $stmt = DB::prepare("INSERT INTO Behavior (Behavior_label, Behavior_description, User_username,   Behavior_timestamp) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$this->label, $this->desc, $this->user, date("Y-m-d H:i:s")]))
            {
              // Create file
              return move_uploaded_file($this->file["tmp_name"], $this->targetFile);
            }
        }

        return false;
    }

    private function isLabelValid()
    {
        // Check min length
        if (strlen($this->label) < AddBehaviorForm::MIN_CHAR_LABEL)
        {
            $this->errorMessages[AddBehaviorForm::LABEL] = "Le label doit contenir au moins " . AddBehaviorForm::MIN_CHAR_LABEL . " caractères.";
            return false;
        }

        // Check format
        if (!preg_match(AddBehaviorForm::LABEL_REGEX, $this->label))
        {
            $this->errorMessages[AddBehaviorForm::LABEL] = "Seules les lettres sont autorisées.";
            return false;
        }

        return true;
    }

    private function isDescValid()
    {
        // Check min length
        if (strlen($this->desc) < AddBehaviorForm::MIN_CHAR_DESC)
        {
            $this->errorMessages[AddBehaviorForm::DESC] = "La description doit contenir au moins " . AddBehaviorForm::MIN_CHAR_DESC . " caractères.";
            return false;
        }

        return true;
    }

    private function isfileValid()
    {
        // Check if a file has been selected
        if (!isset($this->file) || $this->file["error"] == UPLOAD_ERR_NO_FILE)
        {
            $this->errorMessages[AddBehaviorForm::BEHAVIOR_FILE] = "Aucun fichier n'a été sélectionné.";
            return false;
        }

        // Ttest if it is a java file, maybe we need to do a stronger verification
        if (strcasecmp(pathinfo($this->targetFile, PATHINFO_EXTENSION), AddBehaviorForm::ACCEPTED_FILES) !== 0)
        {
            $this->errorMessages[AddBehaviorForm::BEHAVIOR_FILE] = "Le fichier doit être de type ." . AddBehaviorForm::ACCEPTED_FILES . ".";
            return false;
        }

        return true;
    }
}
?>