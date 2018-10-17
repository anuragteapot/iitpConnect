<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

$session = new Session;
$userDetails = User::getUser($session->get('username'));

if(!User::isLoggedIn())
{
  header('Location: ' . BASE_URL);
}

?>
<html>
<head>
  <title>Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ycije1qe3wsljxo43rypvv9zgiuc6g3tof66c2lqhusvd6gr"></script>
</head>
<body>
<div style="margin-bottom:200px" class="container">
  <div class="row" style="margin:30px;">
    <div class="col-sm-10"><h3><?php echo $userDetails['name']; ?> (<?php echo $userDetails['username']; ?>)</h3></div>
  </div>
  <div class="row">
    <div class="col-sm-3"><!--left col-->
      <div class="text-center">
        <?php if(file_exists(BASE_PATH . '/uploads/' . $userDetails['username'] . '/profileimage')) : ?>
          <img id="user-image" src="<?php echo BASE_URL . 'uploads/' . $userDetails['username'] . '/profileimage'; ?>" class="avatar img-circle img-thumbnail" alt="avatar">
        <?php else:?>
          <img id="user-image" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar">
        <?php endif;?>
        <br>
        <br>
        <form enctype="multipart/form-data" id="fupForm" >
          <input hidden type="text" name="profileimage" value="<?php echo $userDetails['username']; ?>" >
          <input hidden id="image-username" type="text" name="username" value="<?php echo $userDetails['username']; ?>" >
          <input id="profile-image-submit" type="file" name="file" class="text-center center-block file-upload">
        </form>
      </div>
    </hr><br>

      <div class="panel panel-default">
        <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
        <div class="panel-body"><a href="http://bootnipets.com">bootnipets.com</a></div>
      </div>

      <ul class="list-group">
        <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Shares</strong></span> 125</li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Likes</strong></span> 13</li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Posts</strong></span> 37</li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Followers</strong></span> 78</li>
      </ul>

      <div class="panel panel-default">
        <div class="panel-heading">Social Media</div>
        <div class="panel-body">
          <i class="fa fa-facebook fa-2x"></i> <i class="fa fa-github fa-2x"></i> <i class="fa fa-twitter fa-2x"></i> <i class="fa fa-pinterest fa-2x"></i> <i class="fa fa-google-plus fa-2x"></i>
        </div>
      </div>
    </div><!--/col-3-->
    <div class="col-sm-9">
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
        <li><a data-toggle="tab" href="#use">Post</a></li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="home">
          <hr>
          <div class="form-group">
            <div class="col-xs-6">
              <label for="name"><h4>Name</h4></label>
              <input value="<?php echo $userDetails['name']; ?>" type="text" class="form-control" name="name" id="name" placeholder="Name" title="enter your name">
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-6">
              <label for="mobile"><h4>Mobile</h4></label>
                <input value="<?php echo $userDetails['phonenumber']; ?>" type="text" class="form-control" name="mobile" id="mobile" placeholder="enter mobile number" title="enter your mobile number if any.">
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
              <input value="<?php echo $userDetails['location']; ?>" type="locatton" class="form-control" id="location" placeholder="somewhere" title="enter a location">
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
              <hr>
             </div><!--/tab-pane-->

             <div class="tab-pane" id="use">
               <hr>
               <div id="use-container">
                 <textarea id="myTextarea"></textarea>
                 <fieldset >
                   <input hidden type="text" id="token" value="<?php $config = new Config(); echo $config->secret; ?> ">
                 </fieldset>
                 <br>
                 <hr>
                 <div class="col-xs-12">
                   <label for="post-title"><h4>Title</h4></label>
                     <input type="post-title" class="form-control" name="post-title" id="post-title" placeholder="post-title" title="Post title.">
                     <br>
                     <br>
                     <label for="sel1">Select list (select one):</label>
                     <select class="form-control" id="sel1">
                       <option value="1">Notice</option>
                       <option value="2">Lost</option>
                       <option value="3">Found</option>
                       <option value="4">Buy</option>
                       <option value="5">Sell</option>
                       <option value="6">Cab share</option>
                     </select>
                     <br>
                 </div>
                 <div class="form-group">
                      <div class="col-xs-12">
                           <br>
                          <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Post</button>
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
  </div><!--/row-->


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
