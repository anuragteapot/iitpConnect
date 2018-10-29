<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 defined('_EXEC') or die;

 class Request
 {
   public $headers;

   public function __construct()
   {
     $this->headers = new \stdClass;

     foreach (getallheaders() as $name => $value)
     {
         $this->headers->$name = $value;
     }
   }

   public function fireEvent()
   {
     if(!$this->isValid())
     {
       $result = array('response' => 'error', 'text' => 'Not a valid request.');
       echo json_encode($result);
       exit();
     }

     $task = array();
     $task = explode('.', $_POST['task']);

     $action = new $task[0];

     $fireEvent = $task[1];
     $action->$fireEvent();
   }

   private function isValid()
   {
     $config = new Config;

     $key = $this->headers->CSRFToken;

     if($config->secret == $key)
     {
       return true;
     }
     else
     {
       return false;
     }
   }
 }

 if(isset($_POST['task']) && isset($_POST['submit']))
 {
   $event = new Request();
   $event->fireEvent();
   exit;
 }
