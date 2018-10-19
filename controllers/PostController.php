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

      if(isset($_GET['l']) && !empty($_GET['l']))
      {
        $this->limit = $_GET['l'];
      }
      else
      {
        $this->limit = 4;
      }

      if(isset($_GET['pid']) && !empty($_GET['pid']))
      {
        $this->pid = $_GET['pid'];

        $this->query = "SELECT * from posts po
                        INNER JOIN users us ON po.uid = us.id ORDER by CASE when po.pid = " . $this->pid . " THEN 1 ELSE 2 END LIMIT  $this->limit ";
      }
      else if(isset($_GET['t']) && !empty($_GET['t']))
      {
        $this->postType  = $_GET['t'];

        if($this->postType == 0)
        {
          $this->query = "SELECT * from posts po
                          INNER JOIN users us ON po.uid = us.id
                          WHERE po.type = '0' ORDER by 'entryDate' DESC LIMIT  $this->limit";

        }
        else if($this->postType == 12)
        {
          $this->query = "SELECT * from posts po
                          INNER JOIN users us ON po.uid = us.id
                          WHERE po.type = '1' OR po.type = '2' ORDER by 'entryDate' DESC LIMIT $this->limit ";
        }
        else if($this->postType == 34)
        {
          $this->query = "SELECT * from posts po
                          INNER JOIN users us ON po.uid = us.id
                          WHERE po.type = '3' OR po.type = '4' ORDER by 'entryDate' DESC LIMIT $this->limit ";
        }
        else if($this->postType == 5)
        {
          $this->query = "SELECT * from posts po
                          INNER JOIN users us ON po.uid = us.id
                          WHERE po.type = '5' ORDER by 'entryDate' DESC LIMIT $this->limit ";
        }
      }
      else if(isset($_GET['s']) && !empty($_GET['s']))
      {
        $this->single = $_GET['s'];

        $this->query = "SELECT * from posts po
                        INNER JOIN users us ON po.uid = us.id
                        WHERE po.type = '" . $this->single . "' ORDER by 'entryDate' DESC LIMIT $this->limit ";
      }
      else
      {
        $this->query = "SELECT * from posts po
                        INNER JOIN users us ON po.uid = us.id
                        ORDER by 'entryDate' DESC LIMIT $this->limit ";
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

      return $result;
    }
}
