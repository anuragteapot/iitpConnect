<?php
/**
* @package    iitpConnect.Site
*
* @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
* @license    GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_EXEC') or die;

class CabController extends BaseController
{
  public static $calenderID = NULL;
  public static $location = NULL;
  public static $isAllDay = NULL;
  public static $state = NULL;
  public static $useCreationPopup = NULL;
  public static $title = NULL;
  public static $rawClass = NULL;
  public static $end = NULL;
  public static $start = NULL;
  public static $uid = NULL;
  public static $cabid = NULL;
  public static $fullDate =  NULL;

  public function __construct()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    self::$calenderID = mysqli_real_escape_string($mysql, $_POST['calendarId']);
    self::$isAllDay = mysqli_real_escape_string($mysql, $_POST['isAllDay']);
    self::$state = mysqli_real_escape_string($mysql, $_POST['state']);
    self::$useCreationPopup = mysqli_real_escape_string($mysql, $_POST['useDetailPopup']);
    self::$title = mysqli_real_escape_string($mysql, $_POST['title']);
    self::$rawClass = mysqli_real_escape_string($mysql, $_POST['rawClass']);
    self::$end = mysqli_real_escape_string($mysql, $_POST['end']);
    self::$start = mysqli_real_escape_string($mysql, $_POST['start']);
    self::$uid = mysqli_real_escape_string($mysql, $_POST['uid']);
    self::$location = mysqli_real_escape_string($mysql, $_POST['location']);
    self::$fullDate = mysqli_real_escape_string($mysql, $_POST['fullDate']);

    $app->disconnect();
  }

  public function add()
  {
    $app = new Factory;
    $mysql = $app->getDBO();
    $session = new Session;

    if(!$session->get('uid') == self::$uid)
    {
      $result = array('response' => 'error', 'text' => 'Error on processing request.');
      echo json_encode($result);
      exit();
    }

    $sql = "insert into cabShare(calendarid, uid, title, location, isAllDay, endDate, startDate, state, useCreationPopup, rawClass, fullDate)
    values ('". self::$calenderID ."','". self::$uid ."','". self::$title ."','". self::$location ."',". self::$isAllDay .",'". self::$end ."',
    '". self::$start ."','". self::$state ."','". self::$useCreationPopup ."','". self::$rawClass ."','". self::$fullDate ."')";

    $mysql->query($sql);

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
      echo json_encode($result);
      exit();
    }
    else
    {
      $id = self::$uid;
      $sql = "SELECT id,name,username,phonenumber,email,address,institute from users where id = $id";

      $res = $mysql->query($sql);

      $rows = array();
      while($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
      }

      $sql = "SELECT LAST_INSERT_ID() AS id";
      $res = $mysql->query($sql);
      $cabid = mysqli_fetch_assoc($res);

      // Continue on work in backend.
      // https://stackoverflow.com/questions/15273570/continue-processing-php-after-sending-http-response

      ignore_user_abort(true);
      set_time_limit(0);
      ob_start();
      // Send response.
      $result = array('response' => 'success', 'text' => 'Posted' , 'type' => 'success', 'data' => $rows, 'cabid' => $cabid);
      echo json_encode($result);
      header('Connection: close');
      header('Content-Length: '.ob_get_length());
      ob_end_flush();
      ob_flush();
      flush();

      $this->notify();

      exit();
    }
  }


  public function update()
  {
    $app = new Factory;
    $mysql = $app->getDBO();
    $session = new Session;

    $cid = mysqli_real_escape_string($mysql, $_POST['cabid']);
    $id = self::$uid;

    if(!$session->get('uid') == self::$uid)
    {
      $result = array('response' => 'error', 'text' => 'Error on processing request.');
      echo json_encode($result);
      exit();
    }

    $sql = "update cabShare set calendarid='". self::$calenderID ."',title='". self::$title . "',location='". self::$location . "', isAllDay=". self::$isAllDay .",endDate='". self::$end . "',
    startDate='". self::$start . "',rawClass='". self::$rawClass . "',state='". self::$state . "' WHERE uid = $id AND cabid = $cid";

    $mysql->query($sql);

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
      echo json_encode($result);
      exit();
    }
    else
    {
      $result = array('response' => 'success', 'text' => 'updated' , 'type' => 'success');
      echo json_encode($result);
      exit();
    }
  }

  public function get()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    $sql = "SELECT us.*, ca.* from cabShare ca INNER JOIN users us ON us.id = ca.uid";

    $res = $mysql->query($sql);

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
      echo json_encode($result);
      exit();
    }
    else
    {
      $rows = array();
      while($row = mysqli_fetch_assoc($res))
      {
        $rows[] = $row;
      }

      $result = array('response' => 'success', 'text' => 'Posted' , 'type' => 'success', 'data' => $rows);
      echo json_encode($result);
      exit();
    }
  }

  public function delete()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    $cid = mysqli_real_escape_string($mysql, $_POST['cabid']);
    $id = self::$uid;

    $sql = "DELETE FROM cabShare WHERE cabid = $cid AND uid = $id";

    $res = $mysql->query($sql);

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
      echo json_encode($result);
      exit();
    }
    else
    {
      $result = array('response' => 'success', 'text' => 'Deleted' , 'type' => 'success');
      echo json_encode($result);
      exit();
    }
  }

  private function notify()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    $sql = "SELECT us.*, ca.* from cabShare ca INNER JOIN users us ON us.id = ca.uid where fullDate = '". self::$fullDate . "' GROUP BY email";

    $res = $mysql->query($sql);

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
      echo json_encode($result);
      exit();
    }
    else
    {
      while($row = mysqli_fetch_assoc($res))
      {
        if($row['uid'] != self::$uid)
        {
          $this->notifyOther($row['name'], $row['email']);
        }
      }
    }
  }

  private function notifyOther($name, $email)
  {
    $link = 'http://' . $_SERVER['HTTP_HOST'] . BASE_URL . 'post/cab/';

    $mail = new PHPMailer(true);                          // Passing `true` enables exceptions

    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'iitpconnect@gmail.com';            // SMTP username
    $mail->Password = 'anurag@iitpconnect';               // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('noreply@gmail.com', 'iitpConnect');
    $mail->addAddress($email, $name);                     // Add a recipient

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Someone is going on your planned date.';
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
    <span class="il">iitpConnect</span> Cab Share</h1>
    </td>
    </tr>
    <tr>
    <td valign="top" align="center" style="text-align:center;padding:15px 0px 60px 0px">
    <center>
    <table role="presentation" align="center" cellspacing="0" cellpadding="0" border="0"  style="text-align:center">
    <tbody>
    <tr>
    <td style="border-radius:50px;background:#26a4d3;text-align:center">
    <a href="'. $link  . '" style="background:#26a4d3;border:15px solid #26a4d3;sans-serif;font-size:14px;line-height:1.1;text-align:center;text-decoration:none;display:block;border-radius:50px;font-weight:bold" ><span style="color:#ffffff">&nbsp;&nbsp;&nbsp;Checkout Shareable Cab&nbsp;&nbsp;
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
    Someone is going on your planned date. Checkout Shareable Cab
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
      $mail->ClearAllRecipients();
      return true;
    }
  }
}
