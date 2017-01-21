<?php
class UrlUtils
{
  public static function getBaseUrl()
  {
    $baseUrl = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $baseUrl .= $_SERVER["SERVER_NAME"];

    // Add robhub if localhost
    $baseUrl .= $_SERVER["SERVER_NAME"] === "localhost" ? "/robhub/" : "/";

    return $baseUrl;
  }

  public static function getCurrentURL()
  {
    $currentURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $currentURL .= $_SERVER["SERVER_NAME"];
 
    if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443")
    {
        $currentURL .= ":" . $_SERVER["SERVER_PORT"];
    } 
 
    $currentURL .= $_SERVER["REQUEST_URI"];
    return $currentURL;
  }

  public static function getBehaviorDetailsUrl($behaviorId)
  {
    return UrlUtils::getBaseUrl() . "behaviordetails.php?bid=" . $behaviorId;
  }
}
?>