<!-- Check form -->
<?php
  require_once "classes/FormValidator.php";
  require_once "functions/functions.php";

  if (isset($_POST["btn-signin"]))
  {
    $_POST[FormValidator::LOGIN] = cleanInput($_POST[FormValidator::LOGIN]);
    $_POST[FormValidator::FIRSTNAME] = cleanInput($_POST[FormValidator::FIRSTNAME]);
    $_POST[FormValidator::LASTNAME] = cleanInput($_POST[FormValidator::LASTNAME]);
    $_POST[FormValidator::PASSWORD] = cleanInput($_POST[FormValidator::PASSWORD]);
    $_POST[FormValidator::CONFIRM_PASSWORD] = cleanInput($_POST[FormValidator::CONFIRM_PASSWORD]);

    $formValidator = new FormValidator($_POST[FormValidator::LOGIN], $_POST[FormValidator::FIRSTNAME], $_POST[FormValidator::LASTNAME],
                                       $_POST[FormValidator::PASSWORD], $_POST[FormValidator::CONFIRM_PASSWORD]);
    $formValidator->check();
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
                    <input class="form-control" name="login" type="text" value="<?php if (isset($_POST["login"])) echo $_POST["login"]; ?>">
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
                    <input class="form-control" name="firstname" type="text" value="<?php if (isset($_POST["firstname"])) echo $_POST["firstname"]; ?>">
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
                    <input class="form-control" name="lastname" type="text" value="<?php if (isset($_POST["lastname"])) echo $_POST["lastname"]; ?>">
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
                    <input class="form-control" name="password" type="password">
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
                    <input class="form-control" name="confirm-password" type="password">
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
                    <input value="S'inscrire" name="btn-signin" class="btn btn-primary" type="submit">
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