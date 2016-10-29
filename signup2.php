<?php
session_start();

require_once "php/classes/SessionData.php";

// Redirect to home page if the user is authenticated
if (isset($_SESSION[SessionData::LOGIN]))
{
  require_once "php/classes/RouteUtils.php";
  RouteUtils::goToHomePage();
}

require_once "php/classes/SignupForm.php";
if (isset($_POST[SignupForm::BTN_SIGNUP]))
{
  $_POST[SigninForm::LOGIN] = StringUtils::clean($_POST[SigninForm::LOGIN]);
  $_POST[SigninForm::FIRSTNAME] = StringUtils::clean($_POST[SigninForm::FIRSTNAME]);
  $_POST[SigninForm::LASTNAME] = StringUtils::clean($_POST[SigninForm::LASTNAME]);
  $_POST[SigninForm::PASSWORD] = StringUtils::clean($_POST[SigninForm::PASSWORD]);
  $_POST[SigninForm::CONFIRM_PASSWORD] = StringUtils::clean($_POST[SigninForm::CONFIRM_PASSWORD]);


  $signupForm = new SignupForm(
    $_POST[SigninForm::LOGIN],
    $_POST[SigninForm::FIRSTNAME],
    $_POST[SigninForm::LASTNAME],
    $_POST[SigninForm::PASSWORD],
    $_POST[SigninForm::CONFIRM_PASSWORD]
  );


  if ($success = $signInForm->performValidation())
  {
    require_once "php/classes/RouteUtils.php";
    RouteUtils::goToHomePage();
  }
}

require_once "php/classes/PageTitle.php";
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
          require_once "php/classes/FormWritter.php";

          // Login
          FormWritter::createLabelInput(
            "Identifiant",
            "text",
            SignupForm::LOGIN,
            isset($_POST[SignupForm::LOGIN]) ? $_POST[SignupForm::LOGIN] : NULL
          );

          // Firstname
          FormWritter::createLabelInput(
            "Prénom",
            "text",
            SignupForm::FIRSTNAME,
            isset($_POST[SignupForm::FIRSTNAME]) ? $_POST[SignupForm::FIRSTNAME] : NULL
          );

          // Lastname
          FormWritter::createLabelInput(
            "Nom",
            "text",
            SignupForm::LASTNAME,
            isset($_POST[SignupForm::LASTNAME]) ? $_POST[SignupForm::LASTNAME] : NULL
          );

          // Password
          FormWritter::createLabelInput(
            "Mot de passe",
            "password",
            SignupForm::PASSWORD,
            isset($_POST[SignupForm::PASSWORD]) ? $_POST[SignupForm::PASSWORD] : NULL
          );

          // Confirm password
          FormWritter::createLabelInput(
            "Confirmation du mot de passe",
            "password",
            SignupForm::CONFIRM_PASSWORD,
            isset($_POST[SignupForm::CONFIRM_PASSWORD]) ? $_POST[SignupForm::CONFIRM_PASSWORD] : NULL
          );

          // Signup button
          FormWritter::createSubmitBtn(SignupForm::BTN_SIGNUP, "S'inscrire");

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