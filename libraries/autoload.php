<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_EXEC') or die;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

spl_autoload_register(function ($class_name) {

    if(file_exists(PATH_LIBRARIES . '/classes/'.$class_name.'.php'))
    {
      require_once PATH_LIBRARIES . '/classes/'.$class_name.'.php';
    }
    else if(file_exists(PATH_CONTROLLERS . '/'.$class_name.'.php'))
    {
      require_once PATH_CONTROLLERS . '/'.$class_name.'.php';
    }
});
