<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 $session = new Session;
 $app = new PostController;

 if(isset($_GET['t']))
 {
   $t = $_GET['t'];
 }
 else {
   $t = 12;
 }

 $posts = $app->fetchPost();
 $row = $posts->fetch_assoc();
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Future Imperfect by HTML5 UP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>media/post/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">

            <?php if($t==12): ?>
						<h1><a href="">Lost | Found</a></h1>
            <?php else: ?>
              <h1><a href="">Buy | Sell</a></h1>
            <?php endif; ?>
						<nav class="links">
							<ul>
								<li><a href="<?php echo BASE_URL; ?>post?t=12">Lost | Found</a></li>
								<li><a href="<?php echo BASE_URL; ?>post?t=34">Buy | Sell</a></li>
                <li><a href="<?php echo BASE_URL; ?>">HOME</a></li>
								<!-- <li><a href="<?php echo BASE_URL; ?>post?t=56">Cab Share</a></li> -->
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

          <?php  if($posts->num_rows > 0) : ?>
				<!-- Main -->
					<div id="main">

						<!-- Post -->
							<article class="post">
								<header>
									<div class="title">
										<h2><a><?php echo $row['title']; ?></a></h2>
									</div>
									<div class="meta">
										<time class="published" datetime="2015-11-01"><?php echo $row['entryDate']; ?></time>
										<!-- <a href="#" class="author"><span class="name"></span><img src="images/avatar.jpg" alt="" /></a> -->
									</div>
								</header>
                <?php echo $row['message']; ?>
								<footer>
									<ul class="actions">
										<li><a href="" class="button large">Claim</a></li>
									</ul>
									<ul class="stats">
                    <?php if($row['type'] == 1) : ?>
                      <li><a href="#" style="font-size:15px;color:red;">LOST</a></li>
                    <?php elseif($row['type'] == 2) : ?>
                      <li><a href="#" style="font-size:15px;color:green;">FOUND</a></li>
                    <?php elseif($row['type'] == 3) : ?>
                      <li><a href="#" style="font-size:20px;">BUY</a></li>
                    <?php elseif($row['type'] == 5) : ?>
                      <li><a href="#" style="font-size:20px;">SELL</a></li>
                    <?php endif; ?>

                    <?php if($row['status']): ?>
										<li><a style="font-size:40px;color:red;"><i class="fa fa-user-times"></i></a></li>
                  <?php else: ?>
                    <li><a style="font-size:40px;color:green;"><i class="fa fa-user"></i></a></li>
                  <?php endif; ?>
									</ul>
								</footer>
							</article>

						<!-- Pagination -->
							<!-- <ul class="actions pagination">
								<li><a href="" class="disabled button large previous">Previous Page</a></li>
								<li><a href="#" class="button large next">Next Page</a></li>
							</ul> -->

					</div>

				<!-- Sidebar -->
					<section id="sidebar">

						<!-- Posts List -->
							<section>
								<ul class="posts">
                  <?php  while ($row = $posts->fetch_assoc()) { ?>
									<li>
										<article>
											<header>
												<h3><a href="<?php echo BASE_URL; ?>post?t="><?php echo $row['title']; ?></a></h3>
												<time class="published" datetime="2015-10-20"><?php echo $row['entryDate']; ?></time>
											</header>
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
      <?php else: ?>
        <h1 style="float:center">Nothing to show.</h1>
      <?php endif; ?>
			</div>

		<!-- Scripts -->
			<script src="<?php echo BASE_URL; ?>media/post/js/jquery.min.js"></script>
			<script src="<?php echo BASE_URL; ?>media/post/js/browser.min.js"></script>
			<script src="<?php echo BASE_URL; ?>media/post/js/breakpoints.min.js"></script>
			<script src="<?php echo BASE_URL; ?>media/post/js/util.js"></script>
			<script src="<?php echo BASE_URL; ?>media/post/js/main.js"></script>
	</body>
</html>
