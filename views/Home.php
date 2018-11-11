<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 defined('_EXEC') or die;

 $session = new Session;
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>iitpConnect</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/system/css/core.css" />
    <script src="<?php echo BASE_URL; ?>media/system/js/core.js"></script>
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/css/main.css" />
		<link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>templates/images/logo.svg">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129056695-1"></script>
		<noscript><link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">
    <div style="display:none;" id="backdrop" class="modal-backdrop fade show"></div>
    <div style="display:none;" class="bar" id="loader"><div></div></div>
    <nav id="navbar1" class="">
      <div class="nav-wrapper1">

        <?php if(!User::isLoggedIn()) :  ?>
          <ul>
            <li><input id="username" class="nav-input" placeholder="Username" type="text"></li>
            <li><input id="userpassword" class="nav-input" placeholder="Password" type="password"></li>
            <li><a id="login" href="javascript:void(0);" class="nav-input-login">Login</a></li>
            <li><a class="nav-input-login" href="<?php echo BASE_URL; ?>register">Register</a></li>
          </ul>
        <?php else : ?>
            <ul>
          <li><a id="logoutuser" href="javascript:void(0);" class="nav-input-login">Logout</a></li>
            </ul>
        <?php endif; ?>

        <ul id="menu1">
          <li><a id="menu-item" href="javascript:void(0);">Home</a></li>
          <li><a id="menu-item" href="javascript:void(0);">Services</a></li>
          <li><a id="menu-item" href="javascript:void(0);">About</a></li>
          <li><a id="menu-item" href="javascript:void(0);">Contact</a></li>
          <?php if(User::isLoggedIn()) :  ?>
            <li><a id="menu-item" href="<?php echo BASE_URL; ?>profile"><?php echo $session->get('name');?> (<?php echo $session->get('username');?>)</a></li>
          <?php endif;  ?>
        </ul>
      </div>
    </nav>

		<!-- Wrapper -->
    <div id="snackbar"></div>
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<div class="inner">

							<!-- Logo -->
								<a href="" class="logo">
									<span class="symbol"><img src="<?php echo BASE_URL; ?>templates/images/logo.svg" alt="" /></span><span class="title">IITP-CONNECT</span>
								</a>

							<!-- Nav -->
								<nav class="mobile-menu">
									<ul>
										<li><a href="#menu">Menu</a></li>
									</ul>
								</nav>

						</div>
					</header>

				<!-- Menu -->
					<nav id="menu">
						<h2>Menu</h2>
						<ul>
							<?php if(User::isLoggedIn()) :  ?>
								<li><a href="<?php echo BASE_URL; ?>profile"><?php echo $session->get('name');?> (<?php echo $session->get('username');?>)</a></li>
							<?php endif;  ?>
              <li><a href="<?php echo BASE_URL; ?>post/page/t/12">Lost/Found</a></li>
              <li><a href="<?php echo BASE_URL; ?>post/page/t/34">Buy/Sell</a></li>
              <li><a href="<?php echo BASE_URL; ?>post/cab/">Cab Share</a></li>
              <li><a href="">About</a></li>
							<?php if(!User::isLoggedIn()) :  ?>
								<li><a href="<?php echo BASE_URL; ?>register">Register</a></li>
								<li><a id="login" href="<?php echo BASE_URL; ?>login">Login</a></li>
							<?php else : ?>
								<li><p style="cursor:pointer;" id="logoutuser">Logout</p></li>
							<?php endif; ?>
						</ul>
					</nav>

				<!-- Main -->
					<div id="main">
						<div class="inner">
							<header>
								<h1>Find lost product, buy or sell and share your cab.</h1>
							</header>
							<section class="tiles">
								<article class="style1">
									<span class="image">
										<img src="<?php echo BASE_URL; ?>templates/images/pic01.jpg" alt="" />
									</span>
									<a href="<?php echo BASE_URL; ?>post/page/t/12">
										<h2>Lost/Found</h2>
										<div class="content">
											<p>Find your lost item or share the information over internet if you found any item.</p>
										</div>
									</a>
								</article>
								<article class="style2">
									<span class="image">
										<img src="<?php echo BASE_URL; ?>templates/images/pic02.jpg" alt="" />
									</span>
									<a href="<?php echo BASE_URL; ?>post/page/t/34">
										<h2>Buy/Sell</h2>
										<div class="content">
											<p>Sell your products or buy products.</p>
										</div>
									</a>
								</article>
								<article class="style3">
									<span class="image">
										<img src="<?php echo BASE_URL; ?>templates/images/pic03.jpg" alt="" />
									</span>
									<a href="<?php echo BASE_URL; ?>post/cab/">
										<h2>Cab share</h2>
										<div class="content">
											<p>Save money by sharing cab with others.</p>
										</div>
									</a>
								</article>
							</section>
						</div>
					</div>

				<!-- Footer -->
					<footer id="footer">
						<div class="inner">
							<section>
								<h2>Send feedback</h2>
								<form method="post" action="#">
									<div class="fields">
										<div class="field half">
											<input type="text" name="name" id="name" placeholder="Name" />
										</div>
										<div class="field half">
											<input type="email" name="email" id="email" placeholder="Email" />
										</div>
										<div class="field">
											<textarea name="message" id="message" placeholder="Message"></textarea>
										</div>
									</div>
									<ul class="actions">
										<li><input type="submit" value="Send" class="primary" /></li>
									</ul>
								</form>
							</section>
							<section>
								<h2>Follow</h2>
								<ul class="icons">
									<li><a href="https://twitter.com/anu1601cs" class="icon style2 fa-twitter"><span class="label">Twitter</span></a></li>
									<li><a href="https://www.facebook.com/Anu1601cs" class="icon style2 fa-facebook"><span class="label">Facebook</span></a></li>
									<li><a href="https://www.instagram.com/anu1601cs/" class="icon style2 fa-instagram"><span class="label">Instagram</span></a></li>
									<li><a href="https://github.com/Anu1601CS" class="icon style2 fa-github"><span class="label">GitHub</span></a></li>
									<li><a href="mailto:anurag.cs16@iitp.ac.in" class="icon style2 fa-envelope-o"><span class="label">Email</span></a></li>
								</ul>
							</section>
							<ul style="color:white;text-align:center;" class="copyright">
								<li>&copy; iitpConnect . All rights reserved</li><li>Created by <a href="https://anu1601cs.github.io/my_web/">Anurag (@anu1601cs)</a>.</li>
							</ul>
						</div>
					</footer>
          <input style="display:none;" hidden type="text" id="token" value="<?php $config = new Config(); echo $config->secret; ?> ">
			</div>

		<!-- Scripts -->
			<script src="<?php echo BASE_URL; ?>templates/js/jquery.min.js"></script>
			<script src="<?php echo BASE_URL; ?>templates/js/browser.min.js"></script>
			<script src="<?php echo BASE_URL; ?>templates/js/breakpoints.min.js"></script>
			<script src="<?php echo BASE_URL; ?>templates/js/util.js"></script>
			<script src="<?php echo BASE_URL; ?>templates/js/main.js"></script>
      <script src="<?php echo BASE_URL; ?>media/home/js/main.js"></script>
	</body>
</html>
