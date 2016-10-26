<?php
class RouteUtils
{
  public static function goToHomePage()
  {
    header("Location: index.php");
    exit();
  }
}
?>