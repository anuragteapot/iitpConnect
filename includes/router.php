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
      '1' => 'login',
      '2' => 'register',
      '3' => 'index.php',
      '4' => 'user',
      '5' => 'profile',
      '6' => 'post',
      '7' => 'forget',
      '8' => 'leave',
      '9' => 'bus',
      '10' => 'hostel'
    ];

    Routes::registerRoute($routePath, function () {
      self::$validPath = true;
    });
  }

  public function execute()
  {
    self::initialize();

    if (!self::$validPath) {
      require_once PATH_TEMPLATES . '/404.php';
      return false;
    }

    Routes::setRoute('home', function () {
      HomeController::CreateView('Home');
    });

    Routes::setRoute('index.php', function () {
      HomeController::CreateView('Home');
    });

    Routes::setRoute('login', function () {
      LoginController::CreateView('Login');
    });

    Routes::setRoute('forget', function () {
      if ($this->get('forget') == 'AuthUser') {
        AuthUserController::CreateView('ForgetAuthUser');
      } else {
        ForgetController::CreateView('Forget');
      }
    });

    Routes::setRoute('register', function () {
      if ($this->get('register') == 'AuthUser') {
        AuthUserController::CreateView('RegisterAuthUser');
      } else {
        RegisterController::CreateView('Register');
      }
    });

    Routes::setRoute('profile', function () {
      if ($this->get('profile') == 'edit') {
        RegisterController::CreateView('PostEdit');
      } else {
        RegisterController::CreateView('Profile');
      }
    });

    Routes::setRoute('post', function () {
      if ($this->get('post') == 'cab') {
        RegisterController::CreateView('Cab');
      } else {
        RegisterController::CreateView('Post');
      }
    });

    Routes::setRoute('user', function () {
      RegisterController::CreateView('User');
    });

    Routes::setRoute('leave', function () {
      RegisterController::CreateView('Leave');
    });

    Routes::setRoute('bus', function () {
      RegisterController::CreateView('Bus');
    });

    Routes::setRoute('hostel', function () {
      if ($this->get('hostel') == 'select') {
          RegisterController::CreateView('HostelSelect');
      } if($this->get('hostel') == 'view') {
        RegisterController::CreateView('HostelView');
      } else {
        RegisterController::CreateView('HostelSelect');
      }
    });
  }

  private static function initialize()
  {
    $config = new Config;
    $mysql  = new mysqli($config->host, $config->dbusername, $config->dbpassword);

    if (!$mysql->select_db($config->db)) {
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

    for ($x = 0; $x <= count($expUrlData); $x = $x + 2) {
      $urlPatterns[$expUrlData[$x]] =  $expUrlData[$x + 1];
    }

    if (array_key_exists($data, $urlPatterns)) {
      return mysqli_real_escape_string($mysql, $urlPatterns[$data]);
    } else {
      return NULL;
    }
  }
}
