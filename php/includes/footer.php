<?php
/****************************************
*  START footer
****************************************/
html::nl();
html::add_attributes(["id" => "fh5co-footer", "role" => "contentinfo"]);
html::tag("footer");
  html::add_attribute("class", "container");
  html::tag("div");

    /****************************************
    *  RobApp
    ****************************************/ 
    html::add_attribute("class", "col-md-4 col-sm-12 col-sm-push-0 col-xs-12 col-xs-push-0");
    html::tag("div");
      html::tag("h3");
        html::add_attribute("href", "https://github.com/RoboboUPMC2016/RobApp");
        html::tag("a", "RobApp");
      html::close();

      html::add_attribute("class", "textJustify");
      html::tag("p", "RobApp est l'application permettant de donner un comportement à votre Robobo.
        Avec RobApp vous donnez au Robobo les comportements que vous créez avec RobDev.
        Vous pouvez aussi télécharger les comportements partagés sur RobHub directement
        depuis votre smartphone.");
    html::close();


    /****************************************
    *  RobHub
    ****************************************/
    html::nl();
    html::add_attribute("class", "col-md-4 col-sm-12 col-sm-push-0 col-xs-12 col-xs-push-0");
    html::tag("div");
      html::tag("h3");
        html::add_attribute("href", "https://github.com/RoboboUPMC2016/RobHub");
        html::tag("a", "RobHub");
      html::close();

      html::add_attribute("class", "textJustify");
      html::tag("p", " RobHub est le reseau social de votre robobo. Vous pouvez partager des comportements
        créés avec le framework RobDev, mais aussi des vidéos et des photos.");
    html::close();


    /****************************************
    *  RobDev
    ****************************************/
    html::nl();
    html::add_attribute("class", "col-md-4 col-sm-12 col-sm-push-0 col-xs-12 col-xs-push-0");
    html::tag("div");
      html::tag("h3");
        html::add_attribute("href", "https://github.com/RoboboUPMC2016/RobDev");
        html::tag("a", "RobDev");
      html::close();

      html::insert_code('<p class="textJustify">RobDev est un framework pour créer les comportements de votre Robobo. Pour savoir comment 
        créer un comportement rendez vous sur le <a href="https://github.com/RoboboUPMC2016/RobDev/wiki">Wiki du projet RobDev</a>.</p>');
    html::close();


    /****************************************
    *  "Copyright"
    ****************************************/
    html::nl();
    html::add_attribute("class", "col-md-12 fh5co-copyright text-center");
    html::tag("div");
      html::tag("p", "&copy; UPMC GPSTL 2016");

  html::close();

/****************************************
*  END footer
****************************************/
html::close();
?>