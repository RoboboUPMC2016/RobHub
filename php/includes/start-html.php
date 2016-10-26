<?php
require_once("php/lib/html-writer/html-writer.php");
html::init();

/****************************************
*  DOCTYPE
****************************************/
html::insert_code("<!DOCTYPE html>");

/****************************************
*  START html
****************************************/
html::add_attributes(["class" => "no-js", "lang" => "fr"]);
html::tag("html");
  require_once("php/includes/head.php");

  /****************************************
  *  START body
  ****************************************/
  html::nl();
  html::tag("body");

    /****************************************
    *  START main div of body
    ****************************************/
    html::add_attribute("id", "fh5co-page");
    html::tag("div");

    require_once("php/includes/header.php");
?>