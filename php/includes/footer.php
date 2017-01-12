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
      html::tag("p", "RobApp is the application making it possible to give a behavior to your Robobo. With RobApp you give to your Robobo the behaviors that you create with RobDev. You can also download the behaviors shared on RobHub directly from your smartphone.");
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
      html::tag("p", "RobHub is the social network for your Robobo. You can share behaviors
        created with the RobDev framework but also videos to show a demonstration of the behaviors.");
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

      html::insert_code('<p class="textJustify">RobDev is a framework to create behaviors for your Robobo. To know how
      to create a behavior go to <a href="https://github.com/RoboboUPMC2016/RobDev/wiki">the Wiki of the RobDev project</a>.</p>');
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