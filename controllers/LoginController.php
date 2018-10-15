<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 class LoginController extends BaseController
 {
   private static $username = NULL;
   private static $password = NULL;
   private static $token = NULL;
   private static $address = NULL;
   private static $isValidRequest = false;

   public function __construct()
   {
     if(isset($_POST['token']) && !isset($_SESSION['token']))
     {
       self::$isValidRequest = true;
       self::$username = $_POST['username'];
       self::$password = sha1('1601' . $_POST['userpassword'] . 'iitp');
       self::$token = sha1(self::generateRandom());
       self::$address = $_SERVER['SERVER_ADDR'];
     }
   }

   private function isValid()
   {
     $config = new Config;
     $request = new Request;

     $key = $request->headers->CSRFToken;

     if($config->secret == $key)
     {
       self::$isValidRequest = true;
     }
     else
     {
       self::$isValidRequest = false;
     }
   }

   public function Auth()
   {
     if(self::$isValidRequest)
     {
       User::getInstance(self::$username, self::$password);

       if(User::$validUser)
       {
         if(!User::$activation)
         {
           $result = array('response' => 'error', 'text' => 'Your account is not activated.', 'message' => User::$username);
           echo json_encode($result);
           exit();
         }

         $session = new Session;
         $options = array();

         $options['username'] = self::$username;
         $options['name'] = User::$name;
         $options['ipaddress'] = self::$address;
         $options['token'] = self::$token;
         $options['email'] = User::$useremail;

         $session->set($options);
         $result = array('response' => 'success', 'text' => User::$username, 'message' => 'login successfull');
         echo json_encode($result);
         exit();
       }
       else
       {
         $result = array('response' => 'error', 'text' => 'Wrong username or password.');
         echo json_encode($result);
         exit();
       }
     }
     else
     {
       $result = array('response' => 'error', 'text' => 'Not a valid request.');
       echo json_encode($result);
       exit();
     }
   }

   private static function generateRandom($length = 64)
   {
     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
     $charactersLength = strlen($characters);
     $randomString = '';

     for ($i = 0; $i < $length; $i++)
     {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
     }

     return $randomString;
   }

   public function UserLogin()
   {
     if(!isset($_SESSION['token']))
     {
       $this->isValid();
       $this->Auth();
     }
   }

   public function UserLogout()
   {
     $session = new Session;
     $session->destroy();
     $result = array('response' => 'success', 'message' => 'Logout successfull');
     echo json_encode($result);
     exit();
   }
 }
