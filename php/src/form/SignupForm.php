<?php
class SignupForm
{
  // Values of each input
  private $login;
  private $firstname;
  private $lastname;
  private $password;
  private $confirmPassword;

  private $errorMessages;

  // Names of each input
  const LOGIN = "login";
  const FIRSTNAME = "firstname";
  const LASTNAME = "lastname";
  const PASSWORD = "password";
  const CONFIRM_PASSWORD = "confirm-password";
  const BTN_SIGNUP = "btn-signup";

  // Criteria
  const MIN_CHAR_PWD = 4;
  const MIN_CHAR_LOGIN = 3;

  public function __construct($login, $firstname, $lastname, $password, $confirmPassword)
  {
      $this->login = $login;
      $this->firstname = $firstname;
      $this->lastname = $lastname;
      $this->password = $password;
      $this->confirmPassword = $confirmPassword;

      $this->errorMessages = [
          self::LOGIN => null,
          self::FIRSTNAME => null,
          self::LASTNAME => null,
          self::PASSWORD => null,
          self::CONFIRM_PASSWORD => null
      ];
  }

  public function getErrorMessage($input)
  {
      return $this->errorMessages[$input];
  }

  public function performValidation()
  {
      // Check all inputs
      return
          $this->isLoginValid() &&
          $this->isFirstnameValid() && $this->isLastnameValid() &&
          $this->isPasswordValid() && $this->isConfirmPasswordValid();
  }

  private function isLoginValid()
  {
      // Check length
      if (strlen($this->login) < self::MIN_CHAR_LOGIN)
      {
          $this->errorMessages[self::LOGIN] = "The login must at least contains " . self::MIN_CHAR_LOGIN . " characters.";
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

  private function isFirstnameValid()
  {
      // Check length
      if (empty($this->firstname))
      {
          $this->errorMessages[self::FIRSTNAME] = "The first name must be specified.";
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

  private function isLastnameValid()
  {
      // Check length
      if (empty($this->lastname))
      {
          $this->errorMessages[self::LASTNAME] = "The last name must be specified.";
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