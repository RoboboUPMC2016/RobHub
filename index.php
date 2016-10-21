<?php
  session_start();
?>
<!DOCTYPE html>
  <?php 
    require_once "includes/global.php";
    $title = $TITLE_HOME;
    require_once "includes/html_head.php";
  ?>

  <body> 
    <div id="fh5co-page">
      <?php require_once "includes/header.php"; ?>

      <div id="fh5co-intro-section">
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
              <h2>Bienvenue sur le réseau RobHub <?php if (isset($_SESSION["firstname"])) { echo $_SESSION["firstname"]; } ?></h2>
            </div>
          </div>
            
          <div class="row">
            <div class="col-md-4 text-center">
              <div class="blog-inner">
                <a href="#"><img class="img-responsive" src="images/image_4.jpg" alt="Blog"></a>
                <div class="desc">
                  <h3><a>Danser</a></h3>
                  <p> 
                  Le robot danse.
                  </p>
                </div>
              </div>
            </div>

            <div class="col-md-4 text-center">
              <div class="blog-inner">
                <a href="#"><img class="img-responsive" src="images/image_5.jpg" alt="Blog"></a>
                <div class="desc">
                  <h3><a>Parler</a></h3>
                  <p>
                  Le robot parle.
                  </p>
                </div>
              </div>
            </div>

            <div class="col-md-4 text-center">
              <div class="blog-inner">
                <a href="#"><img class="img-responsive" src="images/image_6.jpg" alt="Blog"></a>
                <div class="desc">
                  <h3><a>Rond</a></h3>
                  <p> 
                  Le robot tourne en rond.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <?php require_once "includes/footer.php" ?>
    </div>
  
  
    <?php require_once "includes/scripts_js.php"; ?>
  </body>
</html>