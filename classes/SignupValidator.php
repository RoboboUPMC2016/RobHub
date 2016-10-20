<?php
require_once "DB.php";

class SignupValidator
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

    public function __construct($login, $firstname, $lastname, $password, $confirmPassword)
    {
        $this->login = $login;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;

        $this->errorMessages = [
            SignupValidator::LOGIN => "",
            SignupValidator::FIRSTNAME => "",
            SignupValidator::LASTNAME => "",
            SignupValidator::PASSWORD => "",
            SignupValidator::CONFIRM_PASSWORD => ""
        ];
    }

    public function getErrorMessage($input)
    {
        return $this->errorMessages[$input];
    }

    public function check()
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
        if (strlen($this->login) < SignupValidator::MIN_CHAR_LOGIN)
        {
            $this->errorMessages[SignupValidator::LOGIN] = "Le login doit contenir au moins " . SignupValidator::MIN_CHAR_LOGIN . " caractères.";
            return false;
        }

        // Check if login does not already exist in DB
        $row = DB::run("SELECT * FROM User WHERE User_username=?", [$this->login])->fetchColumn();
        if ($row)
        {
            $this->errorMessages[SignupValidator::LOGIN] = "Le login existe déjà.";
            return false;
        }

        return true;
    }

    private function isFirstnameValid()
    {
        if (empty($this->firstname))
        {
            $this->errorMessages[SignupValidator::FIRSTNAME] = "Le prénom ne peut pas être vide.";
            return false;
        }

        if (!preg_match("/^[a-zA-Z]+$/", $this->firstname))
        {
            $this->errorMessages[SignupValidator::FIRSTNAME] = "Seules les lettres sont autorisées.";
            return false;
        }

        return true;
    }

    private function isLastnameValid()
    {
        if (empty($this->lastname))
        {
            $this->errorMessages[SignupValidator::LASTNAME] = "Le nom ne peut pas être vide.";
            return false;
        }

        if (!preg_match("/^[a-zA-Z]+$/", $this->lastname))
        {
            $this->errorMessages[SignupValidator::LASTNAME] = "Seules les lettres sont autorisées.";
            return false;
        }

        return true;
    }

    private function isPasswordValid()
    {
        if (strlen($this->password) < SignupValidator::MIN_CHAR_PWD)
        {
            $this->errorMessages[SignupValidator::PASSWORD] = "Le mot de passe doit contenir au moins " . SignupValidator::MIN_CHAR_PWD . " caractères.";
            return false;
        }

        return true;
    }

    private function isConfirmPasswordValid()
    {
        if (strcmp($this->password, $this->confirmPassword) !== 0)
        {
            $this->errorMessages[SignupValidator::CONFIRM_PASSWORD] = "Les deux mots de passe sont différents.";
            return false;
        }

        return true;
    }
}
?>