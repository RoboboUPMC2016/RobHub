<?php
/**
 * User: AmineCorchi
 * Date: 11/28/2016
 * Time: 2:29 AM
 */

session_start();

require_once __DIR__ . "/php/src/form/UploadVideoForm.php";
// Button add pressed
if (isset($_POST[UploadVideoForm::BTN_ADD]))
{
  require_once __DIR__ . "/php/src/util/StringUtils.php";

  // Create Upload video form
  $behaviorId = intval(StringUtils::clean($_GET["bid"]));
  $uploadVideoForm = new UploadVideoForm($behaviorId, $_FILES[UploadVideoForm::VIDEO_FILE]);

  // Check validation
  if ($uploadSuccess = $uploadVideoForm->performValidation())
  {
    require_once __DIR__ . "/php/src/util/BehaviorFileUtils.php";
    require_once __DIR__ . "/php/src/enum/SessionData.php";

    // Create video file
    BehaviorFileUtils::createVideoFile($behaviorId, $_SESSION[SessionData::LOGIN], $_FILES[UploadVideoForm::VIDEO_FILE]);
  }
}

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
            html::insert_code("<h5><i class='fa fa-clock-o' aria-hidden='true'></i>&nbsp;Publié par " . $behavior->username .", " . $behavior->timestamp . "</h5>");

            // Description
            html::add_attribute("class", "textJustify");
            html::tag("p", $behavior->description);

            // My rating
            html::tag("label", "My rating");
            html::add_attributes(["id" => "input-my-rating"]);
            html::single_tag("input");

            html::br();

            // Rating
            html::tag("label", "Rating");
            html::add_attributes(["id" => "input-rating"]);
            html::single_tag("input");
          html::close();

          // Tabs
          html::add_attribute("class", "col-md-push-1 col-sm-9 col-sm-push-1 col-xs-12 col-xs-push-0");
          html::tag("div");
            html::add_attribute("class", "nav nav-tabs");
            html::tag("ul");
              // Java
              if (!isset($_POST[UploadVideoForm::BTN_ADD]))
              {
                html::add_attribute("class", "active");
              }
              html::tag("li");
                html::add_attributes(["data-toggle" => "tab", "href" => "#java"]);
                html::tag("a", "Java");
              html::close();

              // Videos
              if (isset($_POST[UploadVideoForm::BTN_ADD]))
              {
                html::add_attribute("class", "active");
              }
              html::tag("li");
                html::add_attributes(["data-toggle" => "tab", "href" => "#videos"]);
                html::tag("a", "Vidéos");
              html::close();
            html::close();

            // Tabs content
            html::add_attribute("class", "tab-content");
            html::tag("div");
              // Java
              // Button upload pressed
              if (isset($_POST[UploadVideoForm::BTN_ADD]))
              {
                html::add_attributes(["id" => "java", "class" => "tab-pane fade"]);
              }
              else
              {
                html::add_attributes(["id" => "java", "class" => "tab-pane fade in active"]);
              }
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
              // Button upload pressed
              if (isset($_POST[UploadVideoForm::BTN_ADD]))
              {
                html::add_attributes(["id" => "videos", "class" => "tab-pane fade in active"]);
              }
              else
              {
                html::add_attributes(["id" => "videos", "class" => "tab-pane fade"]);
              }
              html::tag("div");
                require_once __DIR__ . "/php/src/util/BehaviorFileUtils.php";

                $videos = BehaviorFileUtils::getVideosURL($strBid);
                // Show all videos
                if (!empty($videos))
                {
                  // Create video tags
                  $i = 1;
                  foreach ($videos as $video)
                  {
                    html::add_attributes(["id" => "video" . strval($i++), "class" => "hidden"]);
                    html::tag("div");
                      html::add_attributes(["class" => "lg-video-object lg-html5", "preload" => "metadata", "controls" => ""]);
                      html::tag("video");
                        html::add_attributes(["src" => $video, "type" => "video/mp4"]);
                        html::single_tag("source");

                        html::insert_code("Your browser does not support the video tag.");
                      html::close();
                    html::close();
                  }

                  html::br();
                  // Create gallery
                  html::add_attribute("id", "gallery-videos");
                  html::tag("div");
                    $nbVideos = count($videos);
                    for ($i = 1; $i <= $nbVideos; ++$i)
                    {
                      $strI = strval($i);
                      html::add_attributes(["data-sub-html" => "Video " . $strI, "data-html" => "#video" . $strI]);
                      html::tag("span");
                        html::add_attributes(["src" => "assets/images/default-video-thumbnail.jpg", "width" => "150px", "height" => "75px", "alt" => "Thumbnail video"]);
                        html::single_tag("img");
                      html::close();
                    }
                  html::close();
                }
                // No video uploaded
                else
                {
                  html::tag("p", "Aucune vidéo n'a été mise en ligne.");
                }

                require_once __DIR__ . "/php/src/enum/SessionData.php";
                // Only show upload video if the user is authenticated
                if (isset($_SESSION[SessionData::LOGIN]))
                {
                  // Form
                  html::add_attributes(["class" => "row", "method" => "post", "enctype" => "multipart/form-data"]);
                  html::tag("form");
                    require_once __DIR__ . "/php/src/util/HtmlWriterUtils.php";

                    // Create error messages for inputs
                    $inputErrorMessages = [
                        UploadVideoForm::VIDEO_FILE => null,
                        UploadVideoForm::BEHAVIOR_ID => null
                    ];

                    if (isset($uploadVideoForm))
                    {
                      // Get error messages
                      foreach ($inputErrorMessages as $key => $value)
                      {
                        $inputErrorMessages[$key] = $uploadVideoForm->getErrorMessage($key);
                      }
                    }

                    if ($inputErrorMessages[UploadVideoForm::BEHAVIOR_ID])
                    {
                      html::add_attribute("class", "errorMsg");
                      html::tag("span", $inputErrorMessages[UploadVideoForm::BEHAVIOR_ID]);
                    }

                    // Upload success
                    if (isset($uploadSuccess) && $uploadSuccess)
                    {
                      html::add_attribute("class", "successMsg");
                      html::tag("span", "La vidéo a bien été mise en ligne.");
                    }

                    // Add video
                    $ACCEPTED_FILES = "." . UploadVideoForm::ACCEPTED_FILES;
                    html::insert_code(HtmlWriterUtils::createLabelInputFile(
                      "Fichier vidéo (" . $ACCEPTED_FILES . ")",
                      $ACCEPTED_FILES,
                      UploadVideoForm::VIDEO_FILE,
                      null,
                      $inputErrorMessages[UploadVideoForm::VIDEO_FILE]
                    ));

                    // Add video button
                    html::nl();
                    html::insert_code(HtmlWriterUtils::createSubmitBtn(UploadVideoForm::BTN_ADD, "Ajouter"));
                  html::close();
                }
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