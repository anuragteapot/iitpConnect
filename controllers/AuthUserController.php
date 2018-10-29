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

      header('Location: ' . BASE_URL . 'register/AuthUser/e/' . $msg);
      exit();
    }

    $row = $res->fetch_assoc();

    if($row['activation'] == 1)
    {
      $msg = 'Your account is already Activated.';

      header('Location: ' . BASE_URL . 'register/AuthUser/m/' . $msg);
      exit();
    }

    $key = Defuse\Crypto\Key::LoadFromAsciiSafeString($row['otpKey']);

    $verifyString = Defuse\Crypto\Crypto::decrypt($expToken[0], $key);

    $expverifyString = explode('.', $verifyString);

    $config = new Config;

    if($expverifyString[0] == $expuname[0] && $expverifyString[1] . '.' .$expverifyString[2] == self::$email && $config->secret == $expToken[2])
    {
      $this->activate($expuname[0], $expverifyString[1] . '.' .$expverifyString[2]);
    }
    else
    {
      $msg = 'Something goes wrong with link.';

      header('Location: ' . BASE_URL . 'register/AuthUser/e/' . $msg);
      exit();
    }

    $app->disconnect();
  }

  protected function activate($username, $email)
  {
    $app   = new Factory;
    $mysql = $app->getDBO();

    $sql = "update users set activation='" . 1 . "' where username = '" . $username ."' AND email = '" . $email. "'";

    $res = $mysql->query($sql);

    if($res)
    {
      $msg = 'Your Account is Activated.';

      header('Location: ' . BASE_URL . 'register/AuthUser/m/' . $msg);
      exit();
    }
    else
    {
      $msg = 'Something goes wrong with link.';

      header('Location: ' . BASE_URL . 'register/AuthUser/e/' . $msg);
      exit();
    }

    $app->disconnect();
  }
}
