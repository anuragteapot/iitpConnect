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

        $sql  = "SELECT sum(us.activation) as totalUsers from users us";
        $result = $mysql->query($sql);
        $result = mysqli_fetch_array($result);

        $sql = "SELECT sum(po.status) as totalPosts from posts po";
        $res = $mysql->query($sql);
        $res = mysqli_fetch_array($res);
        $result = array_merge($result, $res);

        $sql = "SELECT sum(uk.isLoggedIn) as onlineUsers from user_keys uk";
        $res = $mysql->query($sql);
        $res = mysqli_fetch_array($res);

        $result = array_merge($result, $res);


        if ($mysql->connect_error) {
            die('Failed to fetch post.');
        }

        $db->disconnect();

        return $result;
    }

    public static function allUserDetails()
    {
        $db    = new Factory();
        $mysql = $db->getDBO();
        $sql = "SELECT id, username, name, email, admin FROM users";

        $result = $mysql->query($sql);

        if ($mysql->connect_error) {
            die('Failed to fetch post.');
        }

        $db->disconnect();

        return $result;
    }

    public static function fetchUserPosts($userId)

    {
        $db    = new Factory();
        $mysql = $db->getDBO();

        $sql  = "SELECT us.username as username, us.followers as followers, sum(po.status) as totalPosts, sum(po.likes) as totalLikes from posts po RIGHT JOIN users us ON po.uid = us.id WHERE us.id = $userId";


        $result = $mysql->query($sql);

        if ($mysql->connect_error) {
            die('Failed to fetch post.');
        }
        $db->disconnect();

        return $result;
    }

    public static function fetchPostsDetails($userId)

    {
        $db    = new Factory();
        $mysql = $db->getDBO();

        $sql  = "SELECT us.username as username, po.title as title, po.pid as postId, po.likes as Likes, po.reports as reports from posts po INNER JOIN users us ON po.uid = us.id WHERE us.id = $userId";

        $result = $mysql->query($sql);

        if ($mysql->connect_error) {
            die('Failed to fetch post.');
        }
        $db->disconnect();

        return $result;
    }

    public static function fetchHolidays()

    {
        $db    = new Factory();
        $mysql = $db->getDBO();

        $sql = "SELECT * FROM holidayList WHERE 1";
        $result = $mysql->query($sql);

        if ($mysql->connect_error) {
            die('Failed to fetch post.');
        }

        $db->disconnect();

        return $result;
    }

    public static function fetchFeedback()

    {
        $db    = new Factory();
        $mysql = $db->getDBO();

        $sql = "SELECT * FROM feedback";

        $result = $mysql->query($sql);

        if ($mysql->connect_error) {
            die('Failed to fetch post.');
        }

        $db->disconnect();

        return $result;
    }
}
