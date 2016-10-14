<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Inscription</title>
    </head>
    
    <body>
        <header>
          <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="signin.php">Connexion</a></li>
            <li><a href="signup.php">Inscription</a></li>
          </ul>
        </header>
        
        <form action="signup.php" method="post">
          Pseudo: <input type="text" name="nickname"><br>
          Prénom: <input type="text" name="firstname"><br>
          Nom: <input type="text" name="lastname"><br>
          Mot de passe: <input type="password" name="password"><br>
          Confirmation du mot de passe: <input type="password" name="confirm_password"><br>

          <input type="submit" value="S'inscrire">
        </form>

    </body>
</html>