<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 class LoginController extends BaseController
 {
   private static $username;
   private static $password;
   private static $token;
   private static $address;
   private static $isValidRequest;

   public function __construct()
   {
     if(isset($_POST['token']))
     {
       self::$token = $_POST['token'];

       if($this->isValid(self::$token))
       {
         self::$isValidRequest = true;
       }
       else
       {
         self::$isValidRequest = false;
       }
     }
   }

   private function isValid($key)
   {
     // // $config = new Config();
     // // $data = $config->secret;
     // // $hashed = hash('sha512', $data);
     // $result = array('response' => 'error', 'text' => $hashed, 'token' => $_POST['token']);
     // echo json_encode($result);
     // return true;
   }

   public function UserLogin()
   {
     if(self::$isValidRequest)
     {
       
     }
     else
     {
       $result = array('response' => 'error', 'text' => 'Not valid request.');
       echo json_encode($result);
       exit;
     }
   }

   private static function getID($username)
   {

   }

   private static function generateRandom($length = 64)
   {
     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
     $charactersLength = strlen($characters);
     $randomString = '';
     for ($i = 0; $i < $length; $i++) {
         $randomString .= $characters[rand(0, $charactersLength - 1)];
     }
     return $randomString;
   }

   public static function loginUser($username)
   {
     $tok = self::generateRandom();
     setcookie("SSID", $tok, time() + 3600, BASEDIR);
   }

   public static function isLoggedIn()
   {
     if (isset($_COOKIE['SSID']))
     {
       return true;
     } else {
       return false;
     }
   }

 }
