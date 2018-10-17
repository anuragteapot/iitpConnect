<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_EXEC') or die;

class PostController extends BaseController
{

  public $postType = NULL;
  private static $query = NULL;

  public function __construct()
  {
    if(isset($_GET['t']))
    {
      $type = $_GET['t'];

      if($type == 12)
      {
        self::$query = "SELECT * FROM posts where type = '2' OR type = '3'";
      }
      else if($type == 34)
      {
        self::$query = "SELECT * FROM posts where type = '4' OR type = '5'";
      }
      else if($type == 56)
      {
        self::$query = "SELECT * FROM posts where type = '6'";
      }
    }
    else
    {
      self::$query = "SELECT * FROM posts";
    }
  }

  public function fetchPost()
  {
    $db = new Factory();
    $mysql = $db->getDBO();

    $result = $mysql->query(self::$query);

    if($mysql->connect_error) {
      die('Failed to fetch post.');
    }

    return $result;
  }
}
