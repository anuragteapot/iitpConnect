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
 		<link rel="stylesheet" href="media/login/css/main.css" />
 		<link rel="stylesheet" href="templates/css/HoldOn.css" />
 	</head>
 	<body>
 		<div class="container">
 		  <div id="contact">
 				<div id="state">
 					<h1 id="response"></h1>
 				</div>
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
 				</div>
 		  </div>
 		</div>
 	</body>
 	<script src="media/login/js/main.js"></script>
 	<script src="templates/js/HoldOn.js"></script>
 	<script src="templates/js/sha512.js"></script>
 </html>
