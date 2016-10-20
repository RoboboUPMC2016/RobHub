<header id="fh5co-header" role="banner">
  <div class="container">
    <div class="header-inner">
      <h1><img src="images/robhub.svg" id="logo-robhub" alt="robhub logo"><a href="index.php">RobHub</a></h1>
        <nav role="navigation">
          <ul>
          <?php
            echo '<li><a ' . ($title === $TITLE_HOME ? ' class="active" ' : ' ') . ' href="index.php">' . $TITLE_HOME . '</a></li>';
            if (!isset($_SESSION["login"]))
            {
              echo '<li><a ' . ($title === $TITLE_SIGNUP ? ' class="active" ' : ' ') . ' href="signup.php">' . $TITLE_SIGNUP . '</a></li>';
              echo '<li><a ' . ($title === $TITLE_SIGNIN ? ' class="active" ' : ' ') . ' href="signin.php">' . $TITLE_SIGNIN . '</a></li>';
            }
            else
            {
              echo '<li><a href="logout.php">' . $TITLE_LOGOUT . '</a></li>';
            }
          ?>
          </ul>
        </nav>
    </div>
  </div>
</header>