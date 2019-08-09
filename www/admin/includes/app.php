<?php
/**
* @package    iitpConnect.Site
*
* @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
* @license    GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_EXEC') or die;

define('BASE_PATH', dirname(__DIR__));
define('ADMIN_PATH', dirname(__DIR__));
define('SITE_PATH', substr(dirname(__DIR__), 0, strpos(dirname(__DIR__), 'admin')));

// echo SITE_PATH;

session_start();

if(file_exists(ADMIN_PATH . '/includes/define.php'))
{
  require_once ADMIN_PATH . '/includes/define.php';
}

if(!file_exists(SITE_PATH . '/configuration.php'))
{
  header('Location: ' . substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], 'admin')) . 'installation/index.php');
  exit;
}

ob_start();
require_once SITE_PATH . '/configuration.php';
ob_end_clean();

$config = new Config();
define('BASE_URL', $config->baseurl . 'admin/');

if($config->error_reporting == 'default')
{
  ini_set('display_errors', '0');
  error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
  ini_set('zlib_output_compression','On');
  date_default_timezone_set("Asia/Kolkata");
  ini_set("log_errors", 1);
  ini_set("error_log", "errors.log");
}
else
{
  error_reporting($config->error_reporting);
}


if(file_exists(PATH_LIBRARIES . '/autoload.php'))
{
  require_once PATH_LIBRARIES . '/autoload.php';
}

// echo PATH_LIBRARIES;

if(file_exists(BASE_PATH . '/includes/router.php'))
{
  require_once BASE_PATH . '/includes/router.php';
}

if(file_exists(BASE_PATH . '/includes/request.php'))
{
  require_once BASE_PATH . '/includes/request.php';
}

if(!isset($_GET['task']))
{
  $app = new Router();
  $app->execute();
}
