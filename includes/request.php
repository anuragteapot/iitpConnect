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
 }

 if(isset($_POST['task']))
 {
   $event = new Request();
   $event->fireEvent();
 }
