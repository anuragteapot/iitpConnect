<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
 defined('_EXEC') or die;

 if(User::isLoggedIn())
 {
   header('Location: ' . BASE_URL);
 }
?>
 <!DOCTYPE HTML>
 <html>
 	<head>
 		<title>Login</title>
 		<meta charset="utf-8" />
 		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
 		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/system/css/core.css" />
    <script src="<?php echo BASE_URL; ?>media/system/js/core.js"></script>
 		<link rel="stylesheet" href="<?php echo BASE_URL; ?>media/login/css/main.css" />
 		<link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/css/HoldOn.css" />
    <style>
    body
    {
      background-color: #f3f7f7;
    }

    #cancel
    {
      text-decoration:none;
      font-size: 20px;
    }
    </style>
 	</head>
 	<body>
    <span style="display:none;" id="loader" class="_it4vx _72fik"></span>
    <div id="snackbar"></div>
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
          <br>
          <div style="text-align:center;">
          <a style=" float:left;" id="cancel" href="<?php echo BASE_URL; ?>">Cancel</a>
          <a style=" float:center;" id="cancel" href="<?php echo BASE_URL; ?>forget">Forget?</a>
          <a style=" float:right;" id="cancel" href="<?php echo BASE_URL; ?>register">Register</a>
          <div>
          <fieldset >
            <input hidden type="text" id="token" value="<?php $config = new Config(); echo $config->secret; ?> ">
          </fieldset>
 				</div>
 		  </div>
 		</div>
 	</body>
 	<script src="<?php echo BASE_URL; ?>media/login/js/main.js"></script>
 </html>
