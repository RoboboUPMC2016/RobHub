<?php
require_once __DIR__ . "/../database/DB.php";
require_once __DIR__ . "/../../../vendor/autoload.php";

class AddBehaviorForm
{
    // Reference to input data
    private $label;
    private $desc;
    private $file;

    // Names of each input
    const LABEL = "label";
    const DESC = "description";
    const BEHAVIOR_FILE = "behavior-file";
    const BTN_ADD = "btn-add";

    // Socket info
    const CONFIG_PATH = __DIR__ . "/../../../config/config-socket.json";
    const BUFFER_CODE = 3;
    private static $socketFactory = null;
    private static $socketAddress = null;

    private $errorMessages;

    // All criteria when checking inputs
    const MIN_CHAR_LABEL = 2;
    const LABEL_REGEX = "/^[a-zA-Z]+$/";

    const MIN_CHAR_DESC = 2;

    const ACCEPTED_FILES = "java";

    public function __construct($label, $desc, $file)
    {
        $this->label = $label;
        $this->desc = $desc;
        $this->file = $file;

        $this->errorMessages = [
            self::LABEL => null,
            self::DESC => null,
            self::BEHAVIOR_FILE => null
        ];

        // Only init socket factory once
        if (self::$socketFactory === null)
        {
            self::$socketFactory = new \Socket\Raw\Factory();

            // Load data from config json file
            $str = file_get_contents(self::CONFIG_PATH);
            $socketInfo = json_decode($str, true);

            // Create socket address
            self::$socketAddress = $socketInfo["protocol"] . "://" . $socketInfo["address"] . ":" . $socketInfo["port"];
        }
    }

    public function getErrorMessage($input)
    {
        return $this->errorMessages[$input];
    }

    public function performValidation()
    {
        // Check if input are OK
        if ($this->isLabelValid() && $this->isDescValid() && $this->isfileValid())
        {
            // Return dex content
            return $this->javaToDex();
        }

        return null;
    }

    private function javaToDex()
    {
        // Create socket
        $socket = self::$socketFactory->createClient(self::$socketAddress);

        // Send number of files (normally it should always be 1)
        $socket->write("1\n");

        // Check if number of file is valid (should always be OK)
        $code = $socket->read(self::BUFFER_CODE);
        if (intval($code) === -1)
        {
            $this->errorMessages[self::BEHAVIOR_FILE] = "Le nombre de fichier est invalide.";
            $socket->close();
            return null;
        }

        // Send file name and file size
        $socket->write($this->file["name"] . "\n");
        $socket->write($this->file["size"] . "\n");

        // Check if file is valid
        $code = $socket->read(self::BUFFER_CODE);
        if (intval($code) === -1)
        {
            $this->errorMessages[self::BEHAVIOR_FILE] = "Le nom ou la taille du fichier est invalide.";
            $socket->close();
            return null;
        }

        // Send java source code
        $sourceCode = file_get_contents($this->file["tmp_name"], FILE_USE_INCLUDE_PATH);
        $socket->write($sourceCode . "\n");

        // Check if compilation of source code has succeeded
        $code = $socket->read(self::BUFFER_CODE);
        if (intval($code) === -1)
        {
            $this->errorMessages[self::BEHAVIOR_FILE] = "La compilation du fichier java a échoué.";
            $socket->close();
            return null;
        }

        // Get size and content of the dex file
        $dexFileSize = intval($socket->read(128));
        $dexFileContent = $socket->read($dexFileSize);

        $socket->close();

        return $dexFileContent;
    }

    private function isLabelValid()
    {
        // Check min length
        if (strlen($this->label) < self::MIN_CHAR_LABEL)
        {
            $this->errorMessages[self::LABEL] = "Le label doit contenir au moins " . self::MIN_CHAR_LABEL . " caractères.";
            return false;
        }

        // Check format
        if (!preg_match(self::LABEL_REGEX, $this->label))
        {
            $this->errorMessages[self::LABEL] = "Seules les lettres sont autorisées.";
            return false;
        }

        return true;
    }

    private function isDescValid()
    {
        // Check min length
        if (strlen($this->desc) < self::MIN_CHAR_DESC)
        {
            $this->errorMessages[self::DESC] = "La description doit contenir au moins " . self::MIN_CHAR_DESC . " caractères.";
            return false;
        }

        return true;
    }

    private function isfileValid()
    {
        // Check if a file has been selected
        if (!isset($this->file) || $this->file["error"] == UPLOAD_ERR_NO_FILE)
        {
            $this->errorMessages[self::BEHAVIOR_FILE] = "Aucun fichier n'a été sélectionné.";
            return false;
        }

        // Test if it is a java file, maybe we need to do a stronger verification
        if (strcasecmp(pathinfo($this->file["name"], PATHINFO_EXTENSION), self::ACCEPTED_FILES) !== 0)
        {
            $this->errorMessages[self::BEHAVIOR_FILE] = "Le fichier doit être de type ." . self::ACCEPTED_FILES . ".";
            return false;
        }

        return true;
    }
}
?>