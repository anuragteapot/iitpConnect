<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

class User
{
  public static $name = NULL;
  public static $username = NULL;
  public static $useremail = NULL;
  public static $id = NULL;
  public static $block = NULL;
  public static $activation = NULL;
  public static $registerDate = NULL;
  public static $validUser = false;

  function __construct()
  {

  }

  public static function getInstance($username, $password)
  {
    User::getUser($username, $password);
  }

  public static function getUser($username, $password = '')
  {
    if(!preg_match('/^[a-zA-Z0-9]*_?[a-zA-Z0-9]*$/', $username))
    {
      return false;
    }

    $db = new Factory();
    $mysql = $db->getDBO();

    if($password == '')
    {
      $sql = "SELECT * FROM users where username = '" . $username ."'";
    }
    else
    {
      $sql = "SELECT * FROM users where username = '" . $username ."' AND password = '" .$password ."'";
    }

    $result = $mysql->query($sql);

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => 'Server error.','mysql' => $mysql->connect_error);
      echo json_encode($result);
      return false;
    }

    if($result->num_rows == 1 && $password == '')
    {
      return $result->fetch_assoc();
    }

    if($result->num_rows == 1)
    {
      self::$validUser = true;
      while ($row = $result->fetch_assoc())
      {
        self::$id = $row['id'];
        self::$name = $row['name'];
        self::$username = $row['username'];
        self::$useremail = $row['email'];
        self::$block = $row['block'];
        self::$activation = $row['activation'];
        self::$registerDate = $row['registerDate'];
      }
    }
    else
    {
      return false;
    }
  }

  public static function isLoggedIn()
  {
    $session = new Session;
    $status = $session->get('token');
    $username = $session->get('username');

    if ($status != NULL && $username != NULL)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
}
