<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
?>
 <!DOCTYPE HTML>
 <html>
 	<head>
 		<title>Installation</title>
 		<meta charset="utf-8" />
 		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
 		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 		<link rel="stylesheet" href="<?php echo BASE_URL; ?>media/login/css/main.css" />
 		<link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/css/HoldOn.css" />
 	</head>
 	<body>
 		<div class="container">
 		  <div id="contact">
 				<br>
 				<a id="redirect"></a>
 				<div id="field">
 					<h3>Login</h3>
 					<br>
 		    	<fieldset>
 		      	<input id="username" placeholder="Username" type="text" tabindex="3" required>
 		    	</fieldset>
 		    	<fieldset>
 		      	<input id="userpassword" placeholder="Password" type="password" tabindex="4" required>
 		    	</fieldset>
 		    	<fieldset>
 		      	<button id="login">Login</button>
 		    	</fieldset>
          <br>
          <fieldset>
            <a id="redirect" href="<?php echo substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], 'login')); ?>register" style="display:block">Register</a>
          </fieldset>
 				</div>
 		  </div>
 		</div>
 	</body>
 	<script src="<?php echo BASE_URL; ?>media/login/js/main.js"></script>
 </html>
