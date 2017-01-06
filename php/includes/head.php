<?php 
/****************************************
*  START head
****************************************/ 
html::tag("head");

  /***************************************
  *  meta
  ****************************************/
  html::add_attribute("charset", "utf-8");
  html::single_tag("meta");

  html::add_attributes(["http-equiv" => "X-UA-Compatible", "content" => "IE=edge"]);
  html::single_tag("meta");

  html::add_attributes(["name" => "viewport", "content" => "width=device-width, initial-scale=1"]);
  html::single_tag("meta");

  /****************************************
  *  title
  ****************************************/
  html::nl();
  html::tag("title", $PAGE_TITLE);

  /****************************************
  *  Favicon
  ****************************************/
  html::nl();
  html::add_attributes(["rel" => "shortcut icon", "href" => "favicon.ico"]);
  html::single_tag("link");

  /****************************************
  *  Fonts
  ****************************************/
  html::nl();
  html::add_attributes(["rel" => "stylesheet", "href" => "https://fonts.googleapis.com/css?family=Roboto:400,100,300,700,900", "type" => "text/css"]);
  html::single_tag("link");

  html::add_attributes(["rel" => "stylesheet", "href" => "https://fonts.googleapis.com/css?family=Playfair+Display:400,700"]);
  html::single_tag("link");

  /****************************************
  *  CSS
  ****************************************/
  html::nl();
  html::add_attributes(["rel" => "stylesheet", "href" => "assets/css/animate.css"]);
  html::single_tag("link");

  html::add_attributes(["rel" => "stylesheet", "href" => "assets/css/icomoon.css"]);
  html::single_tag("link");

  html::add_attributes(["rel" => "stylesheet", "href" => "assets/css/simple-line-icons.css"]);
  html::single_tag("link");

  html::add_attributes(["rel" => "stylesheet", "href" => "assets/css/bootstrap.min.css"]);
  html::single_tag("link");

  html::add_attributes(["rel" => "stylesheet", "href" => "http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"]);
  html::single_tag("link");

  html::add_attributes(["rel" => "stylesheet", "href" => "assets/css/style.css"]);
  html::single_tag("link");

  html::add_attributes(["media" => "all", "rel" => "stylesheet", "href" => "assets/bootstrap-star-rating/css/star-rating.min.css"]);
  html::single_tag("link");


  /****************************************
  *  Prettify
  ****************************************/
  html::add_attribute("src", "assets/js/run_prettify.js");
  html::tag("script");
  html::close();

  /****************************************
  *  Modernizr JS
  ****************************************/
  html::nl();
  html::add_attribute("src", "assets/js/modernizr-2.6.2.min.js");
  html::tag("script");
  html::close();

/****************************************
*  END head
****************************************/
html::close();
?>