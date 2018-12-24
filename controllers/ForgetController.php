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
  private static $password = NULL;

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
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('noreply@gmail.com', 'iitpConnect');
    $mail->addAddress($email, $name);                     // Add a recipient

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Reset link to your iitpConnect account.';
    $mail->Body    = '

    <html>
    <head>
    </head>
    <body style="text-align:center;">
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
    <td valign="top" style="text-align:center;padding:50px 0 10px 20px; color:white;">
    <h1 style="margin:0;sans-serif;font-size:30px;padding:10px;line-height:36px;color:#ffffff;font-weight:bold">
    <span class="il">iitpConnect</span> Password reset</h1>
    </td>
    </tr>
    <tr>
    <td valign="top" align="center" style="text-align:center;padding:15px 0px 60px 0px">
    <center>
    <table role="presentation" align="center" cellspacing="0" cellpadding="0" border="0"  style="text-align:center">
    <tbody>
    <tr>
    <td style="border-radius:50px;background:#26a4d3;text-align:center">
    <a href="'. $link  . '" style="padding:10px 20px; background:#26a4d3;border:15px solid #26a4d3;sans-serif;font-size:14px;line-height:1.1;text-align:center;text-decoration:none;display:block;border-radius:50px;font-weight:bold" ><span style="color:#ffffff;padding:20px;">&nbsp;&nbsp;&nbsp;&nbsp;Reset Password&nbsp;&nbsp;
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
    We received a request to Reset to iitpConnect Password.  To reset your password Please click
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
    </html>';

    $mail->AltBody = 'Thanks';

    if($mail->send())
    {
      return true;
    }
  }

  public function reset()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    self::$password = mysqli_real_escape_string($mysql, $_POST['password']);
    self::$username = mysqli_real_escape_string($mysql, $_POST['username']);

    if(!User::checkUser(self::$username))
    {
      $result = array('response' => 'error', 'text' => 'Account associated with this email not found.');
      echo json_encode($result);
      exit();
    }

    $password = sha1('1601' . self::$password . 'iitp');
    $u = self::$username;
    $e = self::$email;

    $sql = "update users set password='". $password ."' where username = '" . $u ."' AND email = '" . $e ."'";

    $mysql->query($sql);

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
      echo json_encode($result);
      exit();
    }
    else
    {

      $row = User::checkUser($u, true);
      $name = $row['name'];

      self::congrat($e, $u, $name);

      $session = new Session;
      $session->clear('resetusername');
      $session->clear('resetemail');

      $result = array('response' => 'success', 'text' => 'Congratulation\'s your password has been successfully update.' , 'type' => 'success', 'user' => self::$username);
      echo json_encode($result);
      exit();
    }
  }

  private static function congrat($email, $username, $name)
  {
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'iitpconnect@gmail.com';            // SMTP username
    $mail->Password = 'anurag@iitpconnect';                  // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('noreply@gmail.com', 'iitpConnect');
    $mail->addAddress($email, $name);                     // Add a recipient

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Congratulation\'s your password has been successfully updated.';
    $mail->Body    = '

    <html>
    <head>
    </head>
    <body style="text-align:center;">
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
    <td valign="top" style="text-align:center;padding:50px 0 10px 20px; color:white;">
    <h1 style="margin:0;sans-serif;font-size:30px;padding:10px;line-height:36px;color:#ffffff;font-weight:bold">
    <span class="il">iitpConnect </span> Congratulation\'s </h1>
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
    <td style="padding:10px 10px 10px 10px;text-align:left">
    <h1 style="margin:0;sans-serif;font-size:20px;line-height:26px;color:#333333;font-weight:bold">Hi </h1>
    </td>
    </tr>
    <tr>
    <td style="padding:0px 40px 20px 40px;font-family:sans-serif;font-size:15px;line-height:20px;color:#555555;text-align:left;font-weight:bold">
    <p style="margin:0">Hi '. $name .',<br>
    Congratulation\'s your password has been successfully updated.
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
    </html>';

    $mail->AltBody = 'Thanks';

    if($mail->send())
    {
      return true;
    }
  }
}
