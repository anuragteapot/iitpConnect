<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
 
function __autoload($class_name) {

    if(file_exists(PATH_LIBRARIES . '/classes/'.$class_name.'.php'))
    {
      require_once PATH_LIBRARIES . '/classes/'.$class_name.'.php';
    }
    else if(file_exists(PATH_CONTROLLERS . '/'.$class_name.'.php'))
    {
      require_once PATH_CONTROLLERS . '/'.$class_name.'.php';
    }
}
