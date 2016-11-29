<?php
session_start();

require_once __DIR__ . "/php/src/enum/SessionData.php";

// Redirect to home page if the user is authenticated
if (!isset($_SESSION[SessionData::LOGIN]))
{
  require_once __DIR__ . "/php/src/util/RouteUtils.php";
  RouteUtils::goToHomePage();
}

require_once __DIR__ . "/php/src/form/AddBehaviorForm.php";

// Button add pressed
if (isset($_POST[AddBehaviorForm::BTN_ADD]))
{
  require_once __DIR__ . "/php/src/util/StringUtils.php";

  // Clean input
  $_POST[AddBehaviorForm::LABEL] = StringUtils::clean($_POST[AddBehaviorForm::LABEL]);
  $_POST[AddBehaviorForm::DESC] = StringUtils::clean($_POST[AddBehaviorForm::DESC]);

  // Create form checker
  $addBehaviorForm = new AddBehaviorForm(
    $_POST[AddBehaviorForm::LABEL],
    $_POST[AddBehaviorForm::DESC],
    $_FILES[AddBehaviorForm::BEHAVIOR_FILE]
  );

  // Get dex content
  $dexContent = $addBehaviorForm->performValidation();
  $fileUploadedSuccess = false;
  // Java file uploaded is ok : dex content is not null
  if ($dexContent !== null)
  {
    require_once __DIR__ . "/php/src/database/dao/BehaviorDao.php";
    // Insert new Behavior in DB
    $behaviorId = strval(BehaviorDao::add($_POST[AddBehaviorForm::LABEL], $_POST[AddBehaviorForm::DESC], $_SESSION[SessionData::LOGIN]));

    // Insert has succeeded
    if ($behaviorId !== -1)
    {
      require_once __DIR__ . "/php/src/util/BehaviorFileWriter.php";

      // Create java file
      BehaviorFileWriter::createPostFile($behaviorId, $_FILES[AddBehaviorForm::BEHAVIOR_FILE]);

      // Create dex file
      BehaviorFileWriter::createDexFile(
        $behaviorId,
        basename($_FILES[AddBehaviorForm::BEHAVIOR_FILE]["name"], "." . AddBehaviorForm::ACCEPTED_FILES),
        $dexContent
      );

      $fileUploadedSuccess = true;
    }
  }
}

require_once __DIR__ . "/php/src/enum/PageTitle.php";

// Set title of the page
$PAGE_TITLE = PageTitle::ADD_BEHAVIOR;

require_once __DIR__ . "/php/includes/start-html.php";

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
              // Upload has succeeded
              if ($fileUploadedSuccess)
              {
                html::add_attribute("class", "successMsg");
                html::tag("span", "Le comportement a bien été mis en ligne.");
              }
              // Upload has failed
              else
              {
                html::add_attribute("class", "errorMsg");
                html::tag("span", "Le comportement n'a pas pu être mis en ligne.");
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
            AddBehaviorForm::LABEL => null,
            AddBehaviorForm::DESC => null,
            AddBehaviorForm::BEHAVIOR_FILE => null
          ];

          if (isset($addBehaviorForm))
          {
            // Get error messages
            foreach ($inputErrorMessages as $key => $value)
            {
              $inputErrorMessages[$key] = $addBehaviorForm->getErrorMessage($key);
            }
          }

          require_once __DIR__ . "/php/src/util/HtmlWriterUtils.php";

          // Label
          html::insert_code(HtmlWriterUtils::createLabelInput(
            "Label",
            "text",
            AddBehaviorForm::LABEL,
            isset($_POST[AddBehaviorForm::LABEL]) ? $_POST[AddBehaviorForm::LABEL] : null,
            $inputErrorMessages[AddBehaviorForm::LABEL]
          ));

          // Description
          html::insert_code(HtmlWriterUtils::createLabelTextArea(
            "Description",
            AddBehaviorForm::DESC,
            isset($_POST[AddBehaviorForm::DESC]) ? $_POST[AddBehaviorForm::DESC] : null,
            $inputErrorMessages[AddBehaviorForm::DESC]
          ));

          // Add file
          $ACCEPTED_FILES = "." . AddBehaviorForm::ACCEPTED_FILES;
          html::insert_code(HtmlWriterUtils::createLabelInputFile(
            "Fichier du comportement (" . $ACCEPTED_FILES . ")",
            $ACCEPTED_FILES,
            AddBehaviorForm::BEHAVIOR_FILE,
            isset($_POST[AddBehaviorForm::BEHAVIOR_FILE]) ? $_POST[AddBehaviorForm::BEHAVIOR_FILE] : null,
            $inputErrorMessages[AddBehaviorForm::BEHAVIOR_FILE]
          ));

          // Add behavior button
          html::nl();
          html::insert_code(HtmlWriterUtils::createSubmitBtn(AddBehaviorForm::BTN_ADD, "Ajouter"));
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