<?php
require_once "DB.php";

class SigninForm
{
    private $login;
    private $password;

    const LOGIN = "login";
    const PASSWORD = "password";
    const BTN_SIGNIN = "btn-signin";

    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = sha1($password);
    }

    public function performValidation()
    {
        // User found in database
        if ($result = DB::run("SELECT User_username, User_firstname, User_lastname FROM User WHERE User_username=? AND User_password=?", [$this->login, $this->password])->fetch())
        {
          session_start();

          require_once "SessionData.php";
          $_SESSION[SessionData::LOGIN] = $result["User_username"];
          $_SESSION[SessionData::FIRSTNAME] = $result["User_firstname"];
          $_SESSION[SessionData::LASTNAME] = $result["User_lastname"];

          return true;
        }

        return false;
    }
}
?>