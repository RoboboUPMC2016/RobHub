<?php
session_start();
require_once "php/classes/PageTitle.php";

// Set title of the page
$PAGE_TITLE = PageTitle::HOME;

require_once("php/includes/start-html.php");

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
          require_once "php/classes/SessionData.php";
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

      // HERE WE SHOULD GET DATA FROM DATABASE
      $behaviorsLabels = ["Danser", "Parler", "Tourner"];
      $behaviorsDescs = ["Le robot danse", "Le robot parle", "Le robot tourne"];
      $behaviorsLogos = ["assets/images/image_4.jpg", "assets/images/image_5.jpg", "assets/images/image_6.jpg"];

      for ($i = 0; $i < 3; ++$i)
      {
        html::add_attribute("class", "col-md-4 text-center");
        html::tag("div");
          html::add_attribute("class", "blog-inner");
          html::tag("div");
            // Image
            html::insert_code('<a href="#"><img class="img-responsive" src="' . $behaviorsLogos[$i] . '" alt="' . $behaviorsLabels[$i] . '"></a>');

            // Label + desc
            html::add_attribute("class", "desc");
            html::tag("div");
              html::tag("h3", $behaviorsLabels[$i]);
              html::tag("p", $behaviorsDescs[$i]);
            html::close();
          html::close();
        html::close();
      }

    html::close();
  html::close();
  
  require_once "php/includes/footer.php";
html::close();
/****************************************
*  END main content
****************************************/

require_once("php/includes/end-html.php");
?>