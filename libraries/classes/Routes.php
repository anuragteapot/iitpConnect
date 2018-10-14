<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

class Routes
{
  public static $validRoutes = array();

  public static function setRoute($route, $function)
  {
    self::$validRoutes = $route;
    if($_GET['url'] == $route)
    {
      $function->__invoke();
    }
  }

  public static function registerRoute($route, $function)
  {
    if(!in_array($_GET['url'], $route))
    {
      echo 'Url not found . 404';
      die();
    }
    else
    {
      $function->__invoke();
    }
  }
}
