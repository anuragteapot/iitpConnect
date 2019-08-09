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
      self::$username = strtolower(mysqli_real_escape_string($mysql, $_POST['username']));
      self::$password = mysqli_real_escape_string($mysql, $_POST['password']);
      self::$email    = mysqli_real_escape_string($mysql, $_POST['email']);
      self::$secret   = 1;

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
        $result = array('response' => 'error', 'text' =>'Email is not valid.', 'message' => self::$email);
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
    $mail->Body    = '
    <html>
    <head>
    </head>
    <body class="text-align:center;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width:680px">
    <tbody>
    <tr>
    <td bgcolor="#222222" align="center" valign="top" style="text-align:center;background-position:center center!important;background-size:cover!important">
    <div>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:500px;margin:auto">
    <tbody>
    <tr>
    <td height="20" style="font-size:20px;line-height:20px">&nbsp;</td>
    </tr>
    <tr>
    <td align="center" valign="middle">
    <table>
    <tbody>
    <tr>
    <td valign="top" style="text-align:center;padding:60px 0 10px 20px;color:white;">
    <h1 style="margin:0;sans-serif;font-size:30px;line-height:36px;color:#ffffff;font-weight:bold">
    <span class="il">iitpConnect</span> Activation</h1>
    </td>
    </tr>
    <tr>
    <td valign="top" align="center" style="text-align:center;padding:15px 0px 60px 0px">
    <center>
    <table role="presentation" align="center" cellspacing="0" cellpadding="0" border="0"  style="text-align:center">
    <tbody>
    <tr>
    <td style="border-radius:50px;background:#26a4d3;text-align:center">
    <a href="'. $link  . '" style="background:#26a4d3;border:15px solid #26a4d3;sans-serif;font-size:14px;line-height:1.1;text-align:center;text-decoration:none;display:block;border-radius:50px;font-weight:bold" ><span style="color:#ffffff">&nbsp;&nbsp;&nbsp;&nbsp;Activate&nbsp;&nbsp;
    </a>
    </td>
    </tr>
    </tbody>
    </table>
    </center>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    <tr>
    <td height="20" style="font-size:20px;line-height:20px">&nbsp;</td>
    </tr>
    </tbody>
    </table>
    </div>
    </td>
    </tr>
    <tr>
    <td bgcolor="#ffffff">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tbody>
    <tr>
    <td style="padding:40px 40px 20px 40px;text-align:left">
    <h1 style="margin:0;sans-serif;font-size:20px;line-height:26px;color:#333333;font-weight:bold">Hi </h1>
    </td>
    </tr>
    <tr>
    <td style="padding:0px 40px 20px 40px;font-family:sans-serif;font-size:15px;line-height:20px;color:#555555;text-align:left;font-weight:bold">
    <p style="margin:0">Hi '. $name .',<br>
    Thank you for registering to iitpConnect. To activate your account. Please click
    <a href="' . $link .  ' " target="_blank" >here</a>.<br>
    <br>
    </p>
    </td>
    </tr>
    <tr>
    <td style="padding:0px 40px 20px 40px;font-family:sans-serif;font-size:15px;line-height:20px;color:#555555;text-align:left;font-weight:normal">
    <p style="margin:0">Thank You. <br><br>iitpConnect</p>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    <tr>
    <td bgcolor="#292828">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tbody>
    <tr>
    <td style="padding:40px 40px 10px 40px;font-family:sans-serif;font-size:12px;line-height:18px;color:#666666;text-align:center;font-weight:normal">
    <p style="margin:0">Indian Institute of Technology Patna Bihta, Bihār, India 801118</p>
    </td>
    </tr>
    <tr>
    <td style="padding:0px 40px 40px 40px;font-family:sans-serif;font-size:12px;line-height:18px;color:#666666;text-align:center;font-weight:normal">
    <p style="margin:0">Copyright © 2018 <b><span class="il">iitpConnect</span> IIT Patna</b>, All Rights Reserved.</p>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </body>
    </html>
    ';

    $mail->AltBody = 'Thanks';

    if($mail->send())
    {
      return true;
    }
  }
}
