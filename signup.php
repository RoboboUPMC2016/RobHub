
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Inscription</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- 
	//////////////////////////////////////////////////////

	FREE HTML5 TEMPLATE 
	DESIGNED & DEVELOPED by FreeHTML5.co
		
	Website: 		http://freehtml5.co/
	Email: 			info@freehtml5.co
	Twitter: 		http://twitter.com/fh5co
	Facebook: 		https://www.facebook.com/fh5co

	//////////////////////////////////////////////////////
	 -->

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700,900' rel='stylesheet' type='text/css'>

	<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700" rel="stylesheet">
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Simple Line Icons -->
	<link rel="stylesheet" href="css/simple-line-icons.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Theme style  -->
	<link rel="stylesheet" href="css/style.css">

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
	<body>
	
	
	<div id="fh5co-page">
	<header id="fh5co-header" role="banner">
		<div class="container">
			<div class="header-inner">
				<h1><img src="images/robhub.svg" alt="robhub logo"><a href="index.php">RobHub</a></h1>
				<nav role="navigation">
					<ul>
						<li><a href="index.php">Accueil</a></li>
						<li><a class="active" href="signup.php">Inscription</a></li>
						<li><a href="signin.php">Connexion</a></li>
					</ul>
				</nav>
			</div>
		</div>
	</header>
	<div id="fh5co-contact-section">
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
								<h4>Confirmation mot de passe</h4>
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
	
	
	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Google Map -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCefOgb1ZWqYtj7raVSmN4PL2WkTrc-KyA&sensor=false"></script>
	<script src="js/google_map.js"></script>
	<!-- MAIN JS -->
	<script src="js/main.js"></script>

	</body>
</html>

