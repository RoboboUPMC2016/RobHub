<?php
require_once "DB.php";

class FormValidator
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
            FormValidator::LOGIN => "",
            FormValidator::FIRSTNAME => "",
            FormValidator::LASTNAME => "",
            FormValidator::PASSWORD => "",
            FormValidator::CONFIRM_PASSWORD => ""
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
        if (strlen($this->login) < FormValidator::MIN_CHAR_LOGIN)
        {
            $this->errorMessages[FormValidator::LOGIN] = "Le login doit contenir au moins " . FormValidator::MIN_CHAR_LOGIN . " caractères.";
            return false;
        }

        // Check if login does not already exist in DB
        $row = DB::run("SELECT * FROM User WHERE User_username=?", [$this->login])->fetchColumn();
        if ($row)
        {
            $this->errorMessages[FormValidator::LOGIN] = "Le login existe déjà.";
            return false;
        }

        return true;
    }

    private function isFirstnameValid()
    {
        if (empty($this->firstname))
        {
            $this->errorMessages[FormValidator::FIRSTNAME] = "Le prénom ne peut pas être vide.";
            return false;
        }

        if (!preg_match("/^[a-zA-Z]+$/", $this->firstname))
        {
            $this->errorMessages[FormValidator::FIRSTNAME] = "Seules les lettres sont autorisées.";
            return false;
        }

        return true;
    }

    private function isLastnameValid()
    {
        if (empty($this->lastname))
        {
            $this->errorMessages[FormValidator::LASTNAME] = "Le nom ne peut pas être vide.";
            return false;
        }

        if (!preg_match("/^[a-zA-Z]+$/", $this->lastname))
        {
            $this->errorMessages[FormValidator::LASTNAME] = "Seules les lettres sont autorisées.";
            return false;
        }

        return true;
    }

    private function isPasswordValid()
    {
        if (strlen($this->password) < FormValidator::MIN_CHAR_PWD)
        {
            $this->errorMessages[FormValidator::PASSWORD] = "Le mot de passe doit contenir au moins " . FormValidator::MIN_CHAR_PWD . " caractères.";
            return false;
        }

        return true;
    }

    private function isConfirmPasswordValid()
    {
        if (strcmp($this->password, $this->confirmPassword) !== 0)
        {
            $this->errorMessages[FormValidator::CONFIRM_PASSWORD] = "Les deux mots de passe sont différents.";
            return false;
        }

        return true;
    }
}
?>