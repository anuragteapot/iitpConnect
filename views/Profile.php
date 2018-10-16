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
<div class="container bootstrap snippet">
    <div class="row" style="margin:30px;">
  		<div class="col-sm-10"><h3><?php echo $userDetails['name']; ?> (<?php echo $userDetails['username']; ?>)</h3></div>
    </div>
    <div class="row">
  		<div class="col-sm-3"><!--left col-->


      <div class="text-center">
        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar">
        <br>
        <br>
        <input type="file" class="text-center center-block file-upload">
      </div></hr><br>


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
                <li><a data-toggle="tab" href="#use">Use</a></li>
              </ul>


          <div class="tab-content">
            <div class="tab-pane active" id="home">
                <hr>
                  <form class="form" action="##" method="post" id="registrationForm">

                      <div class="form-group">

                          <div class="col-xs-6">
                            <label for="name"><h4>Name</h4></label>
                              <input value="<?php echo $userDetails['name']; ?>" type="text" class="form-control" name="name" id="name" placeholder="Name" title="enter your name">
                          </div>
                      </div>

                      <div class="form-group">
                          <div class="col-xs-6">
                             <label for="mobile"><h4>Mobile</h4></label>
                              <input value="<?php echo $userDetails['name']; ?>" type="text" class="form-control" name="mobile" id="mobile" placeholder="enter mobile number" title="enter your mobile number if any.">
                          </div>
                      </div>
                      <div class="form-group">

                          <div class="col-xs-6">
                              <label for="email"><h4>Email</h4></label>
                              <input value="<?php echo $userDetails['email']; ?>" type="email" class="form-control" name="email" id="email" placeholder="you@email.com" title="enter your email.">
                          </div>
                      </div>
                      <div class="form-group">

                          <div class="col-xs-6">
                              <label for="location"><h4>Location</h4></label>
                              <input value="<?php echo $userDetails['name']; ?>" type="locatton" class="form-control" id="location" placeholder="somewhere" title="enter a location">
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-xs-6">
                              <label for="institute"><h4>Institute</h4></label>
                              <input value="<?php echo $userDetails['name']; ?>" type="institute" class="form-control" id="institute" placeholder="institute name" title="Institute name">
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
                              	<button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                                &nbsp;
                                &nbsp;
                                &nbsp;
                               	<a href="<?php echo BASE_URL; ?>" class="btn btn-lg btn-info" role="button"><i class="glyphicon glyphicon-chevron-left"></i>Home</a>
                            </div>
                      </div>
              	</form>
              <hr>
             </div><!--/tab-pane-->

             <div class="tab-pane" id="use">
               <hr>
               <div id="use-container">
                 <textarea id="myTextarea"></textarea>
                 <fieldset >
                   <input hidden type="text" id="token" value="<?php $config = new Config(); echo $config->secret; ?> ">
                 </fieldset>
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
    </div><!--/row-->
</body>
 	<script src="<?php echo BASE_URL; ?>media/profile/js/main.js"></script>
</html>
