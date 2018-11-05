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
        $mail->Body    = '<html><body> <h1> Wellcome '. $username .'</h1><br> Thank you being a part of iitpConnect.
                          <br> Enjoy our application feature. <a href="'. $link .'" class="m_-1672600131527813205bulletproof-btn-2"
                   style="text-decoration:none;border-style:none;border:0;padding:0;margin:0;font-size:12px;Helvetica,Arial,sans-serif;color:#ffffff;text-decoration:none;border-radius:4px;padding:8px 17px; border:1px solid #1da1f2;display:inline-block;font-weight:bold"
                   target="_blank">Start Using</a>

                   <br> Thanks <br> iitpConnect team</body></html>';

        $mail->AltBody = 'Thanks';

        if($mail->send())
        {
          return true;
        }
  }
}
