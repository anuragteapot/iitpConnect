<?php
/**
* @package    iitpConnect.Site
*
* @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
* @license    GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_EXEC') or die;

class Router
{
  private $routePath = array();

  private static $validPath;

  public function __construct()
  {
    $routePath  = [
      '0' => 'home',
      '1' => 'index.php',
      '2' => 'message',
      '3' => 'users'
    ];

    Routes::registerRoute($routePath, function() {
      self::$validPath = true;
    });
  }

  public function execute()
  {
    self::initialize();

    if(!self::$validPath)
    {
      require_once PATH_TEMPLATES . '/404.php';
      return false;
    }

    Routes::setRoute('home', function() {
        HomeController::CreateView('Home');
    });

    Routes::setRoute('index.php', function() {
      $session = new Session;
      $uid = $session->get('uid');
      if(!User::isAdmin($uid) || !User::isLoggedIn())
      {
        HomeController::CreateView('login');
      }
      else
      {
        HomeController::CreateView('Home');
      }
    });

    Routes::setRoute('message', function() {
      HomeController::CreateView('Message');
    });

    Routes::setRoute('users', function() {
      HomeController::CreateView('UsersDetails');
    });

    Routes::setRoute('index.php', function() {
      HomeController::CreateView('Home');
    });
  }

  private static function initialize()
  {
    $config = new Config;
    $mysql  = new mysqli($config->host, $config->dbusername, $config->dbpassword);

    if(!$mysql->select_db($config->db) )
    {
      die('Failed to start application. Unknown database : ' . $config->db);
    }
  }

  public function get($data)
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    $urlPatterns = array();

    $urlData =  substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], $_GET['url']));
    $expUrlData = explode('/', $urlData);

    for ($x = 0; $x <= count($expUrlData); $x = $x + 2)
    {
      $urlPatterns[$expUrlData[$x]] =  $expUrlData[$x+1];
    }

    if(array_key_exists($data, $urlPatterns))
    {
      return mysqli_real_escape_string($mysql, $urlPatterns[$data]);
    }
    else
    {
      return NULL;
    }
  }
}
