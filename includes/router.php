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
       die('Path not found');
     }

     Routes::setRoute('home', function() {
         HomeController::CreateView('home');
         HomeController::execute();
     });

     Routes::setRoute('index.php', function() {
         HomeController::CreateView('home');
         HomeController::execute();
     });

     Routes::setRoute('login', function() {
         LoginController::CreateView('login');
     });

     Routes::setRoute('register', function() {
         RegisterController::CreateView('register');
     });
   }
 }

$app = new Router();
$app->execute();
