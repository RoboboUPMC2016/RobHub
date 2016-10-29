<?php
require_once "DB.php";

class SignupForm
{
    private $login;
    private $firstname;
    private $lastname;
    private $password;
    private $confirmPassword;

    private $errorMessages;

    const LOGIN = "login";
    const FIRSTNAME = "firstname";
    const LASTNAME = "lastname";
    const PASSWORD = "password";
    const CONFIRM_PASSWORD = "confirm-password";
    const BTN_SIGNUP = "btn-signup";

    const MIN_CHAR_PWD = 4;
    const MIN_CHAR_LOGIN = 3;

    const SUCCESS_SIGNUP = 0;
    const ERROR_LOGIN_LENGTH = -1;
    const ERROR_LOGIN_EXISTS = -2;
    const ERROR_FIRSTNAME_LENGTH = -3;
    const ERROR_FIRSTNAME_FORMAT = -4;
    const ERROR_LASTNAME_LENGTH = -5;
    const ERROR_LASTNAME_FORMAT = -6;
    const ERROR_PASSWORD_LENGTH = -7;
    const ERROR_CONFIRM_PASSWORD_INVALID = -8;

    public function __construct($login, $firstname, $lastname, $password, $confirmPassword)
    {
        $this->login = $login;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
    }

    public function performValidation()
    {
        return 
            $this->isLoginValid() &&
            $this->isFirstnameValid() &&
            $this->isLastnameValid() &&
            $this->isPasswordValid() &&
            $this->isConfirmPasswordValid();
    }

    private function isLoginValid()
    {
        if (strlen($this->login) < SignupForm::MIN_CHAR_LOGIN)
        {
            /*$this->errorMessages[SignupForm::LOGIN] = "Le login doit contenir au moins " . SignupForm::MIN_CHAR_LOGIN . " caractères.";*/
            return SignupForm::ERROR_LOGIN_LENGTH;
        }

        // Check if login does not already exist in DB
        if ($row = DB::run("SELECT * FROM User WHERE User_username=?", [$this->login])->fetchColumn())
        {
            //$this->errorMessages[SignupForm::LOGIN] = "Le login existe déjà.";
            return SignupForm::ERROR_LOGIN_EXISTS;
        }

        return SignupForm::SUCCESS_SIGNUP;
    }

    private function isFirstnameValid()
    {
        if (empty($this->firstname))
        {
            //$this->errorMessages[SignupForm::FIRSTNAME] = "Le prénom ne peut pas être vide.";
            return SignupForm::ERROR_FIRSTNAME_LENGTH;
        }

        if (!preg_match("/^[a-zA-Z]+$/", $this->firstname))
        {
            //$this->errorMessages[SignupForm::FIRSTNAME] = "Seules les lettres sont autorisées.";
            return false;
        }

        return SignupForm::SUCCESS_SIGNUP;
    }

    private function isLastnameValid()
    {
        if (empty($this->lastname))
        {
            //$this->errorMessages[SignupForm::LASTNAME] = "Le nom ne peut pas être vide.";
            return false;
        }

        if (!preg_match("/^[a-zA-Z]+$/", $this->lastname))
        {
            //$this->errorMessages[SignupForm::LASTNAME] = "Seules les lettres sont autorisées.";
            return false;
        }

        return SignupForm::SUCCESS_SIGNUP;
    }

    private function isPasswordValid()
    {
        if (strlen($this->password) < SignupForm::MIN_CHAR_PWD)
        {
       /*     $this->errorMessages[SignupForm::PASSWORD] = "Le mot de passe doit contenir au moins " . SignupForm::MIN_CHAR_PWD . " caractères.";*/
            return SignupForm::ERROR_PASSWORD_LENGTH;
        }

        return SignupForm::SUCCESS_SIGNUP;
    }

    private function isConfirmPasswordValid()
    {
        if ($this->password !== $this->confirmPassword)
        {
            //$this->errorMessages[SignupForm::CONFIRM_PASSWORD] = "Les deux mots de passe sont différents.";
            return SignupForm::ERROR_CONFIRM_PASSWORD_INVALID;
        }

        return SignupForm::SUCCESS_SIGNUP;
    }
}
?>