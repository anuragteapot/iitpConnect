<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_EXEC') or die;

define('BASE_PATH', dirname(__DIR__));

if(file_exists(BASE_PATH . '/includes/define.php'))
{
  require_once BASE_PATH . '/includes/define.php';
}

if(!file_exists(BASE_PATH . '/configuration.php'))
{
  header('Location: ' . substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], 'index.php')) . 'installation/index.php');
  exit;
}

ob_start();
require_once BASE_PATH . '/configuration.php';
ob_end_clean();

if(file_exists(PATH_LIBRARIES . '/autoload.php'))
{
  require_once PATH_LIBRARIES . '/autoload.php';
}

if(file_exists(BASE_PATH . '/includes/router.php'))
{
  require_once BASE_PATH . '/includes/router.php';
}
