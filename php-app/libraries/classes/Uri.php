<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 defined('_EXEC') or die;
 
class Uri
{
  public static function get($param)
  {
    if (strpos($_SERVER['REQUEST_URI'], '?') !== false)
    {
      return explode('&', explode($param.'=', $_SERVER['REQUEST_URI'])[1])[0];
    }
    else
    {
      return false;
    }
  }
}
