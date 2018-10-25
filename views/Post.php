<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 $app   = new PostController;
 $posts = $app->fetchPost();
 $rows  = $posts->fetch_assoc();
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Posts</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/css/message.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>media/post/css/main.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/post/css/floating-menu.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	</head>
	<body class="is-preload">
    <div id="snackbar"></div>
		<!-- Wrapper -->
			<div id="wrapper">
				<!-- Header -->
					<header id="header">
            <h1><a href="<?php echo BASE_URL; ?>">HOME</a></h1>
						<nav class="links">
							<ul>
                <li><a href="<?php echo BASE_URL; ?>post">All</a></li>
                <li><a href="<?php echo BASE_URL; ?>post/page/t/0">Notice</a></li>
								<li><a href="<?php echo BASE_URL; ?>post/page/t/12">Lost / Found</a></li>
								<li><a href="<?php echo BASE_URL; ?>post/page/t/34">Buy / Sell</a></li>
								<li><a href="<?php echo BASE_URL; ?>post/page/t/5">Cab Share </a></li>
                <?php if(User::isloggedIn()) : ?>
                  <li><a href="<?php echo BASE_URL; ?>profile">Profile Settings</a></li>
              <?php endif; ?>
              </ul>

						</nav>
            &nbsp;
            &nbsp;
            &nbsp;
            <ul class="icons">
              <li><a href="#" class="fa-twitter"><span class="label">Twitter</span></a></li>
              <li><a href="#" class="fa-facebook"><span class="label">Facebook</span></a></li>
              <li><a href="#" class="fa-instagram"><span class="label">Instagram</span></a></li>
              <li><a href="#" class="fa-rss"><span class="label">RSS</span></a></li>
              <li><a href="#" class="fa-envelope"><span class="label">Email</span></a></li>
            </ul>
            &nbsp;
            &nbsp;
            &nbsp;
            <nav class="main">
              <ul>
                <li class="search">
                  <a class="fa-search" href="#search">Search</a>
                  <form id="search" method="get">
                    <input type="text" name="query" value="<?php if(isset($_GET['query'])) : echo $_GET['query']; endif;?>" placeholder="Search" />
                  </form>
                </li>
                <li class="menu">
                  <a class="fa-bars" href="#menu">Menu</a>
                </li>
              </ul>
            </nav>
					</header>

          <section id="menu">
            <!-- Search -->
            <section>
              <form class="search" method="get">
                <input type="text" name="query" value="<?php if(isset($_GET['query'])) : echo $_GET['query']; endif;?>" placeholder="Search" />
              </form>
            </section>
            <!-- Links -->
            <section>
              <ul class="links">
                <li>
                  <a href="<?php echo BASE_URL; ?>post"><h3>All</h3></a>
                </li>
                <li>
                  <a href="<?php echo BASE_URL; ?>post/page/t/0"><h3>Notice</h3></a>
                </li>
                <li>
                  <a href="<?php echo BASE_URL; ?>post/page/t/12"><h3>Lost / Found</h3></a>
                </li>
                <li>
                  <a href="<?php echo BASE_URL; ?>post/page/t/34"><h3>Buy / Sell</h3></a>
                </li>
                <li>
                  <a href="<?php echo BASE_URL; ?>post/page/t/5"><h3>Cab Share </h3></a>
                </li>
                <?php if(User::isloggedIn()) : ?>
                  <li><a href="<?php echo BASE_URL; ?>profile"><h3>Profile Settings</h3></a></li>
                <?php endif; ?>
              </ul>
            </section>

            <!-- Actions -->
            <section>
              <ul class="actions stacked">
                <?php if(!User::isloggedIn()) : ?>
                  <li><a href="<?php echo BASE_URL; ?>login/" class="button large fit">Log In</a></li>
              <?php endif; ?>
              </ul>
            </section>
          </section>

				<!-- Main -->
					<div id="main">
							<article class="post">
                <?php if($posts->num_rows!=0) : ?>
								<header>
									<div class="title">
										<h3><a><?php echo $rows['title']; ?></a></h3>
                    <input style="display:none;" id="action-post-id"  type="text" value="<?php echo $rows['pid']; ?>"/>
									</div>
									<div class="meta">
										<time class="published" datetime="2015-11-01"><?php echo $rows['entryDate']; ?></time>
										<a href="<?php echo BASE_URL ?>user/view/u/<?php echo $rows['username']; ?>" class="author"><span class="name">By <?php echo $rows['username']; ?></span>

                    <?php if(file_exists(BASE_PATH . '/uploads/' . sha1('iitp' . $rows['username'] . 'upload') . '/' . sha1('user-profile') . '/profileimage')) : ?>
                        <img src="<?php echo BASE_URL . 'uploads/' . sha1('iitp' . $rows['username'] . 'upload') . '/' . sha1('user-profile') . '/profileimage'; ?>"  alt="avatar" /></a>
                      <?php else:?>
                        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar" /></a>
                    <?php endif;?>
                  </div>
								</header>
                  <div>
                    <?php echo $rows['message']; ?>
                  </div>
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
                <footer>
                  <ul class="actions">
                    <?php if($rows['type'] == 1) : ?>
                      <li><a href="" class="button large">Claim</a></li>
                    <?php elseif($rows['type'] == 4) : ?>
                      <li><a href="" class="button large">Checkout</a></li>
                    <?php endif;?>
                  </ul>
                  <ul class="icons">
                    <li style="font-size:25px;"><a href="#" class="fa-twitter"><span class="label">Twitter</span></a></li>
                    <li style="font-size:25px;"><a href="#" class="fa-facebook"><span class="label">Facebook</span></a></li>
                    <?php if(User::isloggedIn()) : ?>
                    <li>
                      <div class='designer-actions'>
                        <ul class="icons">
                          <li><a style="font-size:25px;" class='fa-cog' href='javascript:void(null);' data-action='show-actions-menu' data-fm-floatTo='bottom'></a></li>
                        </ul>
                      </div>
                    </li>
                  <?php endif; ?>
                  </ul>
                </footer>
							</article>
					</div>

          <?php  if($posts->num_rows > 1) :  ?>
				<!-- Sidebar -->
					<section id="sidebar">
						<!-- Posts List -->
							<section>
								<ul class="posts">
                  <?php  while ($rows = $posts->fetch_assoc()) { ?>
									<li>
										<article>
											<header>
												<h3><a href="<?php echo BASE_URL; ?>post/page/pid/<?php echo $rows['pid']; ?>"><?php echo $rows['title']; ?></a></h3>
												<time class="published" datetime="2015-10-20"><?php echo $rows['entryDate']; ?></time>

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

                      </header>
                      <a href="<?php echo BASE_URL ?>user/view/u/<?php echo $rows['username']; ?>" class="image">
                        <?php if(file_exists(BASE_PATH . '/uploads/' . sha1('iitp' . $rows['username'] . 'upload') . '/' . sha1('user-profile') . '/profileimage')) : ?>
                            <img src="<?php echo BASE_URL . 'uploads/' . sha1('iitp' . $rows['username'] . 'upload') . '/' . sha1('user-profile') . '/profileimage'; ?>"  alt="avatar" /></a>
                          <?php else:?>
                            <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar" /></a>
                        <?php endif;?>
                    </article>
                  </li>
                  <?php } ?>
								</ul>
							</section>

						<!-- About -->
							<section class="blurb">
									<a href="<?php echo BASE_URL; ?>post/page/s/<?php echo $app->single; ?>/t/<?php echo $app->postType; ?>/pid/<?php echo $app->pid; ?>/l/<?php echo $app->limit + 3; ?>"
                      class="button">Load More</a>
                  <a href="<?php echo BASE_URL; ?>" class="button">Home</a>
							</section>
            <?php endif; ?>
					</section>
        </div>
        <?php else: ?>
          <div style="text-align:center">
            <img src="<?php echo BASE_URL . 'src/image/noresult1.png';?>" alt="avatar" />
          </div>
        <?php endif;  ?>

		<!-- Scripts -->
			<script src="<?php echo BASE_URL; ?>media/post/js/jquery.min.js"></script>
			<script src="<?php echo BASE_URL; ?>media/post/js/browser.min.js"></script>
			<script src="<?php echo BASE_URL; ?>media/post/js/breakpoints.min.js"></script>
      <script src="<?php echo BASE_URL; ?>templates/js/message.js"></script>
			<script src="<?php echo BASE_URL; ?>media/post/js/util.js"></script>
      <script src="<?php echo BASE_URL; ?>media/post/js/floating-menu.js"></script>
			<script src="<?php echo BASE_URL; ?>media/post/js/template.js"></script>

      <script>
        $.floatingMenu({
          selector: '.designer-actions a[data-action="show-actions-menu"]',
          items: [
            {
                title : 'Report',
                action : function(event) {
                  var postId = $("#action-post-id").val();
                  var location = window.location.href;
                  var baseUrl = location.substring(0, location.indexOf('/post'));

                  $.ajax({
                    url: baseUrl + "/index.php",
                    type: "POST",
                    cache: false,
                    data: {postId : postId, submit:'',task:'PostController.report'},
                    success: function(html){
                      iitpConnect.renderMessage('Thanks for your feedback!','success');
                    }
                  });
                }
              },
            {
            icon : '',
              title : 'Edit',
                action : function(event) {
                  var postId = $("#action-post-id").val();
                  var location = window.location.href;
                  var baseUrl = location.substring(0, location.indexOf('/post'));
                  window.location.href = baseUrl + '/profile/edit/post/' + postId;
                }
              },
            {
            icon : '',
            title : 'Remove',
            action : function(event)
            {
              var postId = $("#action-post-id").val();
              var location = window.location.href;
              var baseUrl = location.substring(0, location.indexOf('/post'));

              var r = confirm("Are you sure want to delete this post?");
              if (r == true) {
                $.ajax({
                  url: baseUrl + "/index.php",
                  type: "POST",
                  cache: false,
                  data: {postId : postId, submit:'',task:'PostController.deletePost'},
                  success: function(html){
                    iitpConnect.renderMessage('Post deleted.','success', 500);
                    setTimeout(function(){ window.location.href = baseUrl + '/post'; }, 600);
                  }
                });
              }
            }
          },
        ]
      });
</script>
	</body>
</html>
