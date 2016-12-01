<?php
session_start();
require_once __DIR__ . "/php/src/enum/PageTitle.php";

// Set title of the page
$PAGE_TITLE = PageTitle::HOME;

require_once __DIR__ . "/php/includes/start-html.php";

/****************************************
*  START main content
****************************************/
html::add_attribute("id", "fh5co-intro-section");
html::tag("div");
  html::add_attribute("class", "container");
  html::tag("div");

    // Welcome message
    html::add_attribute("class", "row");
    html::tag("div");
      html::add_attribute("class", "col-md-8 col-md-offset-2 text-center");
      html::tag("div");
          $welcomeMsg = "Bienvenue sur le réseau RobHub";

          // Add login in welcome message
          require_once __DIR__  . "/php/src/enum/SessionData.php";
          if (isset($_SESSION[SessionData::LOGIN]))
          {
            $welcomeMsg = $welcomeMsg . " " . $_SESSION[SessionData::LOGIN];
          }

          html::tag("h2", $welcomeMsg);
      html::close();  
    html::close();

    // Display all behaviors
    html::add_attribute("class", "row");
    html::tag("div");
      require_once __DIR__ . "/php/src/database/dao/BehaviorDao.php";
      $behaviors = BehaviorDao::getAll();
      foreach ($behaviors as $behavior)
      {
        html::add_attribute("class", "col-md-4 text-center");
        html::tag("div");
          html::add_attribute("class", "blog-inner");
          html::tag("div");
            // Image
            html::insert_code('<a href="behaviordetails.php?bid=' . $behavior->id . '"><img class="img-responsive" src="assets/images/image_4.jpg" alt="' . $behavior->label . '"></a>');

            // Label + desc
            html::add_attribute("class", "desc");
            html::tag("div");
              html::tag("h3", $behavior->label);
              html::tag("p", $behavior->description);
            html::close();
          html::close();
        html::close();
      }

    html::close();
  html::close();
  
  require_once __DIR__ . "/php/includes/footer.php";
html::close();
/****************************************
*  END main content
****************************************/

require_once __DIR__ . "/php/includes/end-html.php";
?>