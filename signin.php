<!-- Check connection -->
<?php
  session_start();
  if (isset($_SESSION["login"]))
  {
    header("Location: index.php");
    exit();
  }

  require_once "classes/SigninValidator.php";
  require_once "functions/functions.php";

  if (isset($_POST[SigninValidator::BTN_SIGNIN]))
  {
    $_POST[SigninValidator::LOGIN] = cleanInput($_POST[SigninValidator::LOGIN]);
    $_POST[SigninValidator::PASSWORD] = cleanInput($_POST[SigninValidator::PASSWORD]);

    $signinValidator = new SigninValidator($_POST[SigninValidator::LOGIN], $_POST[SigninValidator::PASSWORD]);

    // If user found
    if ($result = $signinValidator->check())
    {
      session_start();
      $_SESSION["login"] = $result["User_username"];
      $_SESSION["firstname"] = $result["User_firstname"];
      $_SESSION["lastname"] = $result["User_lastname"];

      header("Location: index.php");
      exit();
    }
  }
?>
<!DOCTYPE html>
  <?php
    require_once "includes/global.php";
    $title = $TITLE_SIGNIN;
    require_once "includes/html_head.php";
  ?>

  <body>
    <div id="fh5co-page">
      <?php require_once "includes/header.php"; ?>

      <div id="fh5co-intro-section">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center fh5co-heading">
              <h2>Connexion</h2>
              <h5 class="invalidInput"><?php if (isset($result) && !$result) { echo "Identifiant ou mot de passe incorect."; } ?></h5>
            </div>
          </div>
        
          <div class="row">
            <div class="col-md-push-1 col-sm-12 col-sm-push-0 col-xs-12 col-xs-push-0">
              <form method="post" class="row">
                <div class="col-md-11">
                  <div class="form-group">
                    <input class="form-control" placeholder="Identifiant" name="<?php echo SigninValidator::LOGIN; ?>" type="text" value="<?php if (isset($_POST[SigninValidator::LOGIN])) echo $_POST[SigninValidator::LOGIN]; ?>">
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <input class="form-control" placeholder="Mot de passe" name="<?php echo SigninValidator::PASSWORD; ?>" type="password">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <input value="S'inscrire" name="<?php echo SigninValidator::BTN_SIGNIN; ?>" class="btn btn-primary" type="submit">
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