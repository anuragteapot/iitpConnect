<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 class RegisterController extends BaseController
 {
   private static $name = NULL;
   private static $username = NULL;
   private static $password = NULL;
   private static $email = NULL;
   private static $secret = NULL;
   private static $isValidRequest = false;

   public function __construct()
   {
     if(isset($_POST['task']) && isset($_POST['username']))
     {
       $app = new Factory;
       $mysql = $app->getDBO();

       self::$name     = mysqli_real_escape_string($mysql, $_POST['name']);
       self::$username = mysqli_real_escape_string($mysql, $_POST['username']);
       self::$password = mysqli_real_escape_string($mysql, $_POST['password']);
       self::$email    = mysqli_real_escape_string($mysql, $_POST['email']);
       self::$secret   = mysqli_real_escape_string($mysql, $_POST['secret']);

        if(!preg_match("/^[a-zA-Z\s]*$/",self::$name))
        {
          $result = array('response' => 'error', 'text' => 'Name should be alphabatic.', 'message' => self::$name);
          echo json_encode($result);
          exit();
        }

        if(!preg_match('/^[a-zA-Z0-9]*_?[a-zA-Z0-9]*$/', self::$username))
        {
          $result = array('response' => 'error', 'text' => 'Invalid username.', 'message' => self::$username);
          echo json_encode($result);
          exit();
        }

        if(!filter_var(self::$email, FILTER_VALIDATE_EMAIL))
        {
          $result = array('response' => 'error', 'text' => 'Email not valid.', 'message' => self::$email);
          echo json_encode($result);
          exit();
        }

        $app->disconnect();
     }
   }

   private static function isValid()
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

   public function newUser()
   {
     self::isValid();

     if(User::checkUser(self::$username))
     {
       $result = array('response' => 'error', 'text' => 'Username already taken.', 'message' => self::$username);
       echo json_encode($result);
       exit();
     }

     if(User::checkUser(self::$email))
     {
       $result = array('response' => 'error', 'text' => 'Email already taken.', 'message' => self::$email);
       echo json_encode($result);
       exit();
     }

     if(self::$isValidRequest)
     {
       self::addUser();
     }
     else
     {
       $result = array('response' => 'error', 'text' => 'Not a valid request.');
       echo json_encode($result);
       exit();
     }
   }

   private static function addUser()
   {
     $app = new Factory;
     $mysql = $app->getDBO();

     // key
     $otpkey = sha1('otp' . self::$username . self::$password . 'key');

     $sql = "insert into users(name, username, email, password, registerDate, lastvisitDate, otpKey, params)
           values ('". self::$name ."','". self::$username ."','". self::$email ."','". sha1('1601' . self::$password . 'iitp') ."','". date("Y-m-d") ."',
           '". date("Y-m-d") ."','". $otpkey ."','". self::$secret ."')";

     $mysql->query($sql);

     if($mysql->connect_error)
     {
       $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
       echo json_encode($result);
       exit();
     }
     else
     {
       $result = array('response' => 'success', 'text' => 'Account created. Check you email to activate your account.' , 'type' => 'success', 'user' => self::$username);
       echo json_encode($result);
       exit();
     }
   }
 }
