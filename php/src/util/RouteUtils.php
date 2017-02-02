<?php
/**
 * The class RouteUtils defines utily methods for
 * route.
 */
class RouteUtils
{
  /**
   * Redirect to the home page.
   */
  public static function goToHomePage()
  {
    header("Location: index.php");
    exit();
  }
}
?>