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
  //const CONFIG_PATH = __DIR__ . "/../../../config/config-socket.json";
  const BUFFER_CODE = 5;
  const BUFFER_FILE_SIZE = 8;
  const SKIP_NEXT_BYTE = 1;
  const ERROR = -1;
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
          $str = file_get_contents(__DIR__ . "/../../../config/config-socket.json");
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
      try
      {
          // Create socket
          $socket = self::$socketFactory->createClient(self::$socketAddress);

          // Send number of files (normally it should always be 1)
          $socket->write("1\n");

          // Check if number of files is valid (should always OK be as we only submit one file)
          $code = $socket->read(self::BUFFER_CODE, PHP_NORMAL_READ);
          if (intval($code) === self::ERROR)
          {
              $this->errorMessages[self::BEHAVIOR_FILE] = "The number of files is invalid.";
              $socket->close();
              return null;
          }
          // Skip "\n" from previous read
          $socket->read(self::SKIP_NEXT_BYTE);


          // Send file name and file size
          $socket->write($this->file["name"] . "\n");
          $socket->write($this->file["size"] . "\n");

          // Check if file is valid
          $code = $socket->read(self::BUFFER_CODE, PHP_NORMAL_READ);
          if (intval($code) === self::ERROR)
          {
              $this->errorMessages[self::BEHAVIOR_FILE] = "The name or the size (must be less than 1 Mb) of the file is invalid.";
              $socket->close();
              return null;
          }
          // Skip "\n" from previous read
          $socket->read(self::SKIP_NEXT_BYTE);


          // Send java source code
          $sourceCode = file_get_contents($this->file["tmp_name"], FILE_USE_INCLUDE_PATH);
          $socket->write($sourceCode . "\n");

          // Check if compilation of source code has succeeded
          $code = $socket->read(self::BUFFER_CODE, PHP_NORMAL_READ);
          if (intval($code) === self::ERROR)
          {
              // Skip "\n" from previous read
              $socket->read(self::SKIP_NEXT_BYTE);

              // Get size of the error file
              $errorFileSize = intval($socket->read(self::BUFFER_FILE_SIZE, PHP_NORMAL_READ));

              // Get content of the error file 
              $this->errorMessages[self::BEHAVIOR_FILE] = "Java compilation has failed :\n";
              $socket->read(self::SKIP_NEXT_BYTE);
              while (($buf = $socket->read($errorFileSize)) !== "")
              {
                $this->errorMessages[self::BEHAVIOR_FILE] .= $buf;
              }

              $socket->close();
              return null;
          }
          $socket->read(self::SKIP_NEXT_BYTE);


          // Get size of the dex file.
          $dexFileSize = intval($socket->read(self::BUFFER_FILE_SIZE, PHP_NORMAL_READ));
          $socket->read(self::SKIP_NEXT_BYTE);

          // Get content of the dex file
          $dexFileContent = "";
          while (($buf = $socket->read($dexFileSize)) !== "")
          {
            $dexFileContent .= $buf;
          }

          $socket->close();

          return $dexFileContent;
      }
      catch (Exception $e)
      {}

      return null;
  }

  private function isLabelValid()
  {
      // Check min length
      if (strlen($this->label) < self::MIN_CHAR_LABEL)
      {
          $this->errorMessages[self::LABEL] = "The label must at least contains " . self::MIN_CHAR_LABEL . " characters.";
          return false;
      }

      // Check format
      if (!preg_match(self::LABEL_REGEX, $this->label))
      {
          $this->errorMessages[self::LABEL] = "Only alpha characters are allowed.";
          return false;
      }

      return true;
  }

  private function isDescValid()
  {
      // Check min length
      if (strlen($this->desc) < self::MIN_CHAR_DESC)
      {
          $this->errorMessages[self::DESC] = "The description must at least contains " . self::MIN_CHAR_DESC . " characters.";
          return false;
      }

      return true;
  }

  private function isfileValid()
  {
      // Check if a file has been selected
      if (!isset($this->file) || $this->file["error"] == UPLOAD_ERR_NO_FILE)
      {
          $this->errorMessages[self::BEHAVIOR_FILE] = "No files have been selected.";
          return false;
      }

      // Test if it is a java file, maybe we need to do a stronger verification
      if (strcasecmp(pathinfo($this->file["name"], PATHINFO_EXTENSION), self::ACCEPTED_FILES) !== 0)
      {
          $this->errorMessages[self::BEHAVIOR_FILE] = "The file must be a ." . self::ACCEPTED_FILES . " file.";
          return false;
      }

      return true;
  }
}
?>