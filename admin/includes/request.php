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

    if((isset($_POST['task']) && isset($_POST['submit'])))
    {
      $task = explode('.', $_POST['task']);
    }
    else if((isset($_REQUEST['task']) && isset($_REQUEST['submit'])))
    {
      $task = explode('.', $_REQUEST['task']);
    }

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

  public function get($data)
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    if(isset($_POST[$data]))
    {
      return mysqli_real_escape_string($mysql, $_POST[$data]);
    }
    else
    {
      return NULL;
    }
  }
}

if((isset($_POST['task']) && isset($_POST['submit'])) || (isset($_REQUEST['task']) && isset($_REQUEST['submit'])))
{
  $event = new Request();
  $event->fireEvent();
  exit;
}
