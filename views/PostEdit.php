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

$router = new Router;
$session  = new Session;
$post    = new PostController;
$uid = $session->get('uid');

if($router->get('post'))
{
  $pid = $router->get('post');
  $posts = $post->fetchUserPosts($uid, $pid,$from='editPost');
}
else
{
  $posts = $post->fetchUserPosts($uid,$pid='',$from='editPost');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
  <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/system/css/core.css" />
  <script src="<?php echo BASE_URL; ?>media/system/js/core.js"></script>
  <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>templates/images/logo.svg">
  <!--===============================================================================================-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>media/profile/css/editpost.css">
  <script src="<?php echo BASE_URL; ?>media/vendor/tinymce/tinymce.min.js"></script>
  <!--===============================================================================================-->
  <style>

  html{
    height: 100%;
  }
  body
  {
    height: 100%;
    background-image: url('<?php echo BASE_URL; ?>/templates/images/back.png');
    background-repeat: no-repeat;
    background-size: contain;
  }
</style>
</head>
<body >
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Posts</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo BASE_URL; ?>">Home <span class="sr-only">(current)</span></a>
        </li>
        <a class="nav-link" href="<?php echo BASE_URL; ?>profile/">Profile Settings</a>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input id="myInput" onkeyup="myFunction()" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      </form>
    </div>
  </nav>
  <div id="snackbar"></div>
  <div class="container">
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <textarea id="myTextarea"></textarea>
            <fieldset >
              <input hidden type="text" id="token" value="<?php $config = new Config; echo $config->secret; ?> ">
              <input hidden type="text" id="modal-post-id" value="">
              <input hidden type="text" id="image-username" value="<?php echo $session->get('username');  ?>">
            </fieldset>
            <br>
            <hr>
            <div class="col-xs-12">
              <label for="post-title"><h4>Title</h4></label>
              <input type="post-title" class="form-control" name="post-title" id="postTitle" placeholder="post-title" title="Post title." />
              <br>
              <br>
              <label for="sel1">Select type: </label>
              <select class="form-control" id="postType">
                <option value="9">--select--</option>
                <option value="1">Lost</option>
                <option value="2">Found</option>
                <option value="4">Sell</option>
                <option value="5">Notice</option>
                <option value="6">Help</option>
              </select>
              <br>
            </div>
          </div>
          <div class="modal-footer">
            <button data-dismiss="modal" type="button" class="btn btn-primary">Close</button>
            <button data-dismiss="modal" id="user-post-submit" type="button" class="btn btn-success">Save</button>
          </div>
        </div>

      </div>
    </div>

    <div id="table-main" class="table-responsive">
      <input id="post-id" hidden type="text" value="<?php echo $router->get('post'); ?>"/>
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Title</th>
            <th scope="col">Type</th>
            <th scope="col">Published Date</th>
            <th scope="col">Reports</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
            <th scope="col">View</th>
          </tr>
        </thead>
        <tbody id="set">
          <?php  if($posts->num_rows > 0) :  ?>
            <?php $con = 0; while ($rows = $posts->fetch_assoc()) {  ++$con; ?>
              <tr class="moreBox" <?php if($con>6) { echo 'style="display:none;"'; } ?> >
                <th scope="row"><?php echo substr($rows['title'], 0, 20); ?></th>
                <td>
                  <?php if($rows['type'] == 1) : ?>
                    <a href="<?php echo BASE_URL; ?>post/page/s/<?php echo $rows['type']; ?>" class="badge badge-danger">LOST</a>
                  <?php elseif($rows['type'] == 2) : ?>
                    <a href="<?php echo BASE_URL; ?>post/page/s/<?php echo $rows['type']; ?>" class="badge badge-success">FOUND</a>
                  <?php elseif($rows['type'] == 3) : ?>
                    <a href="<?php echo BASE_URL; ?>post/page/s/<?php echo $rows['type']; ?>" class="badge badge-success">BUY</a>
                  <?php elseif($rows['type'] == 4) : ?>
                    <a href="<?php echo BASE_URL; ?>post/page/s/<?php echo $rows['type']; ?>" class="badge badge-info">SELL</a>
                  <?php elseif($rows['type'] == 5) : ?>
                    <a href="<?php echo BASE_URL; ?>post/page/s/<?php echo $rows['type']; ?>" class="badge badge-primary">Notice</a>
                  <?php endif; ?>
                </td>
                <td><?php echo $rows['entryDate']; ?></td>
                <td><?php echo $rows['reports']; ?></td>
                <td><?php if($rows['status'] == 1) : ?>
                  <a style ="font-size:30px;cursor:pointer;color:green;" state-edit-task="<?php echo $rows['pid']; ?>" task="0" ><i class="far fa-check-circle"></i></a>
                <?php else: ?>
                  <a style ="font-size:30px;cursor:pointer;color:red;" state-edit-task="<?php echo $rows['pid']; ?>" task="1" ><i class="far fa-times-circle"></i></a>
                <?php endif; ?>
              </td>
              <td><button edit-task="<?php echo $rows['pid']; ?>" type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary">Edit</button></td>
              <td><a target="_blank" href="<?php echo BASE_URL; ?>post/page/pid/<?php echo $rows['pid']; ?>" class="btn btn-info" role="button">View</a></td>
            </tr>
          <?php } ?>
        <?php else: ?>
          <p style="text-align:center; padding:3px;">You not have any posts.<p>
          <?php endif; ?>
        </tbody>
      </table>
      <div  class="text-center">
        <a id="loadMore" class="btn btn-primary" href="#">Load More</a>
      </div>
    </div>
  </div>
  <!--===============================================================================================-->
  <script src="<?php echo BASE_URL; ?>media/profile/js/editpost.js"></script>
  <script src="<?php echo BASE_URL; ?>media/profile/js/editmain.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <script>
  function myFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("set");
    li = ul.getElementsByTagName("tr");
    for (i = 0; i < li.length; i++) {
      a = li[i].getElementsByTagName("th")[0];
      if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
      } else {
        li[i].style.display = "none";
      }
    }
  }

  $( document ).ready(function () {
    $(".moreBox").slice(0, 3).show();
    if ($(".blogBox:hidden").length != 0) {
      $("#loadMore").show();
    }
    $("#loadMore").on('click', function (e) {
      e.preventDefault();
      $(".moreBox:hidden").slice(0, 6).slideDown();
      if ($(".moreBox:hidden").length == 0) {
        $("#loadMore").fadeOut();
      }
    });
  });

  </script>
</body>
</html>
