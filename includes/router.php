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
       '5' => 'profile'
     ];

     Routes::registerRoute($routePath, function() {
       self::$validPath = true;
     });
   }

   public function execute()
   {
     $config = new Config;

     $mysql = new mysqli($config->host, $config->dbusername, $config->dbpassword);

     if(!$mysql->select_db($config->db) )
     {
       die('Failed to start application. Unknown database : ' . $config->db);
     }

     if(!self::$validPath)
     {
       require_once PATH_TEMPLATES . '/404.php';
       return false;
     }

     Routes::setRoute('home', function() {
         HomeController::CreateView('Home');
     });

     Routes::setRoute('index.php', function() {
         HomeController::CreateView('Home');
     });

     Routes::setRoute('login', function() {
         LoginController::CreateView('Login');
     });

     Routes::setRoute('register', function() {
         RegisterController::CreateView('Register');
     });

     Routes::setRoute('profile', function() {
         RegisterController::CreateView('Profile');
     });

     Routes::setRoute('user', function() {
       // echo $_GET['uname'];
       // echo $_GET['uid'];
       // RegisterController::CreateView('Register');
     });
   }
 }
