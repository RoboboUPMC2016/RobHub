<?php
session_start();

require_once "php/classes/SessionData.php";

// Redirect to home page if the user is authenticated
if (isset($_SESSION[SessionData::LOGIN]))
{
  require_once "php/classes/RouteUtils.php";
  RouteUtils::goToHomePage();
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

    // Connexion message
    html::add_attribute("class", "row");
    html::tag("div");
      html::add_attribute("class", "col-md-8 col-md-offset-2 text-center");
      html::tag("div");
          html::tag("h2", "Connexion");
          if (isset($success) && !$success)
          {
            html::add_attribute("class", "invalidInput");
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
          // Login input
          html::add_attribute("class", "col-md-11");
          html::tag("div");
            html::add_attribute("class", "form-group");
            html::tag("div");
              html::add_attributes(["class" => "form-control", "placeholder" => "Identifiant", "type" => "text", "name" => SigninForm::LOGIN,
                                    "value" => StringUtils::getContent($_POST[SigninForm::LOGIN])]);
              html::single_tag("input");
            html::close();
          html::close();

          // Password input
          html::add_attribute("class", "col-md-11");
          html::tag("div");
            html::add_attribute("class", "form-group");
            html::tag("div");
              html::add_attributes(["class" => "form-control", "placeholder" => "Mot de passe", "type" => "password", "name" => SigninForm::PASSWORD]);
              html::single_tag("input");
            html::close();
          html::close();

          // Submit button
          html::add_attribute("class", "col-md-12");
          html::tag("div");
            html::add_attribute("class", "form-group");
            html::tag("div");
              html::add_attributes(["class" => "btn btn-primary", "type" => "submit", "name" => SigninForm::BTN_SIGNIN, "value" => "Se connecter"]);
              html::single_tag("input");
            html::close();
          html::close();

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