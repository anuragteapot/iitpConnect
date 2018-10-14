<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

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
       '3' => 'index.php'
     ];

     Routes::registerRoute($routePath, function() {
       self::$validPath = true;
     });
   }

   public function execute()
   {
     if(!self::$validPath)
     {
       die('URL is not valid.');
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
   }
 }

$app = new Router();
$app->execute();
