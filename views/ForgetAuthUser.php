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

 $app = new AuthUserForgetController;
 $router = new Router;

 if(!isset($_SESSION['resetusername']) && !isset($_SESSION['resetemail']))
 {
   if(!empty($router->get('e')))
   { ?>
     <!DOCTYPE HTML>
       <html>
       	<head>
       		<title>Activation</title>
       		<meta charset="utf-8" />
       		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
       		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
       		<link rel="stylesheet" href="<?php echo BASE_URL; ?>media/login/css/main.css" />
          <style>
          body
          {
              background-color: #f5f7fa;
          }

          #cancel
          {
            text-decoration:none;
            font-size: 20px;
          }
          </style>
       	</head>
       	<body>
           <div id="snackbar"></div>
       		<div class="container">
       		  <div id="contact">
               <?php if(!empty($router->get('m'))) : ?>
              <div id="state" class="success">
                <h1 id="response"><?php echo urldecode($router->get('m')); ?></h1>
              </div>
            <?php else: ?>
              <div id="state" class="error">
                <?php  if(!empty($router->get('e'))) : ?>
                <h1 id="response"><?php echo urldecode($router->get('e')); ?></h1>
              <?php else: ?>
                 <h1 id="response">Something goes wrong.</h1>
               <?php endif; ?>
              </div>
            <?php endif; ?>
            <br>
            <a href="<?php echo BASE_URL; ?>"style="display:block;" id="redirect">Home</a>
       	</body>
       </html>
       <?php
   }
   else
   {
     header('Location: ' . BASE_URL);
   }
 }
 else { ?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Register</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/system/css/core.css" />
    <script src="<?php echo BASE_URL; ?>media/system/js/core.js"></script>
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>media/login/css/main.css" />
		<style>
		body
		{
			  background-color: #f5f7fa;
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
					<h3>New Password</h3>
					<br>
					<fieldset>
						<input id="password1" placeholder="New Password" type="password" tabindex="1" required autofocus>
					</fieldset>
          <fieldset>
            <input id="password2" placeholder="Retype Password" type="password" tabindex="1" required autofocus>
          </fieldset>
            <input style="display:none;" id="username" value="<?php echo $_SESSION['resetusername']; ?>"  type="text" tabindex="1" required autofocus>
            <input style="display:none;" value="<?php echo $_SESSION['resetemail']; ?>" id="email"  type="email" tabindex="1" required autofocus>
		      	<button id="login">Reset</button>
		    	</fieldset>
          <br>
          <br>
          <div style="text-align:center;">
          <a style=" float:left;" id="cancel" href="<?php echo BASE_URL; ?>">Cancel</a>
          <a style=" float:right;" id="cancel" href="<?php echo BASE_URL; ?>login">Login</a>
          <div>
					<fieldset >
						<input hidden type="text" id="token" value="<?php $config = new Config(); echo $config->secret; ?> ">
					</fieldset>
				</div>
		  </div>
		</div>
	</body>
	<script src="<?php echo BASE_URL; ?>media/forget/js/reset.js"></script>
</html>

<?php } ?>
