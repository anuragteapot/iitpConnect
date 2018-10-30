<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 defined('_EXEC') or die;

 $AuthUser = new AuthUserController;

 $router = new Router;
?>
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
