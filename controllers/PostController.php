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
  private $pid;
  private $limit;

  public function __construct()
  {
    if(isset($_GET['l']) && !empty($_GET['l'])) {

      $this->limit = $GET['l'];
    }
    else {
      $this->limit = 10;
    }

    if(isset($_GET['t']) && !empty($_GET['t']))
    {
      $type = $_GET['t'];

      if($type == 12)
      {
        self::$query = "SELECT * from posts po
                        INNER JOIN users us ON po.uid = us.id
                        WHERE po.type = '2' OR po.type = '3' ORDER by 'entryDate' DESC LIMIT  ". $this->limit ."";
      }
      else if($type == 34)
      {
        self::$query = "SELECT * from posts po
                        INNER JOIN users us ON po.uid = us.id
                        WHERE po.type = '4' OR po.type = '5' ORDER by 'entryDate' DESC LIMIT  ". $this->limit ."";
      }
      else if($type == 56)
      {
        self::$query = "SELECT * from posts po
                        INNER JOIN users us ON po.uid = us.id
                        WHERE po.type = '6' ORDER by 'entryDate' DESC LIMIT  ". $this->limit ."";
      }
    }
    else
    {
      self::$query = "SELECT * from posts po
                      INNER JOIN users us ON po.uid = us.id ORDER by 'entryDate' DESC LIMIT ". $this->limit ."";
    }
  }

  public function fetchPost()
  {
    $db = new Factory();
    $mysql = $db->getDBO();


    self::$query = "SELECT * from posts po
                    INNER JOIN users us ON po.uid = us.id ORDER by CASE when po.pid = 4 THEN 1 ELSE 2 END";

    $result = $mysql->query(self::$query);

    if($mysql->connect_error) {
      die('Failed to fetch post.');
    }

    return $result;
  }
}
