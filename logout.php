<?php
session_start();

require_once "php/src/enum/SessionData.php";
if (isset($_SESSION[SessionData::LOGIN]))
{
  // Destory variables of session
  $_SESSION = array();

  // Delete cookies
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
  }

  // Destroy session
  session_destroy();
}

require_once "php/src/util/RouteUtils.php";
RouteUtils::goToHomePage();
?>