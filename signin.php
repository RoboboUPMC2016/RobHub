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
            </div>
          </div>
        
          <div class="row">
            <div class="col-md-push-1 col-sm-12 col-sm-push-0 col-xs-12 col-xs-push-0">
              <form method="post" class="row">
                <div class="col-md-11">
                  <div class="form-group">
                    <input class="form-control" name="login" placeholder="Identifiant" type="text">
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <input class="form-control" name="password" placeholder="Mot de passe" type="password">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <input value="Se connecter" class="btn btn-primary" type="submit">
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