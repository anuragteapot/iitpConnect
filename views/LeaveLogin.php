
<html>
<head>
  <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script defer src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/system/css/core.css" />
  <script src="<?php echo BASE_URL; ?>media/system/js/core.js"></script>
  <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>templates/images/logo.svg">
  <style>
  body{ background-image: url('<?php echo BASE_URL; ?>/templates/images/back.jpg'); background-repeat:no-repeat; background-position:center; background-size:cover; padding:10px;}

  body, html{
    width: 100%;
    height: 100%;
  }

  #state {
    text-align: center;
    border-radius: 5px;
  }

  .error{
    background: rgb(247, 0, 0,0.85);
    color: white;
  }

  .success {
    background: rgb(0, 204, 102, 0.85);
    color: white;
  }
  </style>
</head>
<body>
  <div style="display:none;" class="bar" id="loader"><div></div></div>
  <div id="snackbar"></div>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <div id="contact">
              <div id="state">
                <h1 id="response"></h1>
              </div>
              <br>
              <a id="redirect"></a>
              <h3 style="padding:10px;" class="card-title text-center">Faculty Login</h3>
              <form class="form-signin">
                <div class="form-label-group">
                  <input type="text" id="username" class="form-control" placeholder="Username" required autofocus>
                  <label for="inputEmail">Username</label>
                </div>

                <div class="form-label-group">
                  <input type="password" id="userpassword" class="form-control" placeholder="Password" required>
                  <label for="inputPassword">Password</label>
                </div>

                <div class="custom-control custom-checkbox mb-3">
                  <input type="checkbox" class="custom-control-input" id="customCheck1">
                  <input hidden type="text" id="token" value="<?php $config = new Config(); echo $config->secret; ?> ">
                  <label class="custom-control-label" for="customCheck1">Remember password</label>
                </div>
                <a id="login" class="btn btn-lg btn-primary btn-block text-uppercase" >Sign in</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script src="<?php echo BASE_URL; ?>media/leave/js/login.js"></script>
  </html>
