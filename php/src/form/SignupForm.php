<?php
/**
 * The class SignupForm checks if inputs of a
 * submitted signup form are valid.
 */
class SignupForm
{
  /**
   * string The input login content.
   */
  private $login;

  /**
   * string The input first name content.
   */
  private $firstname;

  /**
   * string The input last name content.
   */
  private $lastname;

  /**
   * string The input password content.
   */
  private $password;

  /**
   * string The input confirm password content.
   */  
  private $confirmPassword;

  /**
   * string The name of login input.
   */
  const LOGIN = "login";

  /**
   * string The name of first name input.
   */
  const FIRSTNAME = "firstname";

  /**
   * string The name of last name input.
   */
  const LASTNAME = "lastname";

  /**
   * string The name of password input.
   */
  const PASSWORD = "password";

  /**
   * string The name of confirm password input.
   */
  const CONFIRM_PASSWORD = "confirm-password";

  /**
   * string The name of the sign up button.
   */
  const BTN_SIGNUP = "btn-signup";

  /**
   * integer The minimum number of characters for the password input.
   */
  const MIN_CHAR_PWD = 4;

  /**
   * integer The minimum number of characters for the login input.
   */
  const MIN_CHAR_LOGIN = 3;

  /**
   * integer The maximum number of characters for the login input.
   */
  const MAX_CHAR_LOGIN = 20;

  /**
   * integer The maximum number of characters for the first name input.
   */
  const MAX_CHAR_FIRSTNAME = 30;

  /**
   * integer The maximum number of characters for the last name input.
   */
  const MAX_CHAR_LASTNAME = 30;

  /**
   * [string => string] The associative array to get the messages of each input in case of error.
   */
  private $errorMessages;

   /**
    * Create a SignupForm instance.
    *
    * @param string $login The login content.
    * @param string $firstname The first name content.
    * @param string $lastname The last name content.
    * @param string $password The password content.
    * @param string $confirmPassword The confirm password content.
    */
  public function __construct($login, $firstname, $lastname, $password, $confirmPassword)
  {
    // Save contents
    $this->login = $login;
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->password = $password;
    $this->confirmPassword = $confirmPassword;

    // No errors
    $this->errorMessages = [
        self::LOGIN => null,
        self::FIRSTNAME => null,
        self::LASTNAME => null,
        self::PASSWORD => null,
        self::CONFIRM_PASSWORD => null
    ];
  }

  /**
   * Check if the fields content of the form are valid.
   *  
   * @return boolean True if the fields content of the form are valid or false if they are not.
   */
  public function performValidation()
  {
    // Check all inputs
    return
        $this->isLoginValid() &&
        $this->isFirstnameValid() && $this->isLastnameValid() &&
        $this->isPasswordValid() && $this->isConfirmPasswordValid();
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
   * Check if the login is valid.
   *
   * @return boolean True if the login is valid or false if it is not.
   */ 
  private function isLoginValid()
  {
    // Check length
    $nbCharsLogin = strlen($this->login);
    if ($nbCharsLogin < self::MIN_CHAR_LOGIN || $nbCharsLogin > self::MAX_CHAR_LOGIN)
    {
      $this->errorMessages[self::LOGIN] = "The login must have between " . self::MIN_CHAR_LOGIN . " and " . self::MAX_CHAR_LOGIN ." characters.";
      return false;
    }

    // Check format
    if (!preg_match("/^[a-zA-Z0-9]+$/", $this->login))
  {
      $this->errorMessages[self::LOGIN] = "Only alpha-numeric characters are allowed.";
      return false;
    }

    require_once __DIR__ . "/../database/dao/UserDao.php";
    // Check if login does not already exist in DB
    if (UserDao::find($this->login))
    {
      $this->errorMessages[self::LOGIN] = "The login is already used.";
      return false;
    }

    return true;
  }

  /**
   * Check if the first name is valid.
   *
   * @return boolean True if the first name is valid or false if it is not.
   */ 
  private function isFirstnameValid()
  {
    // Check length
    if (empty($this->firstname))
    {
      $this->errorMessages[self::FIRSTNAME] = "The first name must be specified.";
      return false;
    }

    if (strlen($this->firstname) > self::MAX_CHAR_FIRSTNAME)
    {
      $this->errorMessages[self::FIRSTNAME] = "The firstname can't exceed " . self::MAX_CHAR_FIRSTNAME . " characters.";
      return false;
    }

    // Check format
    if (!preg_match("/^[a-zA-Z]+$/", $this->firstname))
    {
      $this->errorMessages[self::FIRSTNAME] = "Only alpha characters are allowed.";
      return false;
    }

    return true;
  }

  /**
   * Check if the last name is valid.
   *
   * @return boolean True if the last name is valid or false if it is not.
   */ 
  private function isLastnameValid()
  {
    // Check length
    if (empty($this->lastname))
    {
      $this->errorMessages[self::LASTNAME] = "The last name must be specified.";
      return false;
    }

    if (strlen($this->lastname) > self::MAX_CHAR_LASTNAME)
    {
      $this->errorMessages[self::LASTNAME] = "The lastname can't exceed " . self::MAX_CHAR_LASTNAME . " characters.";
      return false;
    }

    // Check format
    if (!preg_match("/^[a-zA-Z]+$/", $this->lastname))
    {
      $this->errorMessages[self::LASTNAME] = "Only alpha characters are allowed.";
      return false;
    }

    return true;
  }

  /**
   * Check if the password is valid.
   *
   * @return boolean True if the password is valid or false if it is not.
   */ 
  private function isPasswordValid()
  {
    // Check length
    if (strlen($this->password) < SignupForm::MIN_CHAR_PWD)
    {
      $this->errorMessages[SignupForm::PASSWORD] = "The password must at least contains " . SignupForm::MIN_CHAR_PWD . " characters.";
      return false;
    }

    return true;
  }

  /**
   * Check if the confirm password is valid.
   *
   * @return boolean True if the confrim password is valid or false if it is not.
   */ 
  private function isConfirmPasswordValid()
  {
    if ($this->password !== $this->confirmPassword)
    {
      $this->errorMessages[SignupForm::CONFIRM_PASSWORD] = "The two passwords are different.";
      return false;
    }

    return true;
  }
}
?>