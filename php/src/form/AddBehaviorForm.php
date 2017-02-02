<?php
require_once __DIR__ . "/../database/DB.php";
require_once __DIR__ . "/../../../vendor/autoload.php";

/**
 * The class AddBehaviorForm checks if inputs of a
 * submitted behavior form are valid.
 */
class AddBehaviorForm
{
  /**
   * string The input label content.
   */
  private $label;

  /**
   * string The input desciption content.
   */
  private $desc;

  /**
   * $_FILES The input java file content.
   */
  private $file;

  /**
   * string The name of label input.
   */
  const LABEL = "label";

  /**
   * string The name of description input.
   */
  const DESC = "description";

  /**
   * string The name of behavior file input.
   */
  const BEHAVIOR_FILE = "behavior-file";

  /**
   * string The name of the add button.
   */
  const BTN_ADD = "btn-add";

  /**
   * integer The minimum number of characters for the label input.
   */
  const MIN_CHAR_LABEL = 2;

  /**
   * integer The maximum number of characters for the label input.
   */
  const MAX_CHAR_LABEL = 50;

  /**
   * string The patter of characters for the label input, only alpha characters.
   */
  const LABEL_REGEX = "/^[a-zA-Z]+$/";

  /**
   * integer The minimum number of characters for the description input.
   */
  const MIN_CHAR_DESC = 2;

  /**
   * integer The maximum number of characters for the description input.
   */
  const MAX_CHAR_DESC = 500;

  /**
   * string The type of files accepted for the behavior file input.
   */
  const ACCEPTED_FILES = "java";

  /**
   * [string => string] The associative array to get the messages of each input in case of error.
   */
  private $errorMessages;

  /**
   * integer The buffer size for read call (socket) when waiting a status code from RobDex.
   */
  const BUFFER_CODE = 5;

  /**
   * integer The buffer size for read call (socket) when waiting a file size from RobDex.
   */
  const BUFFER_FILE_SIZE = 8;

  /**
   * integer The buffer size for read call (socket) to skip a byte.
   */
  const SKIP_NEXT_BYTE = 1;

  /**
   * integer The error code when RobDex sends an error.
   */
  const ERROR = -1;

  /**
   * \Socket\Raw\Factory The socket factory to create a socket.
   */
  private static $socketFactory = null;

  /**
   * \Socket\Raw\Socket The socket.
   */
  private static $socketAddress = null;
 
   /**
    * Create a AddBehaviorFrom instance.
    *
    * @param string $label The label content.
    * @param string $desc The description content.
    * @param $_FILES $file The behavior file content.
    */
  public function __construct($label, $desc, $file)
  {
    // Save contents
    $this->label = $label;
    $this->desc = $desc;
    $this->file = $file;

    // No errors
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

  /**
   * Check if the fields content of the form are valid.
   *  
   * @return string|null The dex content of the compiled Java file or null in case of error.
   */
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
   * Check if the label is valid.
   *
   * @return boolean True if the label is valid or false if it is not.
   */ 
  private function isLabelValid()
  {
    // Check length
    $nbCharsLabel = strlen($this->label);
    if ($nbCharsLabel < self::MIN_CHAR_LABEL || $nbCharsLabel > self::MAX_CHAR_LABEL)
    {
      $this->errorMessages[self::LABEL] = "The label must have between " . self::MIN_CHAR_LABEL . " and " . self::MAX_CHAR_LABEL ." characters.";
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

  /**
   * Check if the description is valid.
   *
   * @return boolean True if the description is valid or false if it is not.
   */ 
  private function isDescValid()
  {
    // Check length
    $nbCharsDesc = strlen($this->desc);
    if ($nbCharsDesc < self::MIN_CHAR_DESC || $nbCharsDesc > self::MAX_CHAR_DESC)
    {
      $this->errorMessages[self::DESC] = "The description must have between " . self::MIN_CHAR_DESC . " and " . self::MAX_CHAR_DESC ." characters.";
      return false;
    }

    return true;
  }

  /**
   * Check if the file is valid.
   *
   * @return boolean True if the file is valid or false if it is not.
   */ 
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

  /**
   * Get the the dex content of the compiled Java file.
   *
   * @return string|null The dex content of the compiled Java file or null in case of error.
   */
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
}
?>