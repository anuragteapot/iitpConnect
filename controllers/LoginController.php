<?php
/**
* @package    iitpConnect.Site
*
* @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
* @license    GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_EXEC') or die;

class LoginController extends BaseController
{
  private static $username = NULL;
  private static $password = NULL;
  private static $token = NULL;
  private static $address = NULL;

  public function __construct()
  {
    $request = new Request;

    if($request->get('token') && !isset($_SESSION['token']))
    {
      self::$username = $request->get('username');
      self::$password = sha1('1601' . $request->get('userpassword') . 'iitp');
      self::$token = sha1(self::generateRandom());
      self::$address = $_SERVER['SERVER_ADDR'];
    }
  }

  public function Auth()
  {
    User::getInstance(self::$username, self::$password);

    if(User::$validUser)
    {
      if(!User::$activation)
      {
        $result = array('response' => 'error', 'text' => 'Your account is not activated.', 'message' => User::$username);
        echo json_encode($result);
        exit();
      }

      $session = new Session;
      $options = array();

      $options['username'] = self::$username;
      $options['name'] = User::$name;
      $options['uid'] = User::$id;
      $options['ipaddress'] = self::$address;
      $options['token'] = self::$token;
      $options['email'] = User::$useremail;
      $options['iitpConnect_user_state'] = 'logged_in';

      $session->set($options);
      $result = array('response' => 'success', 'text' => User::$username, 'message' => 'login successfull');
      echo json_encode($result);
      exit();
    }
    else
    {
      $result = array('response' => 'error', 'text' => 'Wrong username or password.');
      echo json_encode($result);
      exit();
    }

  }

  private static function generateRandom($length = 64)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++)
    {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
  }

  public function UserLogin()
  {
    if(!User::isLoggedIn())
    {
      $this->Auth();
    }
    else
    {
      $result = array('response' => 'warning', 'text' => 'Something going wrong. Try to clear your cache.');
      echo json_encode($result);
      exit();
    }
  }

  public function UserLogout()
  {
    $session = new Session;
    $session->destroy();
    $result = array('response' => 'success', 'text' => 'Logout successfull');
    echo json_encode($result);
    exit();
  }
}
