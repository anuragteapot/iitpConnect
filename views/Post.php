<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 $session = new Session;
 $app     = new PostController;

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
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>media/post/css/main.css" />
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
                <li><a href="<?php echo BASE_URL; ?>post?t=0">Notice</a></li>
								<li><a href="<?php echo BASE_URL; ?>post?t=1.2">Lost / Found</a></li>
								<li><a href="<?php echo BASE_URL; ?>post?t=3.4">Buy / Sell</a></li>
								<li><a href="<?php echo BASE_URL; ?>post?t=5">Cab Share </a></li>
                <li><a href="<?php echo BASE_URL; ?>post?t=6">Help</a></li>
							</ul>
						</nav>
						<nav class="main">
							<ul>
								<li class="search">
									<a class="fa-search" href="#search">Search</a>
									<form id="search" method="get" action="#">
										<input type="text" name="query" placeholder="Search" />
									</form>
								</li>
							</ul>
						</nav>
					</header>
				<!-- Main -->
					<div id="main">
							<article class="post">
								<header>
									<div class="title">
										<h3><a><?php echo $rows['title']; ?></a></h3>
									</div>
									<div class="meta">
										<time class="published" datetime="2015-11-01"><?php echo $rows['entryDate']; ?></time>
										<a href="<?php echo BASE_URL ?>user?u=<?php echo $rows['username']; ?>" class="author"><span class="name">By <?php echo $rows['username']; ?></span>

                    <?php if(file_exists(BASE_PATH . '/uploads/' . $rows['username'] . '/profileimage')) : ?>
                        <img src="<?php echo BASE_URL . 'uploads/' . $rows['username'] . '/profileimage'; ?>" class="avatar img-circle img-thumbnail" alt="avatar" /></a>
                      <?php else:?>
                        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar" /></a>
                    <?php endif;?>
                  </div>
								</header>
                  <div>
                    <?php echo $rows['message']; ?>
                  </div>
                <footer>
                  <ul class="actions">
                    <?php if($rows['type'] == 1) : ?>
                      <li><a href="" class="button large">Claim</a></li>
                    <?php elseif($rows['type'] == 4) : ?>
                      <li><a href="" class="button large">Checkout</a></li>
                    <?php endif;?>
                  </ul>
                  <ul class="stats">
                    <li style="font-size:25px;">
                      <?php if($rows['type'] == 0) : ?>
                        <a class="badge badge-info">NOTICE</a>
                      <?php elseif($rows['type'] == 1) : ?>
                        <p class="badge badge-danger">LOST</p>
                      <?php elseif($rows['type'] == 2) : ?>
                        <p class="badge badge-success">FOUND</p>
                      <?php elseif($rows['type'] == 3) : ?>
                        <p class="badge badge-success">BUY</p>
                      <?php elseif($rows['type'] == 4) : ?>
                        <a class="badge badge-info">SELL</a>
                      <?php elseif($rows['type'] == 5) : ?>
                        <p class="badge badge-primary">CAB SHARE</p>
                      <?php elseif($rows['type'] == 6) : ?>
                        <p class="badge badge-warning">HELP</p>
                      <?php endif; ?>
                    </li>
                    <li><a style="font-size:25px;" href="#" class="icon fa-heart">28</a></li>
                  </ul>
                </footer>
							</article>
					</div>

				<!-- Sidebar -->
					<section id="sidebar">
						<!-- Posts List -->
							<section>
								<ul class="posts">
                  <?php  while ($rows = $posts->fetch_assoc()) { ?>
									<li>
										<article>
											<header>
												<h3><a href="<?php echo BASE_URL; ?>post?t=<?php ?>"><?php echo $rows['title']; ?></a></h3>
												<time class="published" datetime="2015-10-20"><?php echo $rows['entryDate']; ?></time>

                        <?php if($rows['type'] == 1) : ?>
                            <p class="badge badge-danger">LOST</p>
                          <?php elseif($rows['type'] == 2) : ?>
                            <p class="badge badge-info">FOUND</p>
                          <?php elseif($rows['type'] == 3) : ?>
                            <p class="badge badge-primary">BUY</p>
                          <?php elseif($rows['type'] == 5) : ?>
                            <p class="badge badge-success">SELL</p>
                        <?php endif; ?>

                      </header>
                      <a href="<?php echo BASE_URL ?>user?u=<?php echo $rows['username']; ?>" class="image">
                        <?php if(file_exists(BASE_PATH . '/uploads/' . $rows['username'] . '/profileimage')) : ?>
                            <img src="<?php echo BASE_URL . 'uploads/' . $rows['username'] . '/profileimage'; ?>" class="avatar img-circle img-thumbnail" alt="avatar" /></a>
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
									<a href="#" class="button">Load More</a>
                  <a href="<?php echo BASE_URL; ?>" class="button">Home</a>
							</section>

						<!-- Footer -->
							<section id="footer">
								<ul class="icons">
									<li><a href="#" class="fa-twitter"><span class="label">Twitter</span></a></li>
									<li><a href="#" class="fa-facebook"><span class="label">Facebook</span></a></li>
									<li><a href="#" class="fa-instagram"><span class="label">Instagram</span></a></li>
									<li><a href="#" class="fa-rss"><span class="label">RSS</span></a></li>
									<li><a href="#" class="fa-envelope"><span class="label">Email</span></a></li>
								</ul>
							</section>

					</section>
			</div>

		<!-- Scripts -->
			<script src="<?php echo BASE_URL; ?>media/post/js/jquery.min.js"></script>
			<script src="<?php echo BASE_URL; ?>media/post/js/browser.min.js"></script>
			<script src="<?php echo BASE_URL; ?>media/post/js/breakpoints.min.js"></script>
			<script src="<?php echo BASE_URL; ?>media/post/js/util.js"></script>
      <script src="<?php echo BASE_URL; ?>templates/js/message.js"></script>
			<script src="<?php echo BASE_URL; ?>media/post/js/main.js"></script>
	</body>
</html>
