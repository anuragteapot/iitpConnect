<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

define('_EXEC', 1);

require_once __DIR__ . '/templates/install.html';

if(file_exists(dirname(__DIR__) . '/configuration.php'))
{
  header('Location: ' . substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '/installation')));

  exit;
}
