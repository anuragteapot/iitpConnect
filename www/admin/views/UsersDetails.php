<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link type="text/css" href="<?php echo BASE_URL; ?>templates/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="<?php echo BASE_URL; ?>templates/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="<?php echo BASE_URL; ?>templates/css/theme.css" rel="stylesheet">
    <link type="text/css" href="<?php echo BASE_URL; ?>templates/images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
</head>

<body>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                    <i class="icon-reorder shaded"></i></a><a class="brand" href="index.html">Admin Panel</a>
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
                                <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="nav-avatar" />
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
                            <li class="active"><a href="<?php BASE_URL ?>."><i class="menu-icon icon-dashboard"></i>Dashboard
                                </a></li>
                            <li><a href="<?php BASE_URL ?>users"><i class="menu-icon icon-user"></i>User Details</a>
                            </li>
                            <li><a href="<?php BASE_URL ?>./#PostDetails"><i class="menu-icon icon-inbox"></i>Posts <b class="label green pull-right">
                                        11</b> </a></li>
                            <li><a href="<?php BASE_URL ?>message"><i class="menu-icon icon-envelope"></i>Feedback <b class="label orange pull-right">
                                        19</b> </a></li>
                        </ul>
                        <!--/.widget-nav-->


                        <ul class="widget widget-menu unstyled">
                            <li><a href="<?php BASE_URL ?>./#holidayList"><i class="menu-icon icon-list"></i> Holiday List </a></li>
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
                        <div class="module">
                            <div class="module-head">
                                <h3>
                                    All Members</h3>
                            </div>
                            <div class="module-option clearfix">
                                <form>
                                    <div class="input-append pull-left">
                                        <input type="text" class="span3" placeholder="Filter by name...">
                                        <button type="submit" class="btn">
                                            <i class="icon-search"></i>
                                        </button>
                                    </div>
                                </form>
                                <div class="btn-group pull-right" data-toggle="buttons-radio">
                                    <button type="button" class="btn">
                                        All</button>
                                    <button type="button" class="btn">
                                        Male</button>
                                    <button type="button" class="btn">
                                        Female</button>
                                </div>
                            </div>
                            <?php
                            $count = 0;
                            $userId = Admin::allUserDetails();
                            echo "<div class='module-body'><div class='row-fluid'>";
                            while ($userid = mysqli_fetch_assoc($userId)) {
                                $userData = Admin::fetchUserPosts($userid['id']);
                                $row = mysqli_fetch_assoc($userData);
                                echo " <div class='media user'>
                                    <a class='media-avatar pull-left' href='#'>
                                    <img src='http://ssl.gstatic.com/accounts/ui/avatar_2x.png'></a>
                                    <div class='media-body'><h3 class='media-title'>" . $userid['username'] . "</h3>
                                    <h3 class='media-title'>" . $userid['email'] . "</h3>";
                            }
                            echo "</div></div>";
                            ?>
                        </div>
                    </div>
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
    <script src="<?php echo BASE_URL; ?>templates/scripts/datatables/jquery.dataTables.js" type="text/javascript"></script>
</body>