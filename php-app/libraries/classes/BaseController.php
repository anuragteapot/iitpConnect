<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_EXEC') or die;

class BaseController
{
  public function __construct()
  {

  }

  public static function CreateView($viewName)
  {

    if(file_exists(PATH_VIEWS . '/' . $viewName .  '.php'))
    {
      require_once PATH_VIEWS . '/' . $viewName . '.php';
    } else {
      throw new \Exception("View not found.", 404);
    }
  }
}
