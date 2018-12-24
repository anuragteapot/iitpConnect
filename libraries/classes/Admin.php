<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_EXEC') or die;

class Admin
{
    public static function getAllUserDetails()
    {
      $db = new Factory;
      $mysql = $db->getDBO();
  
      $sql  = "SELECT sum(po.status) as totalPosts,sum(us.activation) as totalUsers, from posts po INNER JOIN users us ON po.uid = us.id WHERE 1"; 
  
      $result = $mysql->query($sql);
      $result = mysqli_fetch_array($result);
  
      if($mysql->connect_error)
      {
        die('Failed to fetch post.');
      }
  
      $db->disconnect();
  
      return $result;
    }

    public static function allUserDetails()
    {
        $db    = new Factory();
        $mysql = $db->getDBO();
        $sql = "SELECT id FROM users where 1 ORDER BY id ASC";
    
        $result = $mysql->query($sql);
        $result = mysqli_fetch_array($result);
    
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

        $sql  = "SELECT us.username as username, us.followers as followers, sum(po.status) as totalPosts, sum(po.likes) as totalLikes from posts po INNER JOIN users us ON po.uid = us.id WHERE us.id = $userId"; 

        $result = $mysql->query($sql);

        if($mysql->connect_error)
        {
        die('Failed to fetch post.');
        }

        $result = mysqli_fetch_array($result);
        $db->disconnect();

        return $result;
    }

    public function fetchPostsDetails($userId)
    {
        $db    = new Factory();
        $mysql = $db->getDBO();

        $sql  = "SELECT us.username as username, po.title as title, po.id as postId, sum(po.likes) as Likes, sum(po.reports) as reports from posts po INNER JOIN users us ON po.uid = us.id WHERE us.id = $userId"; 

        $result = $mysql->query($sql);

        if($mysql->connect_error)
        {
        die('Failed to fetch post.');
        }

        $result = mysqli_fetch_array($result);
        $db->disconnect();

        return $result;
    }

    public function fetchHolidays()
    {
        $db    = new Factory();
        $mysql = $db->getDBO();

        $sql = "SELECT * FROM holidayList";

        $result = $mysql->query($sql);

        if($mysql->connect_error)
        {
            die('Failed to fetch post.');
        }

        $db->disconnect();

        return $result;
    }

    public function fetchFeedback()
    {
        $db    = new Factory();
        $mysql = $db->getDBO();

        $sql = "SELECT * FROM feedback";

        $result = $mysql->query($sql);

        if($mysql->connect_error)
        {
            die('Failed to fetch post.');
        }

        $db->disconnect();

        return $result;
    }
}
