<?php
/**
* @package    iitpConnect.Site
*
* @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
* @license    GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_EXEC') or die;

if(!User::isLoggedIn())
{
  header('Location: ' . BASE_URL);
}

$session = new Session;
$userDetails = User::getUser($session->get('username'));
$allUserData = Admin::getAllUserDetails();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Panel</title>
        <link type="text/css" href="<?php echo BASE_URL; ?>templates/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="<?php echo BASE_URL; ?>templates/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="<?php echo BASE_URL; ?>templates/css/theme.css" rel="stylesheet">
        <link type="text/css" href="<?php echo BASE_URL; ?>templates/images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
            rel='stylesheet'>
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="#">Admin Panel </a>
                    <div class="nav-collapse collapse navbar-inverse-collapse">
                        <ul class="nav nav-icons">
                            <li class="active"><a href="#"><i class="icon-envelope"></i></a></li>
                            <li><a href="#"><i class="icon-eye-open"></i></a></li>
                            <li><a href="#"><i class="icon-bar-chart"></i></a></li>
                        </ul>
                        <form class="navbar-search pull-left input-append" action="#">
                        <input type="text" class="span3">
                        <button class="btn" type="button">
                            <i class="icon-search"></i>
                        </button>
                        </form>
                        <ul class="nav pull-right">
                            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown
                                <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Item No. 1</a></li>
                                    <li><a href="#">Don't Click</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header">Example Header</li>
                                    <li><a href="#">A Separated link</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Support </a></li>
                            <li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php if(file_exists(BASE_PATH . '/uploads/' . sha1('iitp' . $userDetails['username'] . 'upload') . '/' . sha1('user-profile') . '/profileimage')) : ?>
                                <img id="user-image" src="<?php echo BASE_URL . 'uploads/' . sha1('iitp' . $userDetails['username'] . 'upload') . '/' . sha1('user-profile') . '/profileimage'; ?>" class="avatar img-circle img-thumbnail" alt="avatar">
                            <?php else:?>
                                <img id="user-image" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="nav-avatar img-circle img-thumbnail" alt="avatar">
                            <?php endif;?>
                                <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Your Profile</a></li>
                                    <li><a href="#">Edit Profile</a></li>
                                    <li><a href="#">Account Settings</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /.nav-collapse -->
                </div>
            </div>
            <!-- /navbar-inner -->
        </div>
        <!-- /navbar -->
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="span3">
                        <div class="sidebar">
                            <ul class="widget widget-menu unstyled">
                                <li class="active"><a href="#"><i class="menu-icon icon-dashboard"></i>Dashboard
                                </a></li>
                                <li><a href="#"><i class="menu-icon icon-user"></i>User Details</a>
                                </li>
                                <li><a href="#"><i class="menu-icon icon-inbox"></i>Posts <b class="label green pull-right">
                                    11</b> </a></li>
                                <li><a href="#"><i class="menu-icon icon-envelope"></i>Feedback <b class="label orange pull-right">
                                    19</b> </a></li>
                            </ul>
                            <!--/.widget-nav-->


                            <ul class="widget widget-menu unstyled">
                                <li><a href="#"><i class="menu-icon icon-list"></i> Holiday List </a></li>
                                <li><a href="#"><i class="menu-icon icon-share"></i>Cab Shares </a></li>
                            </ul>
                            <!--/.widget-nav-->
                            <ul class="widget widget-menu unstyled">
                                <li><a class="collapsed" data-toggle="collapse" href="#togglePages"><i class="menu-icon icon-cog">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                                </i>More Pages </a>
                                    <ul id="togglePages" class="collapse unstyled">
                                        <li><a href="#"><i class="icon-inbox"></i>Login </a></li>
                                        <li><a href="#"><i class="icon-inbox"></i>Profile </a></li>
                                        <li><a href="#"><i class="icon-inbox"></i>All Users </a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="menu-icon icon-signout"></i>Logout </a></li>
                            </ul>
                        </div>
                        <!--/.sidebar-->
                    </div>
                    <!--/.span3-->
                    <div class="span9">
                        <div class="content">
                            <div class="btn-controls">
                                <div class="btn-box-row row-fluid">
                                    <a href="#" class="btn-box big span4"><i class=" icon-user"></i><b><?php echo($allUserData['totalUsers']); ?></b>
                                        <p class="text-muted">
                                            Total Users</p>
                                    </a><a href="#" class="btn-box big span4"><i class="icon-user"></i><b><?php echo($allUserData['onlineUsers']); ?></b>
                                        <p class="text-muted">
                                            Online Users</p>
                                    </a><a href="#" class="btn-box big span4"><i class="icon-envelope"></i><b><?php echo($allUserData['totalPosts']); ?></b>
                                        <p class="text-muted">
                                            Total Posts</p>
                                    </a>
                                </div>
                                <div class="btn-box-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <div class="span16">
                                                <a href="#" class="btn-box small span3"><i class="icon-envelope"></i><b>Feedback</b>
                                                </a><a href="#UserDetails" class="btn-box small span3"><i class="icon-user"></i><b>User Details</b>
                                                </a><a href="#" class="btn-box small span3"><i class="icon-list"></i><b>Holiday List</b>
                                                </a></a><a href="#" class="btn-box small span3"><i class="icon-inbox"></i><b>Posts</b>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!--/.module-->
                            <div class="module" id="#UserDetails">
                                <div class="module-head">
                                    <h3>
                                        User Details</h3>
                                </div>
                                <div class="module-body table">
                                    <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    User ID
                                                </th>
                                                <th>
                                                    Username
                                                </th>
                                                <th>
                                                    Total Post
                                                </th>
                                                <th>
                                                    Total Follower
                                                </th>
                                                <th>
                                                    Total Likes
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $userId = Admin::allUserDetails();
                                                while($userid = mysqli_fetch_assoc($userId))
                                                {
                                                    $userData = Admin::fetchUserPosts($userid['id']);
                                                    $row = mysqli_fetch_assoc($userData);
                                                    echo "<tr class='odd gradeX'> <td>".$userid['id'].'</td><td>'.$row['username'].'</td><td>'.$row['totalPosts'].'</td><td>'.$row['followers'].'</td><td>'.$row['totalLikes'].'</td>';
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>
                                                    User ID
                                                </th>
                                                <th>
                                                    Username
                                                </th>
                                                <th>
                                                    Total Post
                                                </th>
                                                <th>
                                                    Total Follower
                                                </th>
                                                <th>
                                                    Total Likes
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="module" id="#PostDetails">
                                <div class="module-head">
                                    <h3>
                                        Post Details</h3>
                                </div>
                                <div class="module-body table">
                                    <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Post ID
                                                </th>
                                                <th>
                                                    Title
                                                </th>
                                                <th>
                                                    Likes
                                                </th>
                                                <th>
                                                    Reports
                                                </th>
                                                <th>
                                                    Username
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $userId = Admin::allUserDetails();
                                                while($userid = mysqli_fetch_assoc($userId))
                                                {
                                                    $postData = Admin::fetchPostsDetails($userid['id']);
                                                    while($row = mysqli_fetch_assoc($postData))
                                                    {
                                                        echo "<tr class='odd gradeX'><td>".$row['postId'].'</td><td>'.$row['title'].'</td><td>'.$row['Likes'].'</td><td>'.$row['reports'].'</td><td>'.$row['username'].'</td>';
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>
                                                    Post ID
                                                </th>
                                                <th>
                                                    Title
                                                </th>
                                                <th>
                                                    Likes
                                                </th>
                                                <th>
                                                    Reports
                                                </th>
                                                <th>
                                                    Username
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="module" id="#holidayList">
                                <div class="module-head">
                                    <h3>
                                        Holiday List</h3>
                                </div>
                                <div class="module-body table">
                                    <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Serial No.
                                                </th>
                                                <th>
                                                    Name
                                                </th>
                                                <th>
                                                    Date
                                                </th>
                                                <th>
                                                    Public Holiday
                                                </th>
                                                <th>
                                                    Status
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $holidayList = Admin::fetchHolidays();
                                                while($row = mysqli_fetch_assoc($holidayList))
                                                {
                                                    echo "<tr class='odd gradeX'>".'<td>'.$row['id'].'</td>'.'<td>'.$row['name'].'</td>'.'<td>'.$row['holidayDate'].'</td>'.'<td>'.$row['type'].'</td>'.'<td>'.$row['type'].'</td>';
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>
                                                    Serial No.
                                                </th>
                                                <th>
                                                    Name
                                                </th>
                                                <th>
                                                    Date
                                                </th>
                                                <th>
                                                    Public Holiday
                                                </th>
                                                <th>
                                                    Status
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="module" id="#holidayList">
                                <div class="module-head">
                                    <h3>
                                        Feedback</h3>
                                </div>
                                <div class="module-body table">
                                    <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Id
                                                </th>
                                                <th>
                                                    Name
                                                </th>
                                                <th>
                                                    E-mail
                                                </th>
                                                <th>
                                                    Message
                                                </th>
                                                <th>
                                                    Status
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $feedbackList = Admin::fetchFeedback();
                                                while($row = mysqli_fetch_array($feedbackList))
                                                {
                                                    $type = 0;
                                                    echo "<tr class='odd gradeX'> <td>".$row['id'].'</td><td>'.$row['name'].'</td><td>'.$row['email'].'</td><td>'.$row['message'].'</td><td>'.$type.'</td>';
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>
                                                    Id
                                                </th>
                                                <th>
                                                    Name
                                                </th>
                                                <th>
                                                    E-mail
                                                </th>
                                                <th>
                                                    Message
                                                </th>
                                                <th>
                                                    Status
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!--/.module-->
                        </div>
                        <!--/.content-->
                    </div>
                    <!--/.span9-->
                </div>
            </div>
            <!--/.container-->
        </div>
        <!--/.wrapper-->
        <div class="footer">
            <div class="container">
                <b class="copyright">&copy; 2018 IITP-CONNECT </b>All rights reserved.
            </div>
        </div>
        <script src="<?php echo BASE_URL; ?>templates/scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL; ?>templates/scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL; ?>templates/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL; ?>templates/scripts/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL; ?>templates/scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL; ?>templates/scripts/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL; ?>templates/scripts/common.js" type="text/javascript"></script>

    </body>
</html>