<?php
  try
  {
    $str = file_get_contents("config-database.json");
    $dbInfo = json_decode($str, true);


    $db = new PDO("mysql:host=" . $dbInfo["host"] . ";dbname=" . $dbInfo["dbname"], $dbInfo["user"], $dbInfo["password"]);
    $resultats=$db->query("SELECT * FROM User");
    $resultats->setFetchMode(PDO::FETCH_OBJ);
    while( $resultat = $resultats->fetch() )
    {
            echo 'Utilisateur : '.$resultat->User_username.'<br>';
    }
    $resultats->closeCursor();
  }
  catch (Exception $e)
  {
    die("Erreur : " . $e->getMessage());
  }
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title>Accueil</title>

    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/jquery-3.1.1.js"></script>
  </head>
  
  <body>
    <div class="container-full">
      <div class="row">
        <div class="col-lg-12 text-center v-center">
          <h1>Bienvenue sur le réseau RobHub</h1>
          <p class="lead">Veuillez vous connecter pour accceder au site</p><br>

          <form class="col-lg-12" action="index.php" method="post">
            <div class="input-group-lg col-sm-offset-4 col-sm-4">
              <input type="text" class="center-block form-control input-lg" placeholder="Identifiant"><br>
              <input type="password" class="center-block form-control input-lg" placeholder="Mot de passe"><br>

              <span class="input-group-btn">
                <input class="btn btn-lg btn-primary" type="submit" value="Connexion">
              </span>
              <hr>
              <a href="signup.php"><b>Créer un compte</b></a>
            </div>
            
            <div class="col-lg-12" style="margin: auto; padding: auto;">
              <img src="assets/img/robhub_.svg" alt="robhub logo">
            </div>
          </form>
        </div>
      </div>
      <br>

    </div>

    <!-- /container full -->
    <div class="container">
      <hr>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="center-title">
                <a href="https://github.com/RoboboUPMC2016/RobApp">RobApp</a>
              </h3>
            </div>

            <div class="panel-body justify-text">
              RobApp est l'application permettant de donner un comportement à votre robobo.
              Avec RobApp vous donnez au robobo les comportements que vous créé avec RobDev.
              Vous pouvez aussi télécharger les comportement partager sur RobHub directement
              depuis votre smartphone.
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="center-title">
                <a href="https://github.com/RoboboUPMC2016/RobHub">RobHub</a>
              </h3>
            </div>
            <div class="panel-body justify-text">
              RobHub est le reseau social de votre robobo. Vous pouvez partager des comportements
              créés avec le framework RobDev, mais aussi des vidéos et des photos.
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="center-title">
                <a href="https://github.com/RoboboUPMC2016/RobDev">RobDev</a>
              </h3>
            </div>
            <div class="panel-body justify-text">
              RobDev est un framework pour créer les comportements de votre Robobo. Pour savoir comment
              créer un comportement rendez vous sur le
              <a href="https://github.com/RoboboUPMC2016/RobDev/wiki">Wiki du projet RobDev</a>.
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>