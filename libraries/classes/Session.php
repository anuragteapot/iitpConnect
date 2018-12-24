<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_EXEC') or die;

class Session
{

  function __construct()
  {
    if(session_status() == PHP_SESSION_NONE)
    {
      session_start();
    }
  }

  public function set($options, $lifetime = false)
  {
    foreach ($options as $key => $value)
    {
      $_SESSION[$key] = $value;

      if($lifetime)
      {
        setcookie($key, $value, time() + (10 * 365 * 24 * 60 * 60) , "/","", 0);
      }
      else
      {
        setcookie($key, $value, time() + 3600 , "/","", 0);
      }
    }
  }

  public function get($value)
  {
    if(isset($_SESSION[$value]))
    {
      return $_SESSION[$value];
    }
    else if(isset($_COOKIE[$value]))
    {
      return $_COOKIE[$value];
    }
    else
    {
      return NULL;
    }
  }

  public function clear($value)
  {
     unset($_SESSION[$value]);
     setcookie( $value, "", time()- 60, "/","", 0);
  }

  public function destroy()
  {
    if (isset($_SERVER['HTTP_COOKIE']))
    {
      $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
      foreach($cookies as $cookie)
      {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
      }
    }

    session_unset();
    session_destroy();

    $options = array();
    $options['iitpConnect_user_state'] = 'logged_out';
    $this->set($options);
  }
}
