<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 defined('_EXEC') or die;

 class ForgetController extends BaseController
 {
   private static $email = NULL;
   private static $username = NULL;
   private static $name = NULL;

   public function __construct()
   {
     if(isset($_POST['email']))
     {
       $app = new Factory;
       $mysql = $app->getDBO();

       self::$email = mysqli_real_escape_string($mysql, $_POST['email']);

        if(!filter_var(self::$email, FILTER_VALIDATE_EMAIL))
        {
          $result = array('response' => 'error', 'text' => 'Email is not valid.', 'message' => self::$email);
          echo json_encode($result);
          exit();
        }

        $app->disconnect();
     }
   }

   public function forget()
   {
     if(!User::checkUser(self::$email))
     {
       $result = array('response' => 'error', 'text' => 'Account associated with this email not found.', 'message' => self::$email);
       echo json_encode($result);
       exit();
     }

    $row = User::checkUser(self::$email, true);

    self::$username = $row['username'];
    self::$name =  $row['name'];

    self::sendLink();
   }

   private static function sendLink()
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
       $result = array('response' => 'error', 'text' => 'Error occurred on sending forget link.' , 'sqlstate' => $mysql->sqlstate);
       echo json_encode($result);
       exit();
     }

     $e = self::$email;
     $u = self::$username;
     $sql = "update users set otpkey='". $otpkey ."' where username = '" . $u ."' AND email = '" . $e ."'";

     $mysql->query($sql);

     if($mysql->connect_error)
     {
       $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
       echo json_encode($result);
       exit();
     }
     else
     {
       $result = array('response' => 'success', 'text' => 'Reset link send.' , 'type' => 'success', 'user' => self::$username);
       echo json_encode($result);
       exit();
     }
   }

   private static function sendMail($email, $username, $otpkey, $name)
   {
     $config = new Config;

     $rand = rand();
     $link = 'http://' . $_SERVER['HTTP_HOST'] . BASE_URL . 'forget/AuthUser/e/'. $email .'/tok/'. $otpkey . '.' . sha1(rand()) . '.' . $config->secret . '/u/' . $username . '.' . sha1(rand());

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
         $mail->Subject = 'Reset link to your iitpConnect account.';
         $mail->Body    = '<html><body> <h1> Hi '. $name .'</h1><br> Click to link given below to reset your password.<br> Here is a link to
                    reset your account. <a href="'. $link .'" class="m_-1672600131527813205bulletproof-btn-2"
                    style="text-decoration:none;border-style:none;border:0;padding:0;margin:0;font-size:12px;Helvetica,Arial,sans-serif;color:#ffffff;text-decoration:none;border-radius:4px;padding:8px 17px; border:1px solid #1da1f2;display:inline-block;font-weight:bold"
                    target="_blank">Reset</a> <br> Thanks <br> iitpConnect </body></html>';
         $mail->AltBody = 'Thanks';

         if($mail->send())
         {
           return true;
         }
   }
 }
