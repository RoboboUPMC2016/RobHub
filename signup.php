<?php
session_start();

require_once __DIR__ . "/php/src/enum/SessionData.php";

// Redirect to home page if the user is authenticated
if (isset($_SESSION[SessionData::LOGIN]))
{
  require_once __DIR__ . "/php/src/util/RouteUtils.php";
  RouteUtils::goToHomePage();
}

require_once __DIR__ . "/php/src/form/SignupForm.php";
// Btn create account pressed
if (isset($_POST[SignupForm::BTN_SIGNUP]))
{
  require_once __DIR__ . "/php/src/util/StringUtils.php";

  // Clean input
  $_POST[SignupForm::LOGIN] = StringUtils::clean($_POST[SignupForm::LOGIN]);
  $_POST[SignupForm::FIRSTNAME] = StringUtils::clean($_POST[SignupForm::FIRSTNAME]);
  $_POST[SignupForm::LASTNAME] = StringUtils::clean($_POST[SignupForm::LASTNAME]);
  $_POST[SignupForm::PASSWORD] = StringUtils::clean($_POST[SignupForm::PASSWORD]);
  $_POST[SignupForm::CONFIRM_PASSWORD] = StringUtils::clean($_POST[SignupForm::CONFIRM_PASSWORD]);

  // Create form
  $signupForm = new SignupForm(
    $_POST[SignupForm::LOGIN],
    $_POST[SignupForm::FIRSTNAME],
    $_POST[SignupForm::LASTNAME],
    $_POST[SignupForm::PASSWORD],
    $_POST[SignupForm::CONFIRM_PASSWORD]
  );

  // Check inputs
  if ($signupForm->performValidation())
  {
    require_once __DIR__ . "/php/src/database/dao/UserDao.php";
    // Insert user in database
    if (UserDao::add(
      $_POST[SignupForm::LOGIN],
      sha1($_POST[SignupForm::PASSWORD]),
      $_POST[SignupForm::FIRSTNAME],
      $_POST[SignupForm::LASTNAME]
    ))
    {
      // Create session
      session_start();
      $_SESSION["login"] = $_POST[SignupForm::LOGIN];
      $_SESSION["firstname"] = $_POST[SignupForm::FIRSTNAME];
      $_SESSION["lastname"] = $_POST[SignupForm::LASTNAME];

      require_once __DIR__ . "/php/src/util/RouteUtils.php";
      RouteUtils::goToHomePage();
    }
  }
}

require_once __DIR__ . "/php/src/enum/PageTitle.php";
// Set title of the page
$PAGE_TITLE = PageTitle::SIGNUP;

require_once __DIR__ . "/php/includes/start-html.php";

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
          html::tag("h2", "Sign up");
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

          // Create error messages for inputs
          $inputErrorMessages = [
            SignupForm::LOGIN => null,
            SignupForm::FIRSTNAME => null,
            SignupForm::LASTNAME => null,
            SignupForm::PASSWORD => null,
            SignupForm::CONFIRM_PASSWORD => null
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
          html::insert_code(HtmlWriterUtils::createLabelInput(
            "Login",
            "text",
            SignupForm::LOGIN,
            isset($_POST[SignupForm::LOGIN]) ? $_POST[SignupForm::LOGIN] : null,
            $inputErrorMessages[SignupForm::LOGIN]
          ));

          // Firstname
          html::insert_code(HtmlWriterUtils::createLabelInput(
            "First name",
            "text",
            SignupForm::FIRSTNAME,
            isset($_POST[SignupForm::FIRSTNAME]) ? $_POST[SignupForm::FIRSTNAME] : null,
            $inputErrorMessages[SignupForm::FIRSTNAME]
          ));

          // Lastname
          html::insert_code(HtmlWriterUtils::createLabelInput(
            "Last name",
            "text",
            SignupForm::LASTNAME,
            isset($_POST[SignupForm::LASTNAME]) ? $_POST[SignupForm::LASTNAME] : null,
            $inputErrorMessages[SignupForm::LASTNAME]
          ));

          // Password
          html::insert_code(HtmlWriterUtils::createLabelInput(
            "Password",
            "password",
            SignupForm::PASSWORD,
            null,
            $inputErrorMessages[SignupForm::PASSWORD]
          ));

          // Confirm password
          html::insert_code(HtmlWriterUtils::createLabelInput(
            "Confirm password",
            "password",
            SignupForm::CONFIRM_PASSWORD,
            null,
            $inputErrorMessages[SignupForm::CONFIRM_PASSWORD]
          ));

          // Signup button
          html::nl();
          html::insert_code(HtmlWriterUtils::createSubmitBtn(SignupForm::BTN_SIGNUP, "Sign up"));
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