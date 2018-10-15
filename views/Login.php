<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

if(User::isLoggedIn())
{
  header('Location: ' . substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '/login')));
}
?>
 <!DOCTYPE HTML>
 <html>
 	<head>
 		<title>Login</title>
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
          <fieldset >
            <input hidden type="text" id="token" value="<?php $config = new Config(); echo $config->secret; ?> ">
          </fieldset>
 				</div>
 		  </div>
 		</div>
 	</body>
 	<script src="<?php echo BASE_URL; ?>media/login/js/main.js"></script>
 </html>
