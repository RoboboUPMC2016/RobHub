<?php
  session_start();
/*
  if (!isset($_SESSION["login"]))
  {
    header("Location: index.php");
    exit();
  }*/

  require_once "classes/AddBehaviorValidator.php";
  require_once "functions/functions.php";

  if (isset($_POST[AddBehaviorValidator::BTN_ADD]))
  {
    $_POST[AddBehaviorValidator::LABEL] = cleanInput($_POST[AddBehaviorValidator::LABEL]);
    $_POST[AddBehaviorValidator::DESC] = cleanInput($_POST[AddBehaviorValidator::DESC]);
    $addBehaviorValidator = new AddBehaviorValidator($_POST[AddBehaviorValidator::LABEL], $_POST[AddBehaviorValidator::DESC],
                                                     $_FILES[AddBehaviorValidator::BEHAVIOR_FILE], "behaviors/");
    $fileUploaded = $addBehaviorValidator->uploadFile();
  }

?>
<!DOCTYPE html>
  <?php 
    require_once "includes/global.php";
    $title = $TITLE_ADD_BEHAVIOR;
    require_once "includes/html_head.php";
  ?>

  <body> 
    <div id="fspanco-page">
      <?php require_once "includes/header.php"; ?>

      <div id="fspanco-intro-section">
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
              <h2>Ajouter un comportement</h2>
            </div>
          </div>

          <div class="row">
            <div class="col-md-push-1 col-sm-12 col-sm-push-0 col-xs-12 col-xs-push-0">
              <form method="post" enctype="multipart/form-data" class="row">
                <div class="col-md-11">
                  <div class="form-group">
                    <label for="<?php echo AddBehaviorValidator::LABEL; ?>">Label</label>
                    <input class="form-control" id="<?php echo AddBehaviorValidator::LABEL; ?>" name="<?php echo AddBehaviorValidator::LABEL; ?>" type="text"
                           value="<?php
                           if (isset($_POST[AddBehaviorValidator::LABEL]) && !$fileUploaded)
                           {
                             echo $_POST[AddBehaviorValidator::LABEL];
                           }
                    ?>">
                    <span class="invalidInput">
                    <?php
                      if (isset($addBehaviorValidator))
                      {
                        echo $addBehaviorValidator->getErrorMessage(AddBehaviorValidator::LABEL);
                      }
                    ?>
                    </span>
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <label for="<?php echo AddBehaviorValidator::DESC; ?>">Description</label>
                    <textarea class="form-control" id="<?php echo AddBehaviorValidator::DESC; ?>" name="<?php echo AddBehaviorValidator::DESC; ?>"><?php
                      if (isset($_POST[AddBehaviorValidator::DESC]) && !$fileUploaded)
                      {
                        echo $_POST[AddBehaviorValidator::DESC];
                      }
                    ?></textarea>
                    <span class="invalidInput">
                    <?php
                      if (isset($addBehaviorValidator))
                      {
                        echo $addBehaviorValidator->getErrorMessage(AddBehaviorValidator::DESC);
                      }
                    ?>
                    </span>
                  </div>
                </div>

                <div class="col-md-11">
                  <div class="form-group">
                    <label for="<?php echo AddBehaviorValidator::BEHAVIOR_FILE; ?>">Fichier du comportement</label>
                    <input accept=".java" id="<?php echo AddBehaviorValidator::BEHAVIOR_FILE; ?>" name="<?php echo AddBehaviorValidator::BEHAVIOR_FILE; ?>" type="file">
                    <?php
                      if (isset($addBehaviorValidator))
                      {
                        if ($fileUploaded)
                        {
                          echo '<span class="success">Le comportement a bien été mis en ligne.</span>';
                        }
                        else
                        {
                          echo '<span class="invalidInput"' . $addBehaviorValidator->getErrorMessage(AddBehaviorValidator::BEHAVIOR_FILE) . '</span>';
                        }
                      }
                    ?>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <input value="Ajouter" name="<?php echo AddBehaviorValidator::BTN_ADD; ?>" class="btn btn-primary" type="submit">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      
      
      <?php require_once "includes/footer.php" ?>
    </div>
  
  
    <?php require_once "includes/scripts_js.php"; ?>
  </body>
</html>