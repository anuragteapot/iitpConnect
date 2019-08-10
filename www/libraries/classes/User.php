<?php

/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_EXEC') or die;

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
  { }

  public static function getInstance($username, $password)
  {
    User::getUser($username, $password);
  }

  public static function getUser($username, $password = '')
  {
    // if (!preg_match('/^[a-zA-Z0-9]*_?[a-zA-Z0-9]*$/', $username)) {
    //   return false;
    // }

    $db = new Factory();
    $mysql = $db->getDBO();

    if ($password == '') {
      $sql = "SELECT * FROM users where username = '" . $username . "'";
    } else {
      $sql = "SELECT * FROM users where username = '" . $username . "' AND password = '" . $password . "'";
    }

    $result = $mysql->query($sql);

    if ($mysql->connect_error) {
      $result = array('response' => 'error', 'text' => 'Server error.', 'mysql' => $mysql->connect_error);
      echo json_encode($result);
      return false;
    }

    if ($result->num_rows == 1 && $password == '') {
      return $result->fetch_assoc();
    }

    if ($result->num_rows == 1) {
      self::$validUser = true;
      while ($row = $result->fetch_assoc()) {
        self::$id = $row['id'];
        self::$name = $row['name'];
        self::$username = $row['username'];
        self::$useremail = $row['email'];
        self::$block = $row['block'];
        self::$activation = $row['activation'];
        self::$registerDate = $row['registerDate'];
      }

      $db->disconnect();
    } else {
      $db->disconnect();
      return false;
    }
  }

  public static function checkUser($value, $return = false)
  {
    $db = new Factory;
    $mysql = $db->getDBO();

    $sql = "SELECT * FROM users where username = '" . $value . "' OR email = '" . $value . "'";

    $result = $mysql->query($sql);

    if ($mysql->connect_error) {
      throw new \Exception("Error Processing Request", $mysql->connect_error);
      return false;
    }

    if ($result->num_rows > 0) {
      if ($return) {
        return $result->fetch_assoc();
      }

      $db->disconnect();
      return true;
    } else {
      $db->disconnect();
      return false;
    }
  }

  public static function isAdmin($uid)
  {
    $db = new Factory;
    $mysql = $db->getDBO();

    $sql = "SELECT admin FROM users WHERE id=$uid";
    $res = $mysql->query($sql);

    if (json_encode($res) != 'false') {
      $res = $res->fetch_assoc();
      if ($res['admin']) {
        return true;
      }
    }
    return false;
  }

  public static function isLoggedIn($admin = false)
  {

    $db = new Factory;
    $mysql = $db->getDBO();

    $session = new Session;
    $uid = $session->get('uid');
    $token = $session->get('token');
    $address = $session->get('ipaddress');
    $username = $session->get('username');
    $state = $session->get('iitpConnect_user_state');

    if ($admin && !self::isAdmin($uid)) {
      return false;
    }

    $sql = "SELECT token,isLoggedin FROM user_keys WHERE uid=$uid AND token='$token'";
    $res = $mysql->query($sql);
    if (json_encode($res) != 'false') {
      $res = $res->fetch_assoc();
    }

    if ($token != NULL && $username != NULL && $state == 'logged_in' && $token = $res['token'] && $res['isLoggedin'] == 1) {
      return true;
    } else {
      return false;
    }
  }

  public static function isOnline($uid, $token, $address)
  {
    $db = new Factory;
    $mysql = $db->getDBO();

    $sql = "INSERT INTO user_keys (uid,token,isLoggedin,ip) values ($uid,'$token',1,'$address')";

    $result = $mysql->query($sql);

    if ($mysql->connect_error) {
      throw new \Exception("Error Processing Request", $mysql->connect_error);
      return false;
    }

    $db->disconnect();
    return true;
  }

  public static function goOffline()
  {
    $db = new Factory;
    $mysql = $db->getDBO();
    $session = new Session;
    $uid = $session->get('uid');
    $token = $session->get('token');
    $address = $session->get('ipaddress');

    $sql = "SELECT token FROM user_keys where uid=$uid and isLoggedin=1 AND token='$token'";
    $rslt = $mysql->query($sql);
    $rslt = $rslt->fetch_assoc();

    if ($session->get('token') == $rslt['token']) {
      $sql = "UPDATE user_keys SET isLoggedin=0 WHERE uid = $uid and isLoggedin=1 and token='$token'";
      $mysql->query($sql);

      if ($mysql->connect_error) {
        throw new \Exception("Error Processing Request", $mysql->connect_error);
        return false;
      }

      $db->disconnect();
      return true;
    }

    return true;
  }
}
