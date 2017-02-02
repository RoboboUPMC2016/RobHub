<?php

/**
 * The class SessionData defines the key for the 
 * $_SESSION array.
 */
abstract class SessionData
{
  /**
   * string The key login of the user.
   */
  const LOGIN = "login";

  /**
   * string The key of the user.
   */
  const FIRSTNAME = "firstname";

  /**
   * string The key of the user.
   */
  const LASTNAME = "lastname";
}
?>