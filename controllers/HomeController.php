<?php
/**
* @package    iitpConnect.Site
*
* @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
* @license    GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_EXEC') or die;

class HomeController extends BaseController
{
    private static $name = NULL;
    private static $email = NULL;
    private static $message = NULL;
    private static $token = NULL;

    public function __construct()
    {
        $app = new Factory;
        $mysql = $app->getDBO();

        $request = new Request();
        
        self::$name = $request->get('name');
        self::$email = $request->get('email');
        self::$message = $request->get('message');

    }

    public static function sendFeedback()
    {
        $db = new Factory;
        $mysql = $db->getDBO();
        
        $name = self::$name;
        $email = self::$email;
        $message = self::$message;
        
        $sql = "INSERT INTO feedback(name,email,message) VALUES ('$name','$email','$message')";
        $mysql->query($sql);
    
        if($mysql->connect_error)
        {
            $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
            echo json_encode($result);
            exit();
        }
        else
        {
            $result = array('response' => 'success', 'text' => 'Feedback Sent Successfully.' , 'type' => 'success', 'user' => self::$name);
            echo json_encode($result);
            exit();
        }
    }
}
