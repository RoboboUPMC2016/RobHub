<?php

/**
 * The class SigninForm checks if inputs of 
 * submited credentials form are valid.
 */
class SigninForm
{
  /**
   * string The input login content.
   */
  private $login;

  /**
   * string The input password content.
   */
  private $password;

  /**
   * string The name of login input.
   */
  const LOGIN = "login";

  /**
   * string The name of password input.
   */
  const PASSWORD = "password";

  /**
   * string The name of the sign in button.
   */
  const BTN_SIGNIN = "btn-signin";

 /**
  * Create a SigninForm instance.
  *
  * @param string $login The login content.
  * @param string $password The password content.
  */
  public function __construct($login, $password)
  {
    $this->login = $login;
    $this->password = sha1($password);
  }

  /**
   * Check if the fields content of the form are valid.
   *  
   * @return \src\database\entity\User|null The authenticated user or null if not found.
   */
  public function performValidation()
  {
    require_once __DIR__ . "/../database/dao/UserDao.php";
    return UserDao::get($this->login, $this->password);
  }
}
?>