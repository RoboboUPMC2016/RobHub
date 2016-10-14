<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Connexion</title>
    </head>
    
    <body>
	<div class="container-full">
      <div class="row"> 
        <div class="col-lg-12 text-center v-center"> 
          <h1>Bienvenue sur le reseau RobHub</h1>
          <p class="lead">Veuillez vous connecter pour accceder au site</p>
          <br>
          <form class="col-lg-12" action="signin.php" method="post" > 
            <div class="input-group">
              <input type="text" class="center-block form-control input-lg" title="Login" placeholder="Login">
 	      <input type="password" class="center-block form-control input-lg" title="Mot de passe" placeholder="Entrer votre login" name="pwd"><br>
              <input type="submit" class="center-block form-control input-sh" text="Connexion"/>
            </div>
          </form>
        </div>
        
      </div> <!-- /row -->
  
  	  <div class="row">
       
        <div class="col-lg-12 text-center v-center" style="font-size:39pt;">
          <a href="#"><i class="icon-google-plus"></i></a> <a href="#"><i class="icon-facebook"></i></a>  <a href="#"><i class="icon-twitter"></i></a> <a href="#"><i class="icon-github"></i></a> <a href="#"><i class="icon-pinterest"></i></a>
        </div>
      
      </div>
  
  	<br><br><br><br><br>

</div> <!-- /container full -->

<div class="container">
  
  	<hr>
  
  	<div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading"><h3>Hello.</h3></div>
            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate. 
            Quisque mauris augue, molestie tincidunt condimentum vitae, gravida a libero. Aenean sit amet felis 
            dolor, in sagittis nisi. Sed ac orci quis tortor imperdiet venenatis. Duis elementum auctor accumsan. 
            Aliquam in felis sit amet augue.
            </div>
          </div>
        </div>
      	<div class="col-md-4">
        	<div class="panel panel-default">
            <div class="panel-heading"><h3>Hello.</h3></div>
            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate. 
            Quisque mauris augue, molestie tincidunt condimentum vitae, gravida a libero. Aenean sit amet felis 
            dolor, in sagittis nisi. Sed ac orci quis tortor imperdiet venenatis. Duis elementum auctor accumsan. 
            Aliquam in felis sit amet augue.
            </div>
          </div>
        </div>
      	<div class="col-md-4">
        	<div class="panel panel-default">
            <div class="panel-heading"><h3>Hello.</h3></div>
            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate. 
            Quisque mauris augue, molestie tincidunt condimentum vitae, gravida a libero. Aenean sit amet felis 
            dolor, in sagittis nisi. Sed ac orci quis tortor imperdiet venenatis. Duis elementum auctor accumsan. 
            Aliquam in felis sit amet augue.
            </div>
          </div>
        </div>
    </div>
  
	<div class="row">
        <div class="col-lg-12">
        <br><br>
          <p class="pull-right"><a href="http://www.bootply.com">Template from Bootply</a> &nbsp; ©Copyright 2013 ACME<sup>TM</sup> Brand.</p>
        <br><br>
        </div>
    </div>
</div>


        <header>
          <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="signin.php">Connexion</a></li>
            <li><a href="signup.php">Inscription</a></li>
          </ul>
        </header>
        
        <form action="signin.php" method="post">
          Pseudo: <input type="text" name="nickname"><br>
          Mot de passe: <input type="text" name="password"><br>

          <input type="submit" value="Se connecter">
        </form>

    </body>
</html>
