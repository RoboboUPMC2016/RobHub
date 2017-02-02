<?php
/**
 * The class StringUtils defines utility methods
 * for string.
 */
class StringUtils
{
  /**
   * Sanitize a string to prevent injection attacks.
   *
   * @param string $str The string to sanitize.
   */
  public static function clean($str)
  {
    return htmlspecialchars(strip_tags(trim($str)));
  }
}
?>