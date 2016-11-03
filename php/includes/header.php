<?php
require_once "php/src/enum/PageTitle.php";
require_once "php/src/enum/SessionData.php";

/****************************************
*  START headeer
****************************************/
html::add_attributes(["id" => "fh5co-header", "role" => "banner"]);
html::tag("header");

  html::add_attribute("class", "container");
  html::tag("div");
    html::add_attribute("class", "header-inner");
    html::tag("div");
      /****************************************
      *  Logo and title
      ****************************************/
      html::tag("h1");
        html::add_attributes(["id" => "logo-robhub", "src" => "assets/images/robhub.svg", "alt" => "RobHub logo"]);
        html::single_tag("img");

        html::add_attribute("href", "index.php");
        html::tag("a", "RobHub");
      html::close();


      /****************************************
      *  Menu
      ****************************************/
      html::add_attribute("role", "navigation");
      html::tag("nav");
        html::tag("ul");

          /****************************************
          *  Home
          ****************************************/
          html::tag("li");
            html::add_attribute("href", "index.php");
            if ($PAGE_TITLE === PageTitle::HOME)
            {
              html::add_attribute("class", "active");
            }
            html::tag("a", PageTitle::HOME);
          html::close();

          // If the user is not yet authenticated
          if (!isset($_SESSION[SessionData::LOGIN]))
          {
              /****************************************
              *  Signup
              ****************************************/
              html::tag("li");
                html::add_attribute("href", "signup.php");
                if ($PAGE_TITLE === PageTitle::SIGNUP)
                {
                  html::add_attribute("class", "active");
                }
                html::tag("a", PageTitle::SIGNUP);
              html::close();

              /****************************************
              *  Signin
              ****************************************/
              html::tag("li");
                html::add_attribute("href", "signin.php");
                if ($PAGE_TITLE === PageTitle::SIGNIN)
                {
                  html::add_attribute("class", "active");
                }
                html::tag("a", PageTitle::SIGNIN);
              html::close();
          }
          else
          {
              /****************************************
              *  Add behavior
              ****************************************/
              html::tag("li");
                html::add_attribute("href", "addbehavior.php");
                if ($PAGE_TITLE === PageTitle::ADD_BEHAVIOR)
                {
                  html::add_attribute("class", "active");
                }
                html::tag("a", PageTitle::ADD_BEHAVIOR);
              html::close();


              /****************************************
              *  Logout
              ****************************************/
              html::tag("li");
                html::add_attribute("href", "logout.php");
                html::tag("a", PageTitle::LOGOUT);
              html::close();
          }
        html::close();
      html::close();

    html::close();

  html::close();
/****************************************
*  END headeer
****************************************/
html::close();
html::nl();
?>