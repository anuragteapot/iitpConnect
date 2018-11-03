<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 defined('_EXEC') or die;

 class RegisterController extends BaseController
 {
   private static $name = NULL;
   private static $username = NULL;
   private static $password = NULL;
   private static $email = NULL;
   private static $secret = NULL;

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

   public function newUser()
   {

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

     self::addUser();
   }

   private static function addUser()
   {
     $app = new Factory;
     $mysql = $app->getDBO();

     $key = Defuse\Crypto\Key::createNewRandomKey();
     $otpkey = $key->saveToAsciiSafeString();

     $plaintext = self::$username . '.' . self::$email . '.' . 'iitp';

     $new_ciphertext = Defuse\Crypto\Crypto::encrypt($plaintext, $key);

     $m = self::sendMail(self::$email, self::$username, $new_ciphertext, self::$name);

     if(!$m)
     {
       $result = array('response' => 'error', 'text' => 'Error occurred on activation link.' , 'sqlstate' => $mysql->sqlstate);
       echo json_encode($result);
       exit();
     }

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

   private static function sendMail($email, $username, $otpkey, $name)
   {
     $config = new Config;

     $rand = rand();
     $link = 'http://' . $_SERVER['HTTP_HOST'] . BASE_URL . 'register/AuthUser/e/'. $email .'/tok/'. $otpkey . '.' . sha1(rand()) . '.' . $config->secret . '/u/' . $username . '.' . rand();

     $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

         $mail->SMTPDebug = 0;                                 // Enable verbose debug output
         $mail->isSMTP();                                      // Set mailer to use SMTP
         $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
         $mail->SMTPAuth = true;                               // Enable SMTP authentication
         $mail->Username = 'iitpconnect@gmail.com';            // SMTP username
         $mail->Password = 'anurag@iitpconnect';                  // SMTP password
         $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
         $mail->Port = 587;                                    // TCP port to connect to

         //Recipients
         $mail->setFrom('noreply@gmail.com', 'iitpConnect');
         $mail->addAddress($email, $name);                     // Add a recipient
         $mail->addAddress('anurag@blogme.co');                // Name is optional

         //Content
         $mail->isHTML(true);                                  // Set email format to HTML
         $mail->Subject = 'Confirm your iitpConnect account.';
         $mail->Body    = '<html><body> <h1> Hi '. $name .'</h1><br> Thanks for register to iitpConnect. <br> Here is a link to
                    acivate your account. <a href="'. $link .'" class="m_-1672600131527813205bulletproof-btn-2"
                    style="text-decoration:none;border-style:none;border:0;padding:0;margin:0;font-size:12px;Helvetica,Arial,sans-serif;color:#ffffff;text-decoration:none;border-radius:4px;padding:8px 17px; border:1px solid #1da1f2;display:inline-block;font-weight:bold"
                    target="_blank">Activate</a> <br> Thanks <br> iitpConnect team</body></html>';
         $mail->AltBody = 'Thanks';

         if($mail->send())
         {
           return true;
         }
   }
 }
