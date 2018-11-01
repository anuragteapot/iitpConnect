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

    if(isset($_POST['name']))
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

  private static function updatePost()
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

    $sql = "UPDATE posts SET message = '" . self::$message. "', title = '". self::$postTitle ."', type = '". self::$postType ."' WHERE pid = '" . $pid ."' AND uid = '". self::$uid . "'";

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
}
