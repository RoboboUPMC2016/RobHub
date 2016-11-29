<?php
session_start();

require_once __DIR__ . "/php/src/enum/SessionData.php";

// Redirect to home page if the user is authenticated
if (isset($_SESSION[SessionData::LOGIN]))
{
  require_once __DIR__ . "/php/src/util/RouteUtils.php";
  RouteUtils::goToHomePage();
}

require_once __DIR__ . "/php/src/form/SigninForm.php";

// Sign in btn pressed
if (isset($_POST[SigninForm::BTN_SIGNIN]))
{
  require_once __DIR__ . "/php/src/util/StringUtils.php";
  // Clean inputs
  $_POST[SigninForm::LOGIN] = StringUtils::clean($_POST[SigninForm::LOGIN]);
  $_POST[SigninForm::PASSWORD] = StringUtils::clean($_POST[SigninForm::PASSWORD]);

  // Create form
  $signInForm = new SigninForm($_POST[SigninForm::LOGIN], $_POST[SigninForm::PASSWORD]);

  // Check if user found
  $user = $signInForm->performValidation();
  if ($user !== null)
  {
    session_start();

    require_once __DIR__ . "/php/src/enum/SessionData.php";
    // Create session value
    $_SESSION[SessionData::LOGIN] = $user->username;
    $_SESSION[SessionData::FIRSTNAME] = $user->firstname;
    $_SESSION[SessionData::LASTNAME] = $user->lastname;

    require_once __DIR__ . "/php/src/util/RouteUtils.php";
    RouteUtils::goToHomePage();
  }
  else
  {
    $success = false;
  }
}


require_once __DIR__ . "/php/src/enum/PageTitle.php";
// Set title of the page
$PAGE_TITLE = PageTitle::SIGNIN;

require_once __DIR__ . "/php/includes/start-html.php";

/****************************************
*  START main content
****************************************/
html::add_attribute("id", "fh5co-intro-section");
html::tag("div");
  html::add_attribute("class", "container");
  html::tag("div");

    // Connexion message
    html::add_attribute("class", "row");
    html::tag("div");
      html::add_attribute("class", "col-md-8 col-md-offset-2 text-center");
      html::tag("div");
          html::tag("h2", "Connexion");

          // Invalid id/pass
          if (isset($success) && !$success)
          {
            html::add_attribute("class", "errorMsg");
            html::tag("span", "Identifiant ou mot de passe incorect.");
          }
      html::close();
    html::close();

    html::add_attribute("class", "row");
    html::tag("div");
      html::add_attribute("class", "col-md-push-1 col-sm-12 col-sm-push-0 col-xs-12 col-xs-push-0");
      html::tag("div");

        // Form
        html::add_attributes(["class" => "row", "method" => "post"]);
        html::tag("form");
          require_once __DIR__ . "/php/src/util/HtmlWriterUtils.php";

          // Login
          html::insert_code(HtmlWriterUtils::createLabelInput(
            "Identifiant",
            "text",
            SigninForm::LOGIN,
            isset($_POST[SigninForm::LOGIN]) ? $_POST[SigninForm::LOGIN] : null
          ));

          // Password
          html::insert_code(HtmlWriterUtils::createLabelInput(
            "Mot de passe",
            "password",
            SigninForm::PASSWORD,
            null
          ));

          // Submit button
          html::nl();
          html::insert_code(HtmlWriterUtils::createSubmitBtn(SigninForm::BTN_SIGNIN, "Se connecter"));

        html::close();
      html::close();
    html::close();
  html::close();
  
  require_once __DIR__ . "/php/includes/footer.php";
html::close();
/****************************************
*  END main content
****************************************/

require_once __DIR__ . "/php/includes/end-html.php";
?>