<?php
/**
* @package    iitpConnect.Site
*
* @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
* @license    GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_EXEC') or die;

class AdminController extends BaseController
{
    public function toggelAdmin(){
        $result = array('response' => 'error', 'text' =>'Email is not valid.', 'message' => 'Done');
        echo json_encode($result);
        exit();
    }

}
