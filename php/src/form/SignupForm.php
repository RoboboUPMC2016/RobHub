<?php
require_once "php/src/database/DB.php";

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

    public function __construct($login, $firstname, $lastname, $password, $confirmPassword)
    {
        $this->login = $login;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;

        $this->errorMessages = [
            SignupForm::LOGIN => NULL,
            SignupForm::FIRSTNAME => NULL,
            SignupForm::LASTNAME => NULL,
            SignupForm::PASSWORD => NULL,
            SignupForm::CONFIRM_PASSWORD => NULL
        ];
    }

    public function getErrorMessage($input)
    {
        return $this->errorMessages[$input];
    }

    public function performValidation()
    {
        // Check all input
        if ($this->isLoginValid() &&
            $this->isFirstnameValid() && $this->isLastnameValid() &&
            $this->isPasswordValid() && $this->isConfirmPasswordValid())
        {
          // Insert user in database
          $stmt = DB::prepare("INSERT INTO User (User_username, User_password, User_firstname, User_lastname) VALUES (?, ?, ?, ?)");
          if ($stmt->execute([$this->login, sha1($this->password), $this->firstname, $this->lastname]))
          {
            session_start();
            $_SESSION["login"] = $_POST[SignupForm::LOGIN];
            $_SESSION["firstname"] = $_POST[SignupForm::FIRSTNAME];
            $_SESSION["lastname"] = $_POST[SignupForm::LASTNAME];

            return true;
          }
        }

        return false;
    }

    private function isLoginValid()
    {
        // Check length
        if (strlen($this->login) < SignupForm::MIN_CHAR_LOGIN)
        {
            $this->errorMessages[SignupForm::LOGIN] = "Le login doit contenir au moins " . SignupForm::MIN_CHAR_LOGIN . " caractères.";
            return false;
        }

        // Check format
        if (!preg_match("/^[a-zA-Z0-9]+$/", $this->login))
        {
            $this->errorMessages[SignupForm::LOGIN] = "Seules les lettres et les chiffres sont autorisées.";
            return false;
        }

        // Check if login does not already exist in DB
        if ($row = DB::run("SELECT * FROM User WHERE User_username=?", [$this->login])->fetchColumn())
        {
            $this->errorMessages[SignupForm::LOGIN] = "Le login existe déjà.";
            return false;
        }

        return true;
    }

    private function isFirstnameValid()
    {
        // Check length
        if (empty($this->firstname))
        {
            $this->errorMessages[SignupForm::FIRSTNAME] = "Le prénom ne peut pas être vide.";
            return false;
        }

        // Check format
        if (!preg_match("/^[a-zA-Z]+$/", $this->firstname))
        {
            $this->errorMessages[SignupForm::FIRSTNAME] = "Seules les lettres sont autorisées.";
            return false;
        }

        return true;
    }

    private function isLastnameValid()
    {
        // Check length
        if (empty($this->lastname))
        {
            $this->errorMessages[SignupForm::LASTNAME] = "Le nom ne peut pas être vide.";
            return false;
        }

        // Check format
        if (!preg_match("/^[a-zA-Z]+$/", $this->lastname))
        {
            $this->errorMessages[SignupForm::LASTNAME] = "Seules les lettres sont autorisées.";
            return false;
        }

        return true;
    }

    private function isPasswordValid()
    {
        // Check length
        if (strlen($this->password) < SignupForm::MIN_CHAR_PWD)
        {
            $this->errorMessages[SignupForm::PASSWORD] = "Le mot de passe doit contenir au moins " . SignupForm::MIN_CHAR_PWD . " caractères.";
            return false;
        }

        return true;
    }

    private function isConfirmPasswordValid()
    {
        if ($this->password !== $this->confirmPassword)
        {
            $this->errorMessages[SignupForm::CONFIRM_PASSWORD] = "Les deux mots de passe sont différents.";
            return false;
        }

        return true;
    }
}
?>