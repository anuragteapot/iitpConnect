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

 $uid = $session->get('uid');

 $post = new PostController;
 $posts = $post->fetchUserPosts($uid);

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Edit</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/css/message.css" />
  <script src="<?php echo BASE_URL; ?>templates/js/message.js"></script>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>templates/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>templates/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>templates/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>templates/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>templates/vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>media/profile/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>media/profile/css/editpost.css">
  <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ycije1qe3wsljxo43rypvv9zgiuc6g3tof66c2lqhusvd6gr"></script>
<!--===============================================================================================-->
<style>
.modal-lg
{
  max-width: 1800px;
}
/* Important part */
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    height: 700px;
    overflow-y: auto;
}
.modal-content
{
  padding: 5px;
}
.container-table100 {
  background-color: transparent !important;
}

.column6 {
  width: 30%;
}

.column7 {
  width: 40%;
}

body{
  background-color: #6cb1a5;
}
</style>
</head>
<body >
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
                  <option value="0">Notice</option>
                  <option value="1">Lost</option>
                  <option value="2">Found</option>
                  <option value="3">Buy</option>
                  <option value="4">Sell</option>
                  <option value="5">Cab share</option>
                  <option value="6">Help</option>
                </select>
                <br>
            </div>
          </div>
          <div class="modal-footer">
            <button data-dismiss="modal" type="button" class="btn btn-primary">Close</button>
            <button id="user-post-submit" type="button" class="btn btn-success">Save</button>
          </div>
        </div>

      </div>
    </div>
  </div>

	<div class="limiter">
		<div class="container-table100">
        <a href="<?php echo BASE_URL; ?>" class="btn btn-primary" role="button">Go Home</a>
        <?php if($router->get('post')) : ?>
        &nbsp;&nbsp;&nbsp;
        <button id="open-model" type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#myModal">Open Edit Modal</button>
      <?php endif; ?>
        &nbsp;&nbsp;&nbsp;
        <a  href="<?php echo BASE_URL; ?>profile/" class="btn btn-primary" role="button">Profile Settings</a>
        <input id="post-id" hidden type="text" value="<?php echo $router->get('post'); ?>"/>
			<div class="wrap-table100">
				<div class="table100 ver1 m-b-110">
					<div class="table100-head">
						<table>
							<thead>
								<tr class="row100 head">
									<th class="cell100 column1">Title</th>
									<th class="cell100 column2">Type</th>
									<th class="cell100 column3">Published date</th>
                  <th class="cell100 column4">Reports</th>
                  <th class="cell100 column5">Status</th>
                  <th class="cell100 column6">Action</th>
                  <th class="cell100 column7">View</th>
								</tr>
							</thead>
						</table>
					</div>

					<div class="table100-body js-pscroll">
						<table>
							<tbody>
                  <?php  if($posts->num_rows > 0) :  ?>
                  <?php  while ($rows = $posts->fetch_assoc()) { ?>
								<tr class="row100 body">
									<td class="cell100 column1"><?php echo substr($rows['title'], 0, 20); ?></td>
									<td class="cell100 column2">

                    <?php if($rows['type'] == 0) : ?>
                      <a href="<?php echo BASE_URL; ?>post/page/s/<?php echo $rows['type']; ?>" class="badge badge-info">NOTICE</a>
                    <?php elseif($rows['type'] == 1) : ?>
                      <a href="<?php echo BASE_URL; ?>post/page/s/<?php echo $rows['type']; ?>" class="badge badge-danger">LOST</a>
                    <?php elseif($rows['type'] == 2) : ?>
                      <a href="<?php echo BASE_URL; ?>post/page/s/<?php echo $rows['type']; ?>" class="badge badge-success">FOUND</a>
                    <?php elseif($rows['type'] == 3) : ?>
                      <a href="<?php echo BASE_URL; ?>post/page/s/<?php echo $rows['type']; ?>" class="badge badge-success">BUY</a>
                    <?php elseif($rows['type'] == 4) : ?>
                      <a href="<?php echo BASE_URL; ?>post/page/s/<?php echo $rows['type']; ?>" class="badge badge-info">SELL</a>
                    <?php elseif($rows['type'] == 5) : ?>
                      <a href="<?php echo BASE_URL; ?>post/page/s/<?php echo $rows['type']; ?>" class="badge badge-primary">CAB SHARE</a>
                    <?php endif; ?>

                  </td>
									<td class="cell100 column3"><?php echo $rows['entryDate']; ?></td>
                  <td class="cell100 column4"><?php echo $rows['reports']; ?></td>
                  <td class="cell100 column5"><?php echo $rows['status']; ?></td>
                  <td class="cell100 column6"><button edit-task="<?php echo $rows['pid']; ?>" type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary">Edit</button></td>
                  <td class="cell100 column7"><a target="_blank" href="<?php echo BASE_URL; ?>post/page/pid/<?php echo $rows['pid']; ?>" class="btn btn-info" role="button">View</a></td>
                </tr>
                <?php } ?>
              <?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>


<!--===============================================================================================-->
	<script src="<?php echo BASE_URL; ?>templates/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo BASE_URL; ?>templates/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo BASE_URL; ?>templates/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo BASE_URL; ?>templates/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo BASE_URL; ?>templates/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			var ps = new PerfectScrollbar(this);

			$(window).on('resize', function(){
				ps.update();
			})
		});

	</script>
<!--===============================================================================================-->
	<script src="<?php echo BASE_URL; ?>media/profile/js/editpost.js"></script>
  <script src="<?php echo BASE_URL; ?>media/profile/js/editmain.js"></script>

</body>
</html>
