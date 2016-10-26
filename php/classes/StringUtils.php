<?php
class StringUtils
{
  public static function clean($str)
  {
    return htmlspecialchars(strip_tags(trim($str)));
  }

  public static function getContent($str)
  {
    return isset($str) ? $str : "";
  }
}
?>