<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 class Request
 {
   public function fireEvent()
   {
     $task = array();
     $task = explode('.',$_POST['task']);

     $action = new $task[0];

     $fireEvent = $task[1];
     $action->$fireEvent();
   }

   public static function post($data)
   {
     $file = file_get_contents("php://input");
     $file = explode("&", $file);
     for ($i = 0; $i < count($file); $i++) {
       $sub = explode('=', $file[$i]);
       if ($sub[0] == $data) {
         return utf8_decode(urldecode($sub[1]));
       }
     }
   }
 }

 if(isset($_POST['task']))
 {
   $event = new Request();
   $event->fireEvent();
 }
