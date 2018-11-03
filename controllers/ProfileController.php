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

      $sql = "update users set name='". self::$name ."',location='". self::$location . "',institute='". self::$institute . "', phonenumber='". self::$phonenumber . "'
      where username = '" . self::$username ."' AND email = '" . self::$useremail ."'";
    }
    else
    {

      $sql = "update users set name='". self::$name ."', password='". sha1('1601' . self::$password . 'iitp') ."', location='". self::$location . "',
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
        $mail->Username = 'iitpconnect@gmail.com';            // SMTP username
        $mail->Password = 'anurag@iitpconnect';                  // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('noreply@gmail.com', 'iitpConnect');
        $mail->addAddress($rows['email'], $rows['name']);                     // Add a recipient
        $mail->addAddress('anurag@blogme.co');                // Name is optional

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML

        if(self::$actiontype == 'buy') {

          $title =  $rows['title'];
          $mail->Subject = 'Someone want\'s to buy your item.[ ' . $title .' ]';
          $mail->Body    = '<html><body> <h1> Hi '. $rows['name'] .'</h1> User

          <a href="'. $profilelink .'"
            style="text-decoration:none;border-style:none;border:0;padding:0;margin:0;font-size:12px;Helvetica,Arial,sans-serif;color:#ffffff;text-decoration:none;border-radius:4px;padding:8px 17px; border:1px solid #1da1f2;display:inline-block;font-weight:bold;background-color:skyblue;color:black;"
          target="_blank">'. self::$username .'</a>

          want\'s to buy your item. See <a href="'. $postlink .'"
          style="text-decoration:none;border-style:none;border:0;padding:0;margin:0;font-size:12px;Helvetica,Arial,sans-serif;color:#ffffff;text-decoration:none;border-radius:4px;padding:8px 17px; border:1px solid #1da1f2;display:inline-block;font-weight:bold;background-color:skyblue;color:black;"
          target="_blank">Post</a>
          <br>

          Thanks <br> iitpConnect team</body></html>';

        } else if(self::$actiontype == 'claim') {

          $title =  $rows['title'];
          $mail->Subject = 'It\'s my lost item.[ ' . $title .' ]';
          $mail->Body    = '<html><body> <h1> Hi '. $rows['name'] .'</h1> User

          <a href="'. $profilelink.'"
         style="text-decoration:none;border-style:none;border:0;padding:0;margin:0;font-size:12px;Helvetica,Arial,sans-serif;color:#ffffff;text-decoration:none;border-radius:4px;padding:8px 17px; border:1px solid #1da1f2;display:inline-block;font-weight:bold;background-color:skyblue;color:black;"
         target="_blank">'. self::$username .'</a>

          say its my lost item. See <a href="'. $postlink .'"
          style="text-decoration:none;border-style:none;border:0;padding:0;margin:0;font-size:12px;Helvetica,Arial,sans-serif;color:#ffffff;text-decoration:none;border-radius:4px;padding:8px 17px; border:1px solid #1da1f2;display:inline-block;font-weight:bold;background-color:skyblue;color:black;"
            target="_blank">Post</a>
          <br>

         Thanks <br> iitpConnect team</body></html>';

        } else if(self::$actiontype == 'found') {

          $title =  $rows['title'];
          $mail->Subject = 'Someone found your lost item. [ ' . $title .' ]';
          $mail->Body    = '<html><body> <h1> Hi '. $rows['name'] .'</h1> User

          <a href="'. $profilelink .'"
         style="text-decoration:none;border-style:none;border:0;padding:0;margin:0;font-size:12px;Helvetica,Arial,sans-serif;color:#ffffff;text-decoration:none;border-radius:4px;padding:8px 17px; border:1px solid #1da1f2;display:inline-block;font-weight:bold;background-color:skyblue;color:black;"
         target="_blank">'. self::$username .'</a>

          found your lost item. See <a href="'. $postlink .'"
          style="text-decoration:none;border-style:none;border:0;padding:0;margin:0;font-size:12px;Helvetica,Arial,sans-serif;color:#ffffff;text-decoration:none;border-radius:4px;padding:8px 17px; border:1px solid #1da1f2;display:inline-block;font-weight:bold;background-color:skyblue;color:black;"
            target="_blank">Post</a>
          <br>

         Thanks <br> iitpConnect team</body></html>';
        }

        $mail->AltBody = 'Thanks';

        if($mail->send())
        {
          $result = array('response' => 'success', 'text' => 'Done.');
          echo json_encode($result);

          return true;
        }


  }
}
