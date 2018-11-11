<?php
/**
* @package    iitpConnect.Site
*
* @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
* @license    GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_EXEC') or die;

class AuthUserController extends BaseController
{
  private static $username;
  private static $token;
  private static $email;

  public function __construct()
  {
    $route = new Router;

    self::$email = $route->get('e');
    self::$token = $route->get('tok');
    self::$username = $route->get('u');

    if(!empty(self::$email) && !empty(self::$token) && !empty(self::$username))
    {
      $this->validate();
    }
  }

  protected function validate()
  {
    $expToken = explode('.', self::$token);

    $app   = new Factory;
    $mysql = $app->getDBO();

    $expuname = explode('.', self::$username);

    $sql = "SELECT otpKey,activation FROM users where username = '" . $expuname[0] ."' AND email = '" . self::$email. "'";

    $res = $mysql->query($sql);

    if($res->num_rows != 1)
    {
      $msg = 'Something goes wrong with link.';

      header('Location: ' . BASE_URL . $_GET['url'] . '/AuthUser/e/' . $msg);
      exit();
    }

    $row = $res->fetch_assoc();

    if($row['activation'] == 1)
    {
      $msg = 'Your account is already Activated.';

      header('Location: ' . BASE_URL . $_GET['url'] . '/AuthUser/m/' . $msg);
      exit();
    }

    $otpkey = $row['otpKey'];

    $key = Defuse\Crypto\Key::LoadFromAsciiSafeString($otpkey);

    $verifyString = Defuse\Crypto\Crypto::decrypt($expToken[0], $key);

    $expverifyString = explode('.', $verifyString);

    $config = new Config;

    if($expverifyString[0] == $expuname[0] && $config->secret == $expToken[2])
    {
      $this->activate($expuname[0], $otpkey);
    }
    else
    {
      $msg = 'Something goes wrong with link.';

      header('Location: ' . BASE_URL . $_GET['url'] . '/AuthUser/e/' . $msg);
      exit();
    }

    $app->disconnect();
  }

  protected function activate($username, $otpkey)
  {
    $app   = new Factory;
    $mysql = $app->getDBO();

    $sql = "update users set activation='" . 1 . "' where username = '" . $username ."' AND otpKey = '" . $otpkey . "'";

    $res = $mysql->query($sql);

    if($res)
    {
      self::sendMail(self::$email, $username);

      $msg = 'Your Account is Activated.';

      header('Location: ' . BASE_URL . $_GET['url'] . '/AuthUser/m/' . $msg);
      exit();
    }
    else
    {
      $msg = 'Something goes wrong with link.';

      header('Location: ' . BASE_URL . $_GET['url'] . '/AuthUser/e/' . $msg);
      exit();
    }

    $app->disconnect();
  }

  private static function sendMail($email, $username)
  {
    $link = 'http://' . $_SERVER['HTTP_HOST'] . BASE_URL;

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
    $mail->addAddress($email, $username);                     // Add a recipient
    $mail->addAddress('anurag@blogme.co');                // Name is optional

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Welcome to iitpConnect.';
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
    <span class="il">iitpConnect</span> Welcome</h1>
    </td>
    </tr>
    <tr>
    <td valign="top" align="center" style="text-align:center;padding:15px 0px 60px 0px">
    <center>
    <table role="presentation" align="center" cellspacing="0" cellpadding="0" border="0"  style="text-align:center">
    <tbody>
    <tr>
    <td style="border-radius:50px;background:#26a4d3;text-align:center">
    <a href="'. $link  . '" style="background:#26a4d3;border:15px solid #26a4d3;sans-serif;font-size:14px;line-height:1.1;text-align:center;text-decoration:none;display:block;border-radius:50px;font-weight:bold" ><span style="color:#ffffff">&nbsp;&nbsp;&nbsp;&nbsp;Go to Application.&nbsp;&nbsp;
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
    <p style="margin:0">Hi '. $username .',<br>
    Thank you being a part of iitpConnect. Enjoy our application feature. Please click
    <a href="' . $link .  ' " target="_blank" >here</a> to start.<br>
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
}
