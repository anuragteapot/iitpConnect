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

$userPost = new PostController;
$result = $userPost->fetchUserPosts($userDetails['id']);

?>
<html>
<head>
  <title>Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/system/css/core.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/profile/css/editpost.css" />
  <script src="<?php echo BASE_URL; ?>media/system/js/core.js"></script>
  <script src="<?php echo BASE_URL; ?>media/vendor/tinymce/tinymce.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>templates/images/logo.svg">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <div style="display:none;" class="bar" id="loader"><div></div></div>
  <div id="snackbar"></div>

  <nav id="navbar1">
    <div class="nav-wrapper1">

      <?php if(User::isLoggedIn()) :  ?>
        <ul>
          <li><a id="logoutuser" href="javascript:void(0);" class="nav-input-login">Logout</a></li>
        </ul>
      <?php endif; ?>
      <ul id="menu1">
        <li><a id="menu-item" href="<?php echo BASE_URL; ?>">Home</a></li>
        <li><a id="menu-item" href="<?php echo BASE_URL; ?>post">All</a></li>
        <li><a id="menu-item" href="<?php echo BASE_URL; ?>post/page/t/12">Lost/Found</a></li>
        <li><a id="menu-item" href="<?php echo BASE_URL; ?>post/page/t/34">Buy/Sell</a></li>
        <li><a id="menu-item" href="<?php echo BASE_URL; ?>post/cab/">Cab/Share</a></li>
        <li><a id="menu-item" href="javascript:void(0);">Services</a></li>
        <li><a id="menu-item" href="javascript:void(0);">About</a></li>
        <li><a id="menu-item" href="javascript:void(0);">Contact</a></li>
        <?php if(User::isLoggedIn()) :  ?>
          <li><a id="menu-item" href="<?php echo BASE_URL; ?>profile"><?php echo $session->get('name');?> (<?php echo $session->get('username');?>)</a></li>
        <?php endif;  ?>
      </ul>
    </div>
  </nav>

  <nav style="background-color:#343a40!important;" class="mobile-menu navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand"  style="color:white;" href="javascript:void(0);"><?php echo $userDetails['name']; ?> (<?php echo $userDetails['username']; ?>)</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="<?php echo BASE_URL; ?>">Home</a></li>
          <li><a href="<?php echo BASE_URL; ?>post">All</a></li>
          <li><a href="<?php echo BASE_URL; ?>post/page/t/12">Lost/Found</a></li>
          <li><a href="<?php echo BASE_URL; ?>post/page/t/34">Buy/Sell</a></li>
          <li><a href="<?php echo BASE_URL; ?>post/cab/">Cab/Share</a></li>
          <li><a id="logoutuser" href="javascript:void(0);">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div style="margin-bottom:100px" class="container">
    <div class="row"  style="margin-top:80px">
      <div class="col-sm-3"><!--left col-->
        <div class="text-center">
          <?php if(file_exists(BASE_PATH . '/uploads/' . sha1('iitp' . $userDetails['username'] . 'upload') . '/' . sha1('user-profile') . '/profileimage')) : ?>
            <img id="user-image" src="<?php echo BASE_URL . 'uploads/' . sha1('iitp' . $userDetails['username'] . 'upload') . '/' . sha1('user-profile') . '/profileimage'; ?>" class="avatar img-circle img-thumbnail" alt="avatar">
          <?php else:?>
            <img id="user-image" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar">
          <?php endif;?>
          <br>
          <br>
          <form enctype="multipart/form-data" id="fupForm" >
            <input hidden type="text" name="profileimage" value="<?php echo $userDetails['username']; ?>" >
            <input hidden id="image-username" type="text" name="username" value="<?php echo $userDetails['username']; ?>" >
            <input id="profile-image-submit" type="file" name="file" class="inputfile">
            <label for="profile-image-submit"><strong>Upload new picture</strong></label>
          </form>
        </div>
      </hr><br>
      <?php if($userDetails['admin']) : ?>
        <div class="panel panel-default">
          <div class="panel-heading">Admin Section <i class="fa fa-link fa-1x"></i></div>
          <div class="panel-body"><a href="<?php echo BASE_URL; ?>admin">Admin Panel</a></div>
        </div>
      <?php else : ?>
        <div class="panel panel-default">
          <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
          <div class="panel-body"><a href="https://iitpcabshare.herokuapp.com">iitpcabshare</a></div>
        </div>
      <?php endif;?>

      <ul class="list-group">
        <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
        <li class="list-group-item text-right"><span class="pull-left"><strong><a href="<?php echo BASE_URL; ?>profile/edit/post/">Posts</a></strong></span> <?php echo ($result['totalPosts']) ? $result['totalPosts'] : "0"; ?></li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Likes</strong></span> <?php echo ($result['totalLikes']) ? $result['totalLikes'] : "0"; ?></li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Shares</strong></span><?php  echo ($result['totalShares']) ? $result['totalShares'] : "0"; ?></li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Followers</strong></span> 0 </li>
      </ul>

      <!-- <div class="panel panel-default">
        <div class="panel-heading">Social Media</div>
        <div class="panel-body">
          <i class="fa fa-facebook fa-2x"></i> <i class="fa fa-github fa-2x"></i> <i class="fa fa-twitter fa-2x"></i> <i class="fa fa-pinterest fa-2x"></i> <i class="fa fa-google-plus fa-2x"></i>
        </div>
      </div> -->
    </div><!--/col-3-->
    <div class="col-sm-9">
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#use">Post</a></li>
        <li ><a data-toggle="tab" href="#home">Profile</a></li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane" id="home">
          <div class="form-group">
            <div class="col-xs-6">
              <label for="name"><h4>Name</h4></label>
              <input value="<?php echo $userDetails['name']; ?>" type="text" class="form-control" name="name" id="name" placeholder="Name" title="enter your name">
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-6">
              <label for="mobile"><h4>Mobile</h4></label>
              <input value="<?php echo $userDetails['phonenumber']; ?>" type="number" class="form-control" name="mobile" id="mobile" placeholder="enter mobile number" title="enter your mobile number if any.">
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-6">
              <label for="email"><h4>Email</h4></label>
              <input disabled value="<?php echo $userDetails['email']; ?>" type="email" class="form-control" name="email" id="email" placeholder="you@email.com" title="enter your email.">
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-6">
              <label for="location"><h4>Location</h4></label>
              <input value="<?php echo $userDetails['address']; ?>" type="locatton" class="form-control" id="location" placeholder="location" title="enter a location">
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-6">
              <label for="institute"><h4>Institute</h4></label>
              <input value="<?php echo $userDetails['institute']; ?>" type="institute" class="form-control" id="institute" placeholder="institute name" title="Institute name">
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-6">
              <label for="password"><h4>Password</h4></label>
              <input type="password" class="form-control" name="password" id="password" placeholder="password" title="enter your password.">
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-6">
              <label for="password2"><h4>Verify</h4></label>
              <input type="password" class="form-control" name="password2" id="password2" placeholder="password2" title="enter your password2.">
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <br>
              <button id="user-data-submit" class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
              &nbsp;
              &nbsp;
              &nbsp;
              <a href="<?php echo BASE_URL; ?>" class="btn btn-lg btn-info" role="button"><i class="glyphicon glyphicon-chevron-left"></i>Home</a>
            </div>
          </div>
        </div><!--/tab-pane-->

        <div class="tab-pane active" id="use">
          <div id="use-container">
            <textarea id="myTextarea"></textarea>
            <fieldset >
              <input hidden type="text" id="token" value="<?php $config = new Config(); echo $config->secret; ?> ">
            </fieldset>
            <br>
            <div class="col-xs-12">
              <label for="post-title"><h4>Title</h4></label>
              <input type="post-title" class="form-control" name="post-title" id="postTitle" placeholder="post-title" title="Post title.">
              <br>
              <br>
              <label for="sel1">Select type: </label>
              <select class="form-control" id="postType">
                <option value="9">--select--</option>
                <option value="1">Lost</option>
                <option value="2">Found</option>
                <!-- <option value="3">Buy</option> -->
                <option value="4">Sell</option>
                <option value="5">Notice</option>
                <option value="6">Help</option>
              </select>
              <br>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <br>
                <button id="user-post-submit" class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Post</button>
                &nbsp;
                &nbsp;
                &nbsp;
                <a href="<?php echo BASE_URL; ?>" class="btn btn-lg btn-info" role="button"><i class="glyphicon glyphicon-chevron-left"></i>Home</a>
              </div>
            </div>
          </div>
        </div><!--/tab-pane-->

      </div><!--/tab-pane-->
    </div><!--/tab-content-->
  </div><!--/col-9-->
  <!-- Footer -->
</div>
<!-- Copyright -->
<div style="margin-bottom:20px;" class="footer-copyright text-center">© 2018 Copyright:
  <a href="https://iitpConnect/"> iitpConnect</a>
</div>
<!-- Copyright -->
</footer>
<!-- Footer -->
</body>
<script src="<?php echo BASE_URL; ?>media/profile/js/main.js"></script>
</html>
