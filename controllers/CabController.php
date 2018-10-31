<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_EXEC') or die;

class CabController extends BaseController
{
  public static $calenderID = NULL;
  public static $location = NULL;
  public static $isAllDay = NULL;
  public static $state = NULL;
  public static $useCreationPopup = NULL;
  public static $title = NULL;
  public static $rawClass = NULL;
  public static $end = NULL;
  public static $start = NULL;
  public static $uid = NULL;
  public static $cabid = NULL;

  public function __construct()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    self::$calenderID = mysqli_real_escape_string($mysql, $_POST['calendarId']);
    self::$isAllDay = mysqli_real_escape_string($mysql, $_POST['isAllDay']);
    self::$state = mysqli_real_escape_string($mysql, $_POST['state']);
    self::$useCreationPopup = mysqli_real_escape_string($mysql, $_POST['useDetailPopup']);
    self::$title = mysqli_real_escape_string($mysql, $_POST['title']);
    self::$rawClass = mysqli_real_escape_string($mysql, $_POST['rawClass']);
    self::$end = mysqli_real_escape_string($mysql, $_POST['end']);
    self::$start = mysqli_real_escape_string($mysql, $_POST['start']);
    self::$uid = mysqli_real_escape_string($mysql, $_POST['uid']);
    self::$location = mysqli_real_escape_string($mysql, $_POST['location']);

    $app->disconnect();
  }

  public function add()
  {
    $app = new Factory;
    $mysql = $app->getDBO();
    $session = new Session;

    if(!$session->get('uid') == self::$uid)
    {
      $result = array('response' => 'error', 'text' => 'Error on processing request.');
      echo json_encode($result);
      exit();
    }

    if($isAllDay)
    {
      $isAllDay =  1;
    }
    else
    {
      $isAllDay =  0;
    }

    $sql = "insert into cabShare(calendarid, uid, title, location, isAllDay, endDate, startDate, state, useCreationPopup, rawClass)
          values ('". self::$calenderID ."','". self::$uid ."','". self::$title ."','". self::$location ."','". self::$isAllDay ."','". self::$end ."',
          '". self::$start ."','". self::$state ."','". self::$useCreationPopup ."','". self::$rawClass ."')";

    $mysql->query($sql);

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
      echo json_encode($result);
      exit();
    }
    else
    {
      $id = self::$uid;
      $sql = "SELECT id,name,username,phonenumber,email,location,institute from users where id = $id";

      $res = $mysql->query($sql);

      $rows = array();
      while($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
      }

      $sql = "SELECT LAST_INSERT_ID() AS id";
      $res = $mysql->query($sql);
      $cabid = mysqli_fetch_assoc($res);

      $result = array('response' => 'success', 'text' => 'Posted' , 'type' => 'success', 'data' => $rows, 'cabid' => $cabid);
      echo json_encode($result);
      exit();
    }
  }


  public function update()
  {
    $app = new Factory;
    $mysql = $app->getDBO();
    $session = new Session;

    if(!$session->get('uid') == self::$uid)
    {
      $result = array('response' => 'error', 'text' => 'Error on processing request.');
      echo json_encode($result);
      exit();
    }

    if($isAllDay)
    {
      $isAllDay =  1;
    }
    else
    {
      $isAllDay =  0;
    }

    $sql = "insert into cabShare(calendarid, uid, title, location, isAllDay, endDate, startDate, state, useCreationPopup, rawClass)
          values ('". self::$calenderID ."','". self::$uid ."','". self::$title ."','". self::$location ."','". self::$isAllDay ."','". self::$end ."',
          '". self::$start ."','". self::$state ."','". self::$useCreationPopup ."','". self::$rawClass ."')";

    $mysql->query($sql);

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
      echo json_encode($result);
      exit();
    }
    else
    {
      $result = array('response' => 'success', 'text' => 'Posted' , 'type' => 'success');
      echo json_encode($result);
      exit();
    }
  }

  public function get()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    $sql = "SELECT * from cabShare c
             INNER JOIN users us ON c.uid = us.id";

    $res = $mysql->query($sql);

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
      echo json_encode($result);
      exit();
    }
    else
    {
      $rows = array();
      while($row = mysqli_fetch_assoc($res))
      {
        $rows[] = $row;
      }

      $result = array('response' => 'success', 'text' => 'Posted' , 'type' => 'success', 'data' => $rows);
      echo json_encode($result);
      exit();
    }
  }

  public function delete()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    $cid = mysqli_real_escape_string($mysql, $_POST['cabid']);
    $id = self::$uid;

    $sql = "DELETE FROM cabShare WHERE cabid = $cid AND uid = $id";

    $res = $mysql->query($sql);

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
      echo json_encode($result);
      exit();
    }
    else
    {
      $result = array('response' => 'success', 'text' => 'Deleted' , 'type' => 'success');
      echo json_encode($result);
      exit();
    }
  }
}
