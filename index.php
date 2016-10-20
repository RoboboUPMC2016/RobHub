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
                <a href="https://github.com/RoboboUPMC2016/RobApp"><img class="img-responsive" src="images/image_4.jpg" alt="Blog"></a>
                <div class="desc">
                  <h3><a>RobApp</a></h3>
                  <p> 
                  RobApp est l'application permettant de donner un comportement à votre robobo.
                  Avec RobApp vous donnez au robobo les comportements que vous créé avec RobDev.
                  Vous pouvez aussi télécharger les comportement partager sur RobHub directement
                  depuis votre smartphone.
                  </p>
                </div>
              </div>
            </div>

            <div class="col-md-4 text-center">
              <div class="blog-inner">
                <a href="https://github.com/RoboboUPMC2016/RobHub"><img class="img-responsive" src="images/image_5.jpg" alt="Blog"></a>
                <div class="desc">
                  <h3><a>RobHub</a></h3>
                  <p>
                  RobHub est le reseau social de votre robobo. Vous pouvez partager des comportements
                  créés avec le framework RobDev, mais aussi des vidéos et des photos.
                  </p>
                </div>
              </div>
            </div>

            <div class="col-md-4 text-center">
              <div class="blog-inner">
                <a href="https://github.com/RoboboUPMC2016/RobDev"><img class="img-responsive" src="images/image_6.jpg" alt="Blog"></a>
                <div class="desc">
                  <h3><a>RobDev</a></h3>
                  <p> 
                  RobDev est un framework pour créer les comportements de votre Robobo. Pour savoir comment
                  créer un comportement rendez vous sur le
                  <a href="https://github.com/RoboboUPMC2016/RobDev/wiki">Wiki du projet RobDev</a>.
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