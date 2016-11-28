<?php
require_once "php/src/database/DB.php";

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
        require_once __DIR__ . "/../database/dao/UserDao.php";
        return UserDao::get($this->login, $this->password);
    }
}
?>