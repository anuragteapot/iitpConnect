<?php
/**
* @package    iitpConnect.Site
*
* @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
* @license    GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_EXEC') or die;

class Factory extends Database
{
  /**
  *
  * @param   string   $password  The plaintext password to check.
  *
  * @return  string  hash password
  *
  */

  public static function hashPassword($password, $cycpt = false)
  {
    if($cycpt)
    {
      $password  = '1601' . $password . 'iitp';
    }

    return password_hash($password, PASSWORD_BCRYPT);
  }

  /**
  * Formats a password using the current encryption. If the user ID is given
  * and the hash does not fit the current hashing algorithm, it automatically
  * updates the hash.
  *
  * @param   string   $password  The plaintext password to check.
  * @param   string   $hash      The hash to verify against.
  *
  * @return bool
  */

  public static function verifyPassword($password, $hash)
  {
    return password_verify($password, $hash);
  }
}
