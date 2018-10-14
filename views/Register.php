<!DOCTYPE HTML>
<html>
	<head>
		<title>Installation</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>media/login/css/main.css" />
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
					<h3>Register</h3>
					<br>
          <fieldset>
            <input id="name" placeholder="Name" type="text" tabindex="1" required autofocus>
          </fieldset>
					<fieldset>
						<input id="username" placeholder="Username" type="text" tabindex="1" required autofocus>
					</fieldset>
					<fieldset>
						<input id="password" placeholder="Password" type="password" tabindex="1" required autofocus>
					</fieldset>
		    	<fieldset>
		      	<input id="uemail" placeholder="Email" type="email" tabindex="2" required>
		    	</fieldset>
		    	<fieldset>
		      	<input id="secret" placeholder="Secret key" type="password" tabindex="3" required>
		    	</fieldset>
		    	<fieldset>
		      	<button id="login">Register</button>
		    	</fieldset>
				</div>
		  </div>
		</div>
	</body>
	<script src="<?php echo BASE_URL; ?>media/register/js/main.js"></script>
</html>
