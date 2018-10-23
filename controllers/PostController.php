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

    public $postType;
    public $single;
    public $query;
    public $pid;
    public $limit;

    public function __construct()
    {
      $route = new Router;

      if($route->get('l'))
      {
        $this->limit = $route->get('l');
      }
      else
      {
        $this->limit = 4;
      }

      if(isset($_GET['query']) && !empty($_GET['query']))
      {
        $q = $_GET['query'];

        $this->query  = "SELECT * from posts po
                        INNER JOIN users us ON po.uid = us.id
                        WHERE po.title LIKE '%$q%' OR po.message LIKE '%$q%' ORDER by pid DESC";

      }
      else if($route->get('pid'))
      {
        $this->pid = $route->get('pid');

        $this->query = "SELECT * from posts po
                        INNER JOIN users us ON po.uid = us.id ORDER by CASE when po.pid = " . $this->pid . " THEN 1 ELSE 2 END LIMIT  $this->limit ";
      }
      else if($route->get('t'))
      {
        $this->postType  = $route->get('t');

        if($this->postType == 0)
        {
          $this->query = "SELECT * from posts po
                          INNER JOIN users us ON po.uid = us.id
                          WHERE po.type = '0' ORDER by pid DESC LIMIT  $this->limit";

        }
        else if($this->postType == 12)
        {
          $this->query = "SELECT * from posts po
                          INNER JOIN users us ON po.uid = us.id
                          WHERE po.type = '1' OR po.type = '2' ORDER by pid DESC LIMIT $this->limit ";
        }
        else if($this->postType == 34)
        {
          $this->query = "SELECT * from posts po
                          INNER JOIN users us ON po.uid = us.id
                          WHERE po.type = '3' OR po.type = '4' ORDER by pid DESC LIMIT $this->limit ";
        }
        else if($this->postType == 5)
        {
          $this->query = "SELECT * from posts po
                          INNER JOIN users us ON po.uid = us.id
                          WHERE po.type = '5' ORDER by pid DESC LIMIT $this->limit ";
        }
      }
      else if($route->get('s'))
      {
        $this->single = $route->get('s');

        $this->query = "SELECT * from posts po
                        INNER JOIN users us ON po.uid = us.id
                        WHERE po.type = '" . $this->single . "' ORDER by pid DESC LIMIT $this->limit ";
      }
      else
      {
        $this->query = "SELECT * from posts po
                        INNER JOIN users us ON po.uid = us.id
                        ORDER by pid DESC LIMIT $this->limit ";
      }
    }

    public function fetchPost()
    {
      $db    = new Factory();
      $mysql = $db->getDBO();

      $result = $mysql->query($this->query);

      if($mysql->connect_error)
      {
        die('Failed to fetch post.');
      }

      $db->disconnect();

      return $result;
    }

    public function fetchUserPosts($userId)
    {
      $db    = new Factory();
      $mysql = $db->getDBO();

      $sql  = "SELECT * from posts WHERE uid = $userId ORDER by pid DESC";

      $result = $mysql->query($sql);

      if($mysql->connect_error)
      {
        die('Failed to fetch post.');
      }

      $db->disconnect();

      return $result;
    }
}
