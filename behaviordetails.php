<?php
/**
 * User: AmineCorchi
 * Date: 11/28/2016
 * Time: 2:29 AM
 */

session_start();

require_once __DIR__ . "/php/src/enum/PageTitle.php";

// Set title of the page
$PAGE_TITLE = PageTitle::BEHAVIOR_DETAILS;

require_once __DIR__ . "/php/includes/start-html.php";

/****************************************
*  START main content
****************************************/
html::add_attribute("id", "fh5co-intro-section");
html::tag("div");
    
    // Check is bid parameter has beend passed
    $bidIsEmpty = empty($_GET["bid"]);
    $behavior = null;
    if (!$bidIsEmpty)
    {
        require_once __DIR__ . "/php/src/util/StringUtils.php";
        // Clean input
        $_GET["bid"] = StringUtils::clean($_GET["bid"]);

        // Try to get it from BD
        require_once __DIR__ . "/php/src/database/dao/BehaviorDao.php";
        $behavior = BehaviorDao::getById($_GET["bid"]);
    }
  
    // Behavior message
    html::add_attribute("class", "row");
    html::tag("div");
      html::add_attribute("class", "col-md-8 col-md-offset-2 text-center");
      html::tag("div");
        // Id not set
        if ($bidIsEmpty)
        {
          html::tag("span", "L'identifiant du comportement n'a pas été spécifié.");
        }
        // Behavior not found
        else if ($behavior === null)
        {
          html::tag("span", "Le comportement n'existe pas.");
        }
        // Behavior found
        else
        {
          html::tag("h2", "Détails du comportement");
        }
      html::close();
    html::close();

    // Show behavior details if we found it
    if ($behavior !== null)
    {
        html::add_attribute("class", "row");
        html::tag("div");
          // Behavior infos
          html::add_attribute("class", "col-md-push-1 col-sm-9 col-sm-push-1 col-xs-12 col-xs-push-0");
          html::tag("div");
            // Label
            html::tag("h2", $behavior->label);

            // Creator + date
            html::insert_code("<h5><i class='fa fa-clock-o' aria-hidden='true'></i>&nbsp;Publié par Toto," . $behavior->timestamp . "</h5>");

            // Description
            html::add_attribute("class", "textJustify");
            html::tag("p", $behavior->description);
          html::close();

          // Tabs
          html::add_attribute("class", "col-md-push-1 col-sm-9 col-sm-push-1 col-xs-12 col-xs-push-0");
          html::tag("div");
            html::add_attribute("class", "nav nav-tabs");
            html::tag("ul");
              // Java
              html::add_attribute("class", "active");
              html::tag("li");
                html::add_attributes(["data-toggle" => "tab", "href" => "#java"]);
                html::tag("a", "Java");
              html::close();

              // Videos
              html::tag("li");
                html::add_attributes(["data-toggle" => "tab", "href" => "#videos"]);
                html::tag("a", "Vidéos");
              html::close();
            html::close();

            // Tabs content
            html::add_attribute("class", "tab-content");
            html::tag("div");
              // Java
              html::add_attributes(["id" => "java", "class" => "tab-pane fade in active"]);
              html::tag("div");
                require_once __DIR__ . "/php/src/util/BehaviorFileUtils.php";

                $strBid = strval($_GET["bid"]);

                // Show javasource code
                html::add_attribute("class", "prettyprint");
                html::tag("pre", BehaviorFileUtils::getJavaContent($strBid));

                // Download java file
                html::add_attributes(["class" => "btn btn-default", "href" => BehaviorFileUtils::getExternJavaPath($strBid)]);
                html::tag("a", "Télécharger .java");

                // Download dex file
                html::add_attributes(["class" => "btn btn-default", "href" => BehaviorFileUtils::getExternDexPath($strBid)]);
                html::tag("a", "Télécharger .dex");
              html::close();

              // Videos
              html::add_attributes(["id" => "videos", "class" => "tab-pane fade"]);
              html::tag("div");
                html::tag("p", "videos");
              html::close();
            html::close();

          html::close();
        html::close();
    }
  html::close();

  require_once __DIR__ . "/php/includes/footer.php";
html::close();
/****************************************
*  END main content
****************************************/

require_once __DIR__ . "/php/includes/end-html.php";
?>