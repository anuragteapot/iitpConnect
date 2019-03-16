<?php
/**
* @package    iitpConnect.Site
*
* @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
* @license    GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_EXEC') or die;

class ProfileController extends BaseController
{
  private static $name = NULL;
  private static $username = NULL;
  private static $password = NULL;
  private static $location = NULL;
  private static $institute = NULL;
  private static $phonenumber = NULL;
  private static $useremail = NULL;
  private static $toggleState = NULL;
  private static $actiontype = NULL;
  private static $uid = NULL;

  private static $message = NULL;
  private static $postTitle = NULL;
  private static $postType = NULL;


  public function __construct()
  {
    $session = new Session;

    self::$username   = $session->get('username');
    self::$useremail  = $session->get('email');
    self::$uid        = $session->get('uid');

    if(isset($_POST['Actiontype']))
    {
      self::$actiontype = $_POST['Actiontype'];
    }
    else
    if(isset($_POST['toggleState']))
    {
      self::$toggleState = $_POST['toggleState'];
    }
    else if(isset($_POST['name']))
    {
      self::$password     = $_POST['password'];
      self::$name         = $_POST['name'];
      self::$location     = $_POST['location'];
      self::$phonenumber  = $_POST['phonenumber'];
      self::$institute    = $_POST['institute'];
    }
    else if(isset($_POST['postType']) && isset($_POST['message']))
    {
      self::$message    = $_POST['message'];
      self::$postType   = $_POST['postType'];
      self::$postTitle  = $_POST['postTitle'];
    }

    if(!User::isLoggedIn())
    {
      $result = array('response' => 'error', 'text' => 'Login to update profile.');
      echo json_encode($result);
      exit();
    }

  }

  public function UpdateUserData()
  {
    if(!User::checkUser(self::$username))
    {
      $result = array('response' => 'error', 'text' => 'User not found.');
      echo json_encode($result);
      exit();
    }

    if(!preg_match("/^[a-zA-Z\s]*$/",self::$name))
    {
      $result = array('response' => 'error', 'text' => 'Name should be alphabatic.', 'message' => self::$name);
      echo json_encode($result);
      exit();
    }

    self::updateDate();
  }

  public static function updateDate()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    if(empty(self::$password) || self::$password == NULL)
    {

      $sql = "update users set name='". self::$name ."',address='". self::$location . "',institute='". self::$institute . "', phonenumber='". self::$phonenumber . "'
      where username = '" . self::$username ."' AND email = '" . self::$useremail ."'";
    }
    else
    {

      $sql = "update users set name='". self::$name ."', password='". sha1('1601' . self::$password . 'iitp') ."', address='". self::$location . "',
      institute='". self::$institute ."', phonenumber='". self::$phonenumber ."'
      where username = '" . self::$username ."' AND email = '" . self::$useremail ."'";
    }

    $mysql->query($sql);

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
      echo json_encode($result);
      exit();
    }
    else
    {
      $result = array('response' => 'success', 'text' => 'Your account details updated.' , 'type' => 'success', 'user' => self::$username);
      echo json_encode($result);
      exit();
    }
  }

  public function post()
  {
    if(!User::checkUser(self::$username))
    {
      $result = array('response' => 'error', 'text' => 'User not found.');
      echo json_encode($result);
      exit();
    }

    self::addPost();
  }

  public function pUpdate()
  {

    if(!User::checkUser(self::$username))
    {
      $result = array('response' => 'error', 'text' => 'User not found.');
      echo json_encode($result);
      exit();
    }

    self::updatePost();
  }

  public function updateState()
  {

    if(!User::checkUser(self::$username))
    {
      $result = array('response' => 'error', 'text' => 'User not found.');
      echo json_encode($result);
      exit();
    }

    self::updatePost(self::$toggleState);
  }

  public function sendmail()
  {

    if(!User::checkUser(self::$username))
    {
      $result = array('response' => 'error', 'text' => 'User not found.');
      echo json_encode($result);
      exit();
    }

    self::smail();
  }

  private static function addPost()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    $sql = "insert into posts(uid, title, message, type, entryDate, status)
    values ('". self::$uid ."','". self::$postTitle ."','". self::$message ."','". self::$postType ."','". date('Y-m-d h:i:s') ."','". 1 ."')";

    $mysql->query($sql);

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
      echo json_encode($result);
      exit();
    }
    else
    {
      $result = array('response' => 'success', 'text' => 'Posted' , 'type' => 'success');
      echo json_encode($result);
      exit();
    }
  }

  private static function updatePost($toggleState = '')
  {
    if(isset($_POST['postId']))
    {
      $pid = $_POST['postId'];
    }
    else
    {
      $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
      echo json_encode($result);
      exit();
    }

    $app = new Factory;
    $mysql = $app->getDBO();

    if($toggleState == '')
    {
      $sql = "UPDATE posts SET message = '" . self::$message. "', title = '". self::$postTitle ."', type = '". self::$postType ."' WHERE pid = '" . $pid ."' AND uid = '". self::$uid . "'";
    }
    else
    {
      $sql = "UPDATE posts SET status = '" . self::$toggleState ."' WHERE pid = '" . $pid ."' AND uid = '". self::$uid . "'";
    }

    $mysql->query($sql);

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
      echo json_encode($result);
      exit();
    }
    else
    {
      $result = array('response' => 'success', 'text' => 'Post updated' , 'type' => 'success');
      echo json_encode($result);
      exit();
    }
  }

  private static function smail()
  {

    if(isset($_POST['postId']))
    {
      $pid = $_POST['postId'];
    }
    else
    {
      $result = array('response' => 'error', 'text' => 'Error occurred.');
      echo json_encode($result);
      exit();
    }

    $app   = new Factory;
    $mysql = $app->getDBO();

    $sql  = "SELECT * from posts po INNER JOIN users u ON po.uid = u.id WHERE pid = $pid ";

    $result = $mysql->query($sql);

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => $pid , 'sqlstate' => $row['name']);
      echo json_encode($result);
      exit();
    }

    $rows  = $result->fetch_assoc();

    $profilelink = 'http://' . $_SERVER['HTTP_HOST'] . BASE_URL . 'user/view/u/'. self::$username;
    $postlink    = 'http://' . $_SERVER['HTTP_HOST'] . BASE_URL . 'post/page/pid/'. $pid;

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'iitpcabshare@gmail.com';            // SMTP username
    $mail->Password = 'iitpcabshare@123';                  // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('noreply@gmail.com', 'iitpConnect');
    $mail->addAddress($rows['email'], $rows['name']);                     // Add a recipient
//     $mail->addAddress('anurag@blogme.co');                // Name is optional

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML

    if(self::$actiontype == 'buy') {

      $title =  $rows['title'];
      $mail->Subject = 'Someone want\'s to buy your item.[ ' . $title .' ]';

      $name = $rows['name'];

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
      <span class="il">iitpConnect</span> Buy</h1>
      </td>
      </tr>
      <tr>
      <td valign="top" align="center" style="text-align:center;padding:15px 0px 60px 0px">
      <center>
      <table role="presentation" align="center" cellspacing="0" cellpadding="0" border="0"  style="text-align:center">
      <tbody>
      <tr>
      <td style="border-radius:50px;background:#26a4d3;text-align:center">
      <a href="'. $postlink  . '" style="background:#26a4d3;border:15px solid #26a4d3;sans-serif;font-size:14px;line-height:1.1;text-align:center;text-decoration:none;display:block;border-radius:50px;font-weight:bold" ><span style="color:#ffffff">&nbsp;&nbsp;&nbsp;&nbsp;View item&nbsp;&nbsp;
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
      User
      <a href="' . $profilelink .  ' " target="_blank" >'. self::$username .'</a>.<br>
      want\'s to buy your item. This <a href="'. $postlink .'"
      style="text-decoration:none;border-style:none;border:0;padding:0;margin:0;font-size:12px;Helvetica,Arial,sans-serif;color:#ffffff;text-decoration:none;border-radius:4px;padding:8px 17px; border:1px solid #1da1f2;display:inline-block;font-weight:bold;background-color:skyblue;color:black;"
      target="_blank">item.</a>
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

    } else if(self::$actiontype == 'claim') {

      $title =  $rows['title'];
      $mail->Subject = 'It\'s my lost item.[ ' . $title .' ]';
      $name = $rows['name'];

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
      <span class="il">iitpConnect</span> Claim.</h1>
      </td>
      </tr>
      <tr>
      <td valign="top" align="center" style="text-align:center;padding:15px 0px 60px 0px">
      <center>
      <table role="presentation" align="center" cellspacing="0" cellpadding="0" border="0"  style="text-align:center">
      <tbody>
      <tr>
      <td style="border-radius:50px;background:#26a4d3;text-align:center">
      <a href="'. $postlink  . '" style="background:#26a4d3;border:15px solid #26a4d3;sans-serif;font-size:14px;line-height:1.1;text-align:center;text-decoration:none;display:block;border-radius:50px;font-weight:bold" ><span style="color:#ffffff">&nbsp;&nbsp;&nbsp;&nbsp;View item&nbsp;&nbsp;
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
      User
      <a href="' . $profilelink .  ' " target="_blank" >'. self::$username .'</a>.<br>
      saying it\'s my lost item. This <a href="'. $postlink .'"
      style="text-decoration:none;border-style:none;border:0;padding:0;margin:0;font-size:12px;Helvetica,Arial,sans-serif;color:#ffffff;text-decoration:none;border-radius:4px;padding:8px 17px; border:1px solid #1da1f2;display:inline-block;font-weight:bold;background-color:skyblue;color:black;"
      target="_blank">item.</a>
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

    } else if(self::$actiontype == 'found') {

      $title =  $rows['title'];
      $mail->Subject = 'Someone found your lost item. [ ' . $title .' ]';

      $name = $rows['name'];

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
      <span class="il">iitpConnect</span> Found.</h1>
      </td>
      </tr>
      <tr>
      <td valign="top" align="center" style="text-align:center;padding:15px 0px 60px 0px">
      <center>
      <table role="presentation" align="center" cellspacing="0" cellpadding="0" border="0"  style="text-align:center">
      <tbody>
      <tr>
      <td style="border-radius:50px;background:#26a4d3;text-align:center">
      <a href="'. $postlink  . '" style="background:#26a4d3;border:15px solid #26a4d3;sans-serif;font-size:14px;line-height:1.1;text-align:center;text-decoration:none;display:block;border-radius:50px;font-weight:bold" ><span style="color:#ffffff">&nbsp;&nbsp;&nbsp;&nbsp;View item&nbsp;&nbsp;
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
      User
      <a href="' . $profilelink .  ' " target="_blank" >'. self::$username .'</a>.<br>
      found your lost item. This <a href="'. $postlink .'"
      style="text-decoration:none;border-style:none;border:0;padding:0;margin:0;font-size:12px;Helvetica,Arial,sans-serif;color:#ffffff;text-decoration:none;border-radius:4px;padding:8px 17px; border:1px solid #1da1f2;display:inline-block;font-weight:bold;background-color:skyblue;color:black;"
      target="_blank">item.</a>
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
    }

    $mail->AltBody = 'Thanks';

    if($mail->send())
    {
      $result = array('response' => 'success', 'text' => 'Done.');
      echo json_encode($result);

      return true;
    }
    else
    {
      $result = array('response' => 'error', 'text' => 'Failed to send mail.');
      echo json_encode($result);

      return false;
    }

  }
}
