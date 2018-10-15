<!DOCTYPE HTML>
<html>
	<head>
		<title>Phantom by HTML5 UP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/css/main.css" />
		<link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>templates/images/logo.jpg">
		<noscript><link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">
		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<div class="inner">

							<!-- Logo -->
								<a href="" class="logo">
									<span class="symbol"><img src="<?php echo BASE_URL; ?>templates/images/logo.svg" alt="" /></span><span class="title">IITP-CONNECT</span>
								</a>

							<!-- Nav -->
								<nav>
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
							<li><a href="">Home</a></li>
							<li><a href="">Profile</a></li>
							<li><a href="">About</a></li>
							<li><a href="">Register</a></li>
							<?php if(!User::isLoggedIn()) :  ?>
								<li><a id="login" href="<?php echo BASE_URL; ?>login">Login</a></li>
							<?php else : ?>
								<li><p style="cursor" id="logoutuser">Logout</p></li>
							<?php endif; ?>
						</ul>
					</nav>

				<!-- Main -->
					<div id="main">
						<div class="inner">
							<header>
								<h1>This is Phantom, a free, fully responsive site<br />
								template designed by <a href="http://html5up.net">HTML5 UP</a>.</h1>
							</header>
							<section class="tiles">
								<article class="style1">
									<span class="image">
										<img src="<?php echo BASE_URL; ?>templates/images/pic01.jpg" alt="" />
									</span>
									<a href="generic.html">
										<h2>Magna</h2>
										<div class="content">
											<p>Sed nisl arcu euismod sit amet nisi lorem etiam dolor veroeros et feugiat.</p>
										</div>
									</a>
								</article>
								<article class="style2">
									<span class="image">
										<img src="<?php echo BASE_URL; ?>templates/images/pic02.jpg" alt="" />
									</span>
									<a href="generic.html">
										<h2>Lorem</h2>
										<div class="content">
											<p>Sed nisl arcu euismod sit amet nisi lorem etiam dolor veroeros et feugiat.</p>
										</div>
									</a>
								</article>
								<article class="style3">
									<span class="image">
										<img src="<?php echo BASE_URL; ?>templates/images/pic03.jpg" alt="" />
									</span>
									<a href="generic.html">
										<h2>Feugiat</h2>
										<div class="content">
											<p>Sed nisl arcu euismod sit amet nisi lorem etiam dolor veroeros et feugiat.</p>
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
								<h2>Get in touch</h2>
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
									<li><a href="#" class="icon style2 fa-twitter"><span class="label">Twitter</span></a></li>
									<li><a href="#" class="icon style2 fa-facebook"><span class="label">Facebook</span></a></li>
									<li><a href="#" class="icon style2 fa-instagram"><span class="label">Instagram</span></a></li>
									<li><a href="#" class="icon style2 fa-dribbble"><span class="label">Dribbble</span></a></li>
									<li><a href="#" class="icon style2 fa-github"><span class="label">GitHub</span></a></li>
									<li><a href="#" class="icon style2 fa-500px"><span class="label">500px</span></a></li>
									<li><a href="#" class="icon style2 fa-phone"><span class="label">Phone</span></a></li>
									<li><a href="#" class="icon style2 fa-envelope-o"><span class="label">Email</span></a></li>
								</ul>
							</section>
							<ul class="copyright">
								<li>&copy; Untitled. All rights reserved</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
							</ul>
						</div>
					</footer>

			</div>

		<!-- Scripts -->
			<script src="<?php echo BASE_URL; ?>templates/js/jquery.min.js"></script>
			<script src="<?php echo BASE_URL; ?>templates/js/browser.min.js"></script>
			<script src="<?php echo BASE_URL; ?>templates/js/breakpoints.min.js"></script>
			<script src="<?php echo BASE_URL; ?>templates/js/util.js"></script>
			<script src="<?php echo BASE_URL; ?>templates/js/main.js"></script>
			<script src="<?php echo BASE_URL; ?>templates/js/system.js"></script>

	</body>
</html>
