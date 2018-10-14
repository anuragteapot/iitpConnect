<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 class LoginController extends BaseController
 {
   public function UserLogin()
   {
     $result = array('response' => 'error', 'text' => 'Request success');
     echo json_encode($result);
     exit;
   }

   
 }
