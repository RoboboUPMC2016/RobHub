<?php
session_start();

require_once "php/src/enum/SessionData.php";

// Redirect to home page if the user is authenticated
if (!isset($_SESSION[SessionData::LOGIN]))
{
  require_once "php/src/util/RouteUtils.php";
  RouteUtils::goToHomePage();
}

require_once "php/src/form/AddBehaviorForm.php";
if (isset($_POST[AddBehaviorForm::BTN_ADD]))
{
  require_once "php/src/util/StringUtils.php";

  $_POST[AddBehaviorForm::LABEL] = StringUtils::clean($_POST[AddBehaviorForm::LABEL]);
  $_POST[AddBehaviorForm::DESC] = StringUtils::clean($_POST[AddBehaviorForm::DESC]);
  $addBehaviorForm = new AddBehaviorForm(
    $_SESSION[SessionData::LOGIN],
    $_POST[AddBehaviorForm::LABEL],
    $_POST[AddBehaviorForm::DESC],
    $_FILES[AddBehaviorForm::BEHAVIOR_FILE]
  );

  $fileUploadedSuccess = $addBehaviorForm->uploadFile();
}

require_once "php/src/enum/PageTitle.php";

// Set title of the page
$PAGE_TITLE = PageTitle::ADD_BEHAVIOR;

require_once("php/includes/start-html.php");

/****************************************
*  START main content
****************************************/
html::add_attribute("id", "fh5co-intro-section");
html::tag("div");
  html::add_attribute("class", "container");
  html::tag("div");

    // Add behavior message
    html::add_attribute("class", "row");
    html::tag("div");
      html::add_attribute("class", "col-md-8 col-md-offset-2 text-center");
      html::tag("div");
          html::tag("h2", "Ajouter un comportement");

          if (isset($fileUploadedSuccess))
          {
            if ($fileUploadedSuccess)
            {
              html::add_attribute("class", "successMsg");
              html::tag("span", "Le comportement a bien été mis en ligne.");
            }
            else
            {
              html::add_attribute("class", "errorMsg");
              html::tag("span", "Un problème inconnu est survenu.");
            }
          }
      html::close();  
    html::close();

    html::add_attribute("class", "row");
    html::tag("div");
      html::add_attribute("class", "col-md-push-1 col-sm-12 col-sm-push-0 col-xs-12 col-xs-push-0");
      html::tag("div");
        // Add behavior form
        html::add_attributes(["class" => "row", "method" => "post", "enctype" => "multipart/form-data"]);
        html::tag("form");
          // Create error messages for inputs
          $inputErrorMessages = [
            AddBehaviorForm::LABEL => NULL,
            AddBehaviorForm::DESC => NULL,
            AddBehaviorForm::BEHAVIOR_FILE => NULL
          ];

          if (isset($addBehaviorForm))
          {
            // Get error messages
            foreach ($inputErrorMessages as $key => $value)
            {
              $inputErrorMessages[$key] = $addBehaviorForm->getErrorMessage($key);
            }
          }

          require_once "php/src/util/HtmlWritterUtils.php";

          // Label
          html::insert_code(HtmlWritterUtils::createLabelInput(
            "Label",
            "text",
            AddBehaviorForm::LABEL,
            isset($_POST[AddBehaviorForm::LABEL]) ? $_POST[AddBehaviorForm::LABEL] : NULL,
            $inputErrorMessages[AddBehaviorForm::LABEL]
          ));

          // Description
          html::insert_code(HtmlWritterUtils::createLabelTextArea(
            "Description",
            AddBehaviorForm::DESC,
            isset($_POST[AddBehaviorForm::DESC]) ? $_POST[AddBehaviorForm::DESC] : NULL,
            $inputErrorMessages[AddBehaviorForm::DESC]
          ));

          // Add file
          $ACCEPTED_FILES = "." . AddBehaviorForm::ACCEPTED_FILES;
          html::insert_code(HtmlWritterUtils::createLabelInputFile(
            "Fichier du comportement (" . $ACCEPTED_FILES . ")",
            $ACCEPTED_FILES,
            AddBehaviorForm::BEHAVIOR_FILE,
            isset($_POST[AddBehaviorForm::BEHAVIOR_FILE]) ? $_POST[AddBehaviorForm::BEHAVIOR_FILE] : NULL,
            $inputErrorMessages[AddBehaviorForm::BEHAVIOR_FILE]
          ));

          // Add behavior button
          html::nl();
          html::insert_code(HtmlWritterUtils::createSubmitBtn(AddBehaviorForm::BTN_ADD, "Ajouter"));
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