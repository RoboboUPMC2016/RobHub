<?php

/**
 * The class UrlUtils defines utility methods
 * for URL.
 */
class UrlUtils
{
  /**
   * Get the base URL of the web site.
   *
   * @return string The base URL of the website.
   */
  public static function getBaseUrl()
  {
    $baseUrl = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $baseUrl .= $_SERVER["SERVER_NAME"];

    // Add robhub if localhost
    $baseUrl .= $_SERVER["SERVER_NAME"] === "localhost" ? "/robhub/" : "/";

    return $baseUrl;
  }

  /**
   * Get the current URL of the page.
   *
   * @return string The current URL of the page.
   */
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

  /**
   * Get the URL of the behavior details page.
   *
   * @param integer $behaviorId The Id of the behavior.
   * @return string The URL of the behavior details page.
   */
  public static function getBehaviorDetailsUrl($behaviorId)
  {
    return UrlUtils::getBaseUrl() . "behaviordetails.php?bid=" . $behaviorId;
  }
}
?>