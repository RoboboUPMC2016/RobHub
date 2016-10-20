<!-- Check form -->
<?php
  require_once "classes/FormValidator.php";
  require_once "functions/functions.php";

  if (isset($_POST[FormValidator::BTN_SIGNUP]))
  {
    $_POST[FormValidator::LOGIN] = cleanInput($_POST[FormValidator::LOGIN]);
    $_POST[FormValidator::FIRSTNAME] = cleanInput($_POST[FormValidator::FIRSTNAME]);
    $_POST[FormValidator::LASTNAME] = cleanInput($_POST[FormValidator::LASTNAME]);
    $_POST[FormValidator::PASSWORD] = cleanInput($_POST[FormValidator::PASSWORD]);
    $_POST[FormValidator::CONFIRM_PASSWORD] = cleanInput($_POST[FormValidator::CONFIRM_PASSWORD]);

    $formValidator = new FormValidator($_POST[FormValidator::LOGIN], $_POST[FormValidator::FIRSTNAME], $_POST[FormValidator::LASTNAME],
                                       $_POST[FormValidator::PASSWORD], $_POST[FormValidator::CONFIRM_PASSWORD]);
    // If form is valid
    if ($formValidator->check())
    {
      // Insert user in database
      $stmt = DB::prepare("INSERT INTO User (User_username, User_password, User_firstname, User_lastname) VALUES (?, ?, ?, ?)");
      $stmt->execute([$_POST[FormValidator::LOGIN], sha1($_POST[FormValidator::PASSWORD]), $_POST[FormValidator::FIRSTNAME], $_POST[FormValidator::LASTNAME]]);
    }
  }
?>
<!DOCTYPE html>
  <?php
    require_once "includes/global.php";
    $title = $TITLE_SIGNUP;
    require_once "includes/html_head.php";

  ?>
  <body>
    <div id="fh5co-page">
      <?php include "includes/header.php"; ?>

      <div id="fh5co-intro-section">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center fh5co-heading">
              <h2>Inscription</h2>
            </div>
          </div>

          <div class="row">
            <div class="col-md-push-1 col-sm-12 col-sm-push-0 col-xs-12 col-xs-push-0">
              <form method="post" class="row">
                <div class="col-md-11">
                  <div class="form-group">
                    <h4>Identifiant</h4>
                    <input class="form-control" name="<?php echo FormValidator::LOGIN; ?>" type="text" value="<?php if (isset($_POST[FormValidator::LOGIN])) echo $_POST[FormValidator::LOGIN]; ?>">
                    <h5 class="invalidInput">
                    <?php
                      if (isset($formValidator))
                      {
                        echo $formValidator->getErrorMessage(FormValidator::LOGIN);
                      }
                    ?>
                    </h5>
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <h4>Prénom</h4>
                    <input class="form-control" name="<?php echo FormValidator::FIRSTNAME; ?>" type="text" value="<?php if (isset($_POST[FormValidator::FIRSTNAME])) echo $_POST[FormValidator::FIRSTNAME]; ?>">
                    <h5 class="invalidInput">
                    <?php
                      if (isset($formValidator))
                      {
                        echo $formValidator->getErrorMessage(FormValidator::FIRSTNAME);
                      }
                    ?>
                    </h5>
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <h4>Nom</h4>
                    <input class="form-control" name="<?php echo FormValidator::LASTNAME; ?>" type="text" value="<?php if (isset($_POST[FormValidator::LASTNAME])) echo $_POST[FormValidator::LASTNAME]; ?>">
                    <h5 class="invalidInput">
                    <?php
                      if (isset($formValidator))
                      {
                        echo $formValidator->getErrorMessage(FormValidator::LASTNAME);
                      }
                    ?>
                    </h5>
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <h4>Mot de passe</h4>
                    <input class="form-control" name="<?php echo FormValidator::PASSWORD; ?>" type="password">
                    <h5 class="invalidInput">
                    <?php
                      if (isset($formValidator))
                      {
                        echo $formValidator->getErrorMessage(FormValidator::PASSWORD);
                      }
                    ?>
                    </h5>
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <h4>Confirmation de mot de passe</h4>
                    <input class="form-control" name="<?php echo FormValidator::CONFIRM_PASSWORD; ?>" type="password">
                    <h5 class="invalidInput">
                    <?php
                      if (isset($formValidator))
                      {
                        echo $formValidator->getErrorMessage(FormValidator::CONFIRM_PASSWORD);
                      }
                    ?>
                    </h5>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <input value="S'inscrire" name="<?php echo FormValidator::BTN_SIGNUP; ?>" class="btn btn-primary" type="submit">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      
      <?php require_once "includes/footer.php" ?>
    </div>
    
    <?php require_once "includes/scripts_js.php"; ?>
  </body>
</html>