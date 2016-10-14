<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Connexion</title>
    </head>
    
    <body>
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