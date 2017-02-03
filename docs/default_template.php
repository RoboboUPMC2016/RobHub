<?php
session_start();
require_once __DIR__ . "/php/src/enum/PageTitle.php";

// Set title of the page
$PAGE_TITLE = //PageTitle::TITLE_XXX; where TITLE_XXX = the title of the page

require_once __DIR__ . "/php/includes/start-html.php";

/****************************************
*  START main content
****************************************/
html::add_attribute("id", "fh5co-intro-section");
html::tag("div");
  // INSERT WHAT YOU WANT HERE
  
  require_once __DIR__ . "/php/includes/footer.php";
html::close();
/****************************************
*  END main content
****************************************/

require_once __DIR__ . "/php/includes/end-html.php";
?>