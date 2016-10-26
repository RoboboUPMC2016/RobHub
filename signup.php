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

    $signupValidator = new SignupValidator($_POST[SignupValidator::LOGIN], $_POST[SignupValidator::FIRSTNAME], $_POST[SignupValidator::LASTNAME],
                                       $_POST[SignupValidator::PASSWORD], $_POST[SignupValidator::CONFIRM_PASSWORD]);
    // If form is valid
    if ($signupValidator->check())
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
    <div id="fspanco-page">
      <?php include "includes/header.php"; ?>

      <div id="fspanco-intro-section">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center fspanco-heading">
              <h2>Inscription</h2>
            </div>
          </div>

          <div class="row">
            <div class="col-md-push-1 col-sm-12 col-sm-push-0 col-xs-12 col-xs-push-0">
              <form method="post" class="row">
                <div class="col-md-11">
                  <div class="form-group">
                    <label for="<?php echo SignupValidator::LOGIN; ?>">Identifiant</label>
                    <input class="form-control" id="<?php echo SignupValidator::LOGIN; ?>" name="<?php echo SignupValidator::LOGIN; ?>" type="text" value="<?php if (isset($_POST[SignupValidator::LOGIN])) echo $_POST[SignupValidator::LOGIN]; ?>">
                    <span class="invalidInput">
                    <?php
                      if (isset($signupValidator))
                      {
                        echo $signupValidator->getErrorMessage(SignupValidator::LOGIN);
                      }
                    ?>
                    </span>
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <label for="<?php echo SignupValidator::FIRSTNAME; ?>" >Prénom</label>
                    <input class="form-control" id="<?php echo SignupValidator::FIRSTNAME; ?>" name="<?php echo SignupValidator::FIRSTNAME; ?>" type="text" value="<?php if (isset($_POST[SignupValidator::FIRSTNAME])) echo $_POST[SignupValidator::FIRSTNAME]; ?>">
                    <span class="invalidInput">
                    <?php
                      if (isset($signupValidator))
                      {
                        echo $signupValidator->getErrorMessage(SignupValidator::FIRSTNAME);
                      }
                    ?>
                    </span>
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <label for="<?php echo SignupValidator::LASTNAME; ?>">Nom</label>
                    <input class="form-control" id="<?php echo SignupValidator::LASTNAME; ?>" name="<?php echo SignupValidator::LASTNAME; ?>" type="text" value="<?php if (isset($_POST[SignupValidator::LASTNAME])) echo $_POST[SignupValidator::LASTNAME]; ?>">
                    <span class="invalidInput">
                    <?php
                      if (isset($signupValidator))
                      {
                        echo $signupValidator->getErrorMessage(SignupValidator::LASTNAME);
                      }
                    ?>
                    </span>
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <label for="<?php echo SignupValidator::PASSWORD; ?>">Mot de passe</label>
                    <input class="form-control" id="<?php echo SignupValidator::PASSWORD; ?>" name="<?php echo SignupValidator::PASSWORD; ?>" type="password">
                    <span class="invalidInput">
                    <?php
                      if (isset($signupValidator))
                      {
                        echo $signupValidator->getErrorMessage(SignupValidator::PASSWORD);
                      }
                    ?>
                    </span>
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <label for="<?php echo SignupValidator::CONFIRM_PASSWORD; ?>">Confirmation de mot de passe</label>
                    <input class="form-control" id="<?php echo SignupValidator::CONFIRM_PASSWORD; ?>" name="<?php echo SignupValidator::CONFIRM_PASSWORD; ?>" type="password">
                    <span class="invalidInput">
                    <?php
                      if (isset($signupValidator))
                      {
                        echo $signupValidator->getErrorMessage(SignupValidator::CONFIRM_PASSWORD);
                      }
                    ?>
                    </span>
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