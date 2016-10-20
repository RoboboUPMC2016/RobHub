<!-- Check form -->
<?php
  session_start();
  if (isset($_SESSION["login"]))
  {
    header("Location: index.php");
    exit();
  }

  require_once "classes/SignupValidator.php";
  require_once "functions/functions.php";

  if (isset($_POST[SignupValidator::BTN_SIGNUP]))
  {
    $_POST[SignupValidator::LOGIN] = cleanInput($_POST[SignupValidator::LOGIN]);
    $_POST[SignupValidator::FIRSTNAME] = cleanInput($_POST[SignupValidator::FIRSTNAME]);
    $_POST[SignupValidator::LASTNAME] = cleanInput($_POST[SignupValidator::LASTNAME]);
    $_POST[SignupValidator::PASSWORD] = cleanInput($_POST[SignupValidator::PASSWORD]);
    $_POST[SignupValidator::CONFIRM_PASSWORD] = cleanInput($_POST[SignupValidator::CONFIRM_PASSWORD]);

    $SignupValidator = new SignupValidator($_POST[SignupValidator::LOGIN], $_POST[SignupValidator::FIRSTNAME], $_POST[SignupValidator::LASTNAME],
                                       $_POST[SignupValidator::PASSWORD], $_POST[SignupValidator::CONFIRM_PASSWORD]);
    // If form is valid
    if ($SignupValidator->check())
    {
      // Insert user in database
      $stmt = DB::prepare("INSERT INTO User (User_username, User_password, User_firstname, User_lastname) VALUES (?, ?, ?, ?)");
      if ($stmt->execute([$_POST[SignupValidator::LOGIN], sha1($_POST[SignupValidator::PASSWORD]), $_POST[SignupValidator::FIRSTNAME], $_POST[SignupValidator::LASTNAME]]))
      {
        session_start();
        $_SESSION["login"] = $_POST[SignupValidator::LOGIN];
        $_SESSION["firstname"] = $_POST[SignupValidator::FIRSTNAME];
        $_SESSION["lastname"] = $_POST[SignupValidator::LASTNAME];

        header("Location: index.php");
        exit();
      }
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
                    <input class="form-control" name="<?php echo SignupValidator::LOGIN; ?>" type="text" value="<?php if (isset($_POST[SignupValidator::LOGIN])) echo $_POST[SignupValidator::LOGIN]; ?>">
                    <h5 class="invalidInput">
                    <?php
                      if (isset($SignupValidator))
                      {
                        echo $SignupValidator->getErrorMessage(SignupValidator::LOGIN);
                      }
                    ?>
                    </h5>
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <h4>Prénom</h4>
                    <input class="form-control" name="<?php echo SignupValidator::FIRSTNAME; ?>" type="text" value="<?php if (isset($_POST[SignupValidator::FIRSTNAME])) echo $_POST[SignupValidator::FIRSTNAME]; ?>">
                    <h5 class="invalidInput">
                    <?php
                      if (isset($SignupValidator))
                      {
                        echo $SignupValidator->getErrorMessage(SignupValidator::FIRSTNAME);
                      }
                    ?>
                    </h5>
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <h4>Nom</h4>
                    <input class="form-control" name="<?php echo SignupValidator::LASTNAME; ?>" type="text" value="<?php if (isset($_POST[SignupValidator::LASTNAME])) echo $_POST[SignupValidator::LASTNAME]; ?>">
                    <h5 class="invalidInput">
                    <?php
                      if (isset($SignupValidator))
                      {
                        echo $SignupValidator->getErrorMessage(SignupValidator::LASTNAME);
                      }
                    ?>
                    </h5>
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <h4>Mot de passe</h4>
                    <input class="form-control" name="<?php echo SignupValidator::PASSWORD; ?>" type="password">
                    <h5 class="invalidInput">
                    <?php
                      if (isset($SignupValidator))
                      {
                        echo $SignupValidator->getErrorMessage(SignupValidator::PASSWORD);
                      }
                    ?>
                    </h5>
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <h4>Confirmation de mot de passe</h4>
                    <input class="form-control" name="<?php echo SignupValidator::CONFIRM_PASSWORD; ?>" type="password">
                    <h5 class="invalidInput">
                    <?php
                      if (isset($SignupValidator))
                      {
                        echo $SignupValidator->getErrorMessage(SignupValidator::CONFIRM_PASSWORD);
                      }
                    ?>
                    </h5>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <input value="S'inscrire" name="<?php echo SignupValidator::BTN_SIGNUP; ?>" class="btn btn-primary" type="submit">
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