<?php
require_once "DB.php";

class SigninValidator
{
    private $login;
    private $password;

    const LOGIN = "login";
    const PASSWORD = "password";
    const CONFIRM_PASSWORD = "confirm-password";
    const BTN_SIGNIN = "btn-signin";

    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = sha1($password);
    }

    public function check()
    {
        return DB::run("SELECT User_username, User_firstname, User_lastname FROM User WHERE User_username=? AND User_password=?", [$this->login, $this->password])->fetch();
    }
}
?>