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
       // $this->sendMail(self::$email, self::$username, self::$otpkey, self::$name);

       $result = array('response' => 'success', 'text' => 'Account created. Check you email to activate your account.' , 'type' => 'success', 'user' => self::$username);
       echo json_encode($result);
       exit();
     }
   }

   private function sendMail($email, $username, $otpkey, $name)
   {

     $rand = rand();
     $link = 'http://localhost/project/iitpConnect/AuthUser/register?e='.$email.'&tok='.$otpkey.'|.'.md5(rand()).'&u=@'.$username.'sAAMOKAMFXHWDVYIWHDVB';

     $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
     try {
         //Server settings
         $mail->SMTPDebug = 0;                                 // Enable verbose debug output
         $mail->isSMTP();                                      // Set mailer to use SMTP
         $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
         $mail->SMTPAuth = true;                               // Enable SMTP authentication
         $mail->Username = 'iitpconnect@gmail.com';            // SMTP username
         $mail->Password = 'anuragiitp12345';                           // SMTP password
         $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
         $mail->Port = 587;                                    // TCP port to connect to

         //Recipients
         $mail->setFrom('noreply@gmail.com', 'iitpConnect');
         $mail->addAddress($email, $name);                     // Add a recipient
         $mail->addAddress('anurag@blogme.co');                // Name is optional
         // $mail->addReplyTo('info@blogme.co', 'Information');
         // $mail->addCC('cc@example.com');
         // $mail->addBCC('bcc@example.com');

         //Attachments
         // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
         // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

         //Content
         $mail->isHTML(true);                                  // Set email format to HTML
         $mail->Subject = 'Confirm your iitpConnect account.';
         $mail->Body    = '<html><body> <h1>Hi'. $name .'</h1><br> Thanks for signing up to our iitpConnect. <br> Here is a link to
                    acivate your account. <a href="'. $link .'">Activate</a> <br> Thanks <br> iitpConnect team</body></html>';
         $mail->AltBody = 'Thanks';

         $mail->send();

     } catch (Exception $e) {
         echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
     }
   }
 }
