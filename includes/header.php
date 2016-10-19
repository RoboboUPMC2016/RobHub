<header id="fh5co-header" role="banner">
  <div class="container">
    <div class="header-inner">
      <h1><img src="images/robhub.svg" alt="robhub logo"><a href="index.php">RobHub</a></h1>
        <nav role="navigation">
          <ul>
            <li><a <?php if ($title === $TITLE_HOME) { ?> class="active" <?php } ?> href="index.php"><?php echo $TITLE_HOME; ?></a></li>
            <li><a <?php if ($title === $TITLE_SIGNUP) { ?> class="active" <?php } ?> href="signup.php"><?php echo $TITLE_SIGNUP; ?></a></li>
            <li><a <?php if ($title === $TITLE_SIGNIN) { ?> class="active" <?php } ?> href="signin.php"><?php echo $TITLE_SIGNIN; ?></a></li>
          </ul>
        </nav>
    </div>
  </div>
</header>