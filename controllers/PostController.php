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
  public $single = NULL;
  public $query = NULL;
  public $pid = NULL;
  public $limit = NULL;

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

      if($this->postType == 5)
      {
        $this->query = "SELECT * from posts po
        INNER JOIN users us ON po.uid = us.id
        WHERE po.type = '5' ORDER by pid DESC LIMIT  $this->limit";

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
    }
    else if($route->get('s'))
    {
      $this->single = $route->get('s');

      $this->query = "SELECT * from posts po
      INNER JOIN users us ON po.uid = us.id
      WHERE po.type = '" . $this->single . "' ORDER by pid DESC LIMIT $this->limit ";
    }

    if($this->query == '' || $this->query == NULL)
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

  public function fetchUserPosts($userId, $pid = '',$from)
  {
    $db    = new Factory();
    $mysql = $db->getDBO();

    if($pid == '' && $from == 'profile')
    {
      $sql  = "SELECT po.*,us.followers as followers, sum(po.status) as totalPosts, sum(po.likes) as totalLikes, sum(po.shares) as totalShares from posts po INNER JOIN users us ON po.uid = us.id WHERE us.id = $userId"; 
    }
    else if($pid != '' && $from == 'editPost')
    {
      $sql  = "SELECT * from posts WHERE uid = $userId ORDER by CASE when pid = " . $pid . " THEN 1 ELSE 2 END";
    }
    else if($pid == '' && $from == 'editPost')
    {
      $sql  = "SELECT * from posts WHERE uid = $userId ORDER by pid DESC";
    }

    $result = $mysql->query($sql);

    if($mysql->connect_error)
    {
      die('Failed to fetch post.');
    }

    $db->disconnect();

    return $result;
  }

  public function report()
  {
    if(isset($_POST['postId']))
    {
      $pid = $_POST['postId'];
    }
    else
    {
      return false;
    }

    $db    = new Factory();
    $mysql = $db->getDBO();

    $sql  = "UPDATE posts SET reports = reports + 1 WHERE pid = $pid";

    $result = $mysql->query($sql);

    if($mysql->connect_error)
    {
      return 'Failed to report.';
    }

    $db->disconnect();

    return true;
  }

  public function deletePost()
  {
    if(isset($_POST['postId']))
    {
      $pid = $_POST['postId'];
    }
    else
    {
      return false;
    }

    if(!User::isLoggedIn())
    {
      $result = array('response' => 'error', 'text' => 'Error occurred in process.');
      echo json_encode($result);
      return false;
    }

    $db    = new Factory();
    $mysql = $db->getDBO();

    $session = new Session;
    $uid = $session->get('uid');

    $sql  = "DELETE FROM posts WHERE pid = $pid AND uid = $uid";

    $result = $mysql->query($sql);

    if($result)
    {
      $result = array('response' => 'success', 'text' => 'Post deleted.');
      echo json_encode($result);
      return true;
    }

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => 'Error occurred in process.');
      echo json_encode($result);
      return false;
    }

    $db->disconnect();

    return true;
  }

  public function getPost()
  {
    if(isset($_POST['postId']))
    {
      $pid = $_POST['postId'];
    }
    else
    {
      return false;
    }

    if(!User::isLoggedIn())
    {
      $result = array('response' => 'error', 'text' => 'Error occurred in process.');
      echo json_encode($result);
      return false;
    }

    $db    = new Factory();
    $mysql = $db->getDBO();

    $session = new Session;
    $uid = $session->get('uid');

    $sql  = "SELECT * from posts WHERE pid = $pid AND uid = $uid";

    $result = $mysql->query($sql);

    if($mysql->connect_error)
    {
      die('Failed to fetch post.');
    }

    $rows  = $result->fetch_assoc();

    if($result->num_rows == 0)
    {
      $result = array('response' => 'error', 'text' => 'Error occurred in process.');
      echo json_encode($result);
      return false;
    }

    $result = array('response' => 'success', 'message' => $rows['message'], 'title' => $rows['title'], 'type' => $rows['type'], 'id' => $rows['pid']);
    echo json_encode($result);

    $db->disconnect();
    return true;
  }
}
