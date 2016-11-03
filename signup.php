<?php
session_start();

require_once "php/src/enum/SessionData.php";

// Redirect to home page if the user is authenticated
if (isset($_SESSION[SessionData::LOGIN]))
{
  require_once "php/src/util/RouteUtils.php";
  RouteUtils::goToHomePage();
}

require_once "php/src/form/SignupForm.php";
if (isset($_POST[SignupForm::BTN_SIGNUP]))
{
  require_once "php/src/util/StringUtils.php";

  $_POST[SignupForm::LOGIN] = StringUtils::clean($_POST[SignupForm::LOGIN]);
  $_POST[SignupForm::FIRSTNAME] = StringUtils::clean($_POST[SignupForm::FIRSTNAME]);
  $_POST[SignupForm::LASTNAME] = StringUtils::clean($_POST[SignupForm::LASTNAME]);
  $_POST[SignupForm::PASSWORD] = StringUtils::clean($_POST[SignupForm::PASSWORD]);
  $_POST[SignupForm::CONFIRM_PASSWORD] = StringUtils::clean($_POST[SignupForm::CONFIRM_PASSWORD]);


  $signupForm = new SignupForm(
    $_POST[SignupForm::LOGIN],
    $_POST[SignupForm::FIRSTNAME],
    $_POST[SignupForm::LASTNAME],
    $_POST[SignupForm::PASSWORD],
    $_POST[SignupForm::CONFIRM_PASSWORD]
  );

  if ($success = $signupForm->performValidation())
  {
    require_once "php/src/util/RouteUtils.php";
    RouteUtils::goToHomePage();
  }
}

require_once "php/src/enum/PageTitle.php";
// Set title of the page
$PAGE_TITLE = PageTitle::SIGNUP;

require_once("php/includes/start-html.php");

/****************************************
*  START main content
****************************************/
html::add_attribute("id", "fh5co-intro-section");
html::tag("div");
  html::add_attribute("class", "container");
  html::tag("div");

    // Singup message
    html::add_attribute("class", "row");
    html::tag("div");
      html::add_attribute("class", "col-md-8 col-md-offset-2 text-center");
      html::tag("div");
          html::tag("h2", "Inscription");
      html::close();
    html::close();

    html::add_attribute("class", "row");
    html::tag("div");
      html::add_attribute("class", "col-md-push-1 col-sm-12 col-sm-push-0 col-xs-12 col-xs-push-0");
      html::tag("div");

        // Form
        html::add_attributes(["class" => "row", "method" => "post"]);
        html::tag("form");
          require_once "php/src/util/HtmlWritterUtils.php";

          // Create error messages for inputs
          $inputErrorMessages = [
            SignupForm::LOGIN => NULL,
            SignupForm::FIRSTNAME => NULL,
            SignupForm::LASTNAME => NULL,
            SignupForm::PASSWORD => NULL,
            SignupForm::CONFIRM_PASSWORD => NULL
         ];

          if (isset($signupForm))
          {
            // Get error messages
            foreach ($inputErrorMessages as $key => $value)
            {
              $inputErrorMessages[$key] = $signupForm->getErrorMessage($key);
            }
          }

          // Login
          html::insert_code(HtmlWritterUtils::createLabelInput(
            "Identifiant",
            "text",
            SignupForm::LOGIN,
            isset($_POST[SignupForm::LOGIN]) ? $_POST[SignupForm::LOGIN] : NULL,
            $inputErrorMessages[SignupForm::LOGIN]
          ));

          // Firstname
          html::insert_code(HtmlWritterUtils::createLabelInput(
            "Prénom",
            "text",
            SignupForm::FIRSTNAME,
            isset($_POST[SignupForm::FIRSTNAME]) ? $_POST[SignupForm::FIRSTNAME] : NULL,
            $inputErrorMessages[SignupForm::FIRSTNAME]
          ));

          // Lastname
          html::insert_code(HtmlWritterUtils::createLabelInput(
            "Nom",
            "text",
            SignupForm::LASTNAME,
            isset($_POST[SignupForm::LASTNAME]) ? $_POST[SignupForm::LASTNAME] : NULL,
            $inputErrorMessages[SignupForm::LASTNAME]
          ));

          // Password
          html::insert_code(HtmlWritterUtils::createLabelInput(
            "Mot de passe",
            "password",
            SignupForm::PASSWORD,
            NULL,
            $inputErrorMessages[SignupForm::PASSWORD]
          ));

          // Confirm password
          html::insert_code(HtmlWritterUtils::createLabelInput(
            "Confirmation du mot de passe",
            "password",
            SignupForm::CONFIRM_PASSWORD,
            NULL,
            $inputErrorMessages[SignupForm::CONFIRM_PASSWORD]
          ));

          // Signup button
          html::nl();
          html::insert_code(HtmlWritterUtils::createSubmitBtn(SignupForm::BTN_SIGNUP, "S'inscrire"));
        html::close();
      html::close();
    html::close();
  html::close();
  
  require_once "php/includes/footer.php";
html::close();
/****************************************
*  END main content
****************************************/

require_once("php/includes/end-html.php");
?>