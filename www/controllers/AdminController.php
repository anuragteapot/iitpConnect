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
    function __construct()
    {
        $session = new Session;

        $request = new Request();

        $id = $request->get('userId');

        if (!User::isLoggedIn(true) || $session->get('uid') == $id) {
            $result = array('response' => 'error', 'text' => 'Not valid request');
            echo json_encode($result);
            exit();
        }
    }

    public function toggelAdmin()
    {
        $app = new Factory;
        $mysql = $app->getDBO();


        $request = new Request();

        $id = $request->get('userId');
        $admin = $request->get('admin');
        if ($admin)
            $admin = 0;
        else
            $admin  = 1;

        $sql = "update users set admin= " . $admin . " where id = " . $id . "";

        $mysql->query($sql);

        if ($mysql->connect_error) {
            $result = array('response' => 'error', 'text' => 'Error occurred.', 'sqlstate' => $mysql->sqlstate);
            echo json_encode($result);
            exit();
        } else {
            $result = array('response' => 'success', 'text' => 'Reset link send.', 'type' => 'success', 'user' => $id);
            echo json_encode($result);
            exit();
        }
    }
}
