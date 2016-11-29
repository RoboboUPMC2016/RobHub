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
            $this->errorMessages[self::LOGIN] = "Le login doit contenir au moins " . self::MIN_CHAR_LOGIN . " caractères.";
            return false;
        }

        // Check format
        if (!preg_match("/^[a-zA-Z0-9]+$/", $this->login))
        {
            $this->errorMessages[self::LOGIN] = "Seules les lettres et les chiffres sont autorisées.";
            return false;
        }

        require_once __DIR__ . "/../database/dao/UserDao.php";
        // Check if login does not already exist in DB
        if (UserDao::find($this->login))
        {
            $this->errorMessages[self::LOGIN] = "Le login existe déjà.";
            return false;
        }

        return true;
    }

    private function isFirstnameValid()
    {
        // Check length
        if (empty($this->firstname))
        {
            $this->errorMessages[self::FIRSTNAME] = "Le prénom ne peut pas être vide.";
            return false;
        }

        // Check format
        if (!preg_match("/^[a-zA-Z]+$/", $this->firstname))
        {
            $this->errorMessages[self::FIRSTNAME] = "Seules les lettres sont autorisées.";
            return false;
        }

        return true;
    }

    private function isLastnameValid()
    {
        // Check length
        if (empty($this->lastname))
        {
            $this->errorMessages[self::LASTNAME] = "Le nom ne peut pas être vide.";
            return false;
        }

        // Check format
        if (!preg_match("/^[a-zA-Z]+$/", $this->lastname))
        {
            $this->errorMessages[self::LASTNAME] = "Seules les lettres sont autorisées.";
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