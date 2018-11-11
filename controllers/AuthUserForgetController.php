<?php
/**
* @package    iitpConnect.Site
*
* @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
* @license    GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_EXEC') or die;

class AuthUserForgetController extends BaseController
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
      $session = new Session;
      $session->clear('resetusername');
      $session->clear('resetemail');

      $msg = 'Something goes wrong with link.';

      header('Location: ' . BASE_URL . $_GET['url'] . '/AuthUser/e/' . $msg);
      exit();
    }

    $row = $res->fetch_assoc();

    $otpkey = $row['otpKey'];

    $key = Defuse\Crypto\Key::LoadFromAsciiSafeString($otpkey);

    $verifyString = Defuse\Crypto\Crypto::decrypt($expToken[0], $key);

    $expverifyString = explode('.', $verifyString);

    $config = new Config;

    if($expverifyString[0] == $expuname[0] && $config->secret == $expToken[2])
    {
      $session = new Session;
      $options = array();

      $options['resetusername'] = $expuname[0];
      $options['resetemail'] = self::$email;

      $session->set($options);

      header('Location: ' . BASE_URL . $_GET['url'] . '/AuthUser/');
      exit();
    }
    else
    {
      $msg = 'Something goes wrong with link.';

      $session = new Session;
      $session->clear('resetusername');
      $session->clear('resetemail');

      header('Location: ' . BASE_URL . $_GET['url'] . '/AuthUser/e/' . $msg);
      exit();
    }

    $app->disconnect();
  }
}
