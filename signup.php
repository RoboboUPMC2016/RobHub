<!DOCTYPE html>
  <?php
    include "includes/global.php";
    $title = $TITLE_SIGNUP;
    include "includes/html_head.php";
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
                    <input class="form-control" name="login" type="text">
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <h4>Prénom</h4>
                    <input class="form-control" name="firstname" type="text">
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <h4>Nom</h4>
                    <input class="form-control" name="lastname" type="text">
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <h4>Mot de passe</h4>
                    <input class="form-control" name="password" type="password">
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <h4>Confirmation de mot de passe</h4>
                    <input class="form-control" name="confirm-password" type="password">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <input value="S'inscrire" class="btn btn-primary" type="submit">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      
      <?php include "includes/footer.php" ?>
    </div>
    
    <?php include "includes/scripts_js.php"; ?>
  </body>
</html>