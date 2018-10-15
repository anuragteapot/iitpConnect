<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

class Session
{

  function __construct()
  {
    if(session_status() == PHP_SESSION_NONE)
    {
      session_start();
    }
  }

  public function set($options)
  {
    foreach ($options as $key => $value)
    {
      $_SESSION[$key] = $value;
    }
  }

  public function get($value)
  {
    if(isset($_SESSION[$value]))
    {
      return $_SESSION[$value];
    }
    else
    {
      return NULL;
    }
  }

  public function clear($value)
  {
     unset($_SESSION[$value]);
  }

  public function destroy()
  {
    session_unset();
    session_destroy();
  }
}
