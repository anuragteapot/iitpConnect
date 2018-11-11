<?php

defined('_EXEC') or die;

$router = new Router;

if($router->get('u'))
{
  $use = $router->get('u');
  $user = User::getUser($use);
}
else
{
  header('Location: ' . BASE_URL);
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>templates/images/logo.svg">
  <style>
  .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    max-width: 500px;
    margin: auto;
    text-align: center;
    background-color: white;
  }

  .title {
    color: grey;
    font-size: 18px;
  }

  button {
    border: none;
    outline: 0;
    display: inline-block;
    padding: 8px;
    color: white;
    background-color: #000;
    text-align: center;
    cursor: pointer;
    width: 100%;
    font-size: 18px;
  }

  a {
    text-decoration: none;
    font-size: 22px;
    color: black;
  }

  button:hover, a:hover {
    opacity: 0.7;
  }
  body
  {
    background-color: #5b458f !important;

  }

  body
  {
    background-image: url('<?php echo BASE_URL; ?>/templates/images/back.png');
    background-repeat: no-repeat;
    background-size: contain;
  }

  #container{
    padding: 150px 0px;
  }
</style>
</head>
<body>
  <?php if(!$user):
    require_once PATH_TEMPLATES . '/404.php';
    exit();
  endif;
  ?>
  <div id="container">
    <div class="card">
      <p><button>User Profile</button></p>
      <?php if(file_exists(BASE_PATH . '/uploads/' . sha1('iitp' . $use . 'upload') . '/' . sha1('user-profile') . '/profileimage')) : ?>
        <img src="<?php echo BASE_URL . 'uploads/' . sha1('iitp' . $use . 'upload') . '/' . sha1('user-profile') . '/profileimage'; ?>"  alt="avatar" /></a>
      <?php else:?>
        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar" /></a>
      <?php endif;?>
      <h1><?php echo $user['name']; ?></h1>
      <p class="title"><?php echo $user['email']; ?></p>
      <p class="title"><?php echo $user['phonenumber']; ?></p>
      <h3>Institute</h3>
      <p class="title"><?php echo $user['institute']; ?></p>
      <h3>Address</h3>
      <p class="title"><?php echo $user['address']; ?></p>
      <p><?php echo $user['params']; ?></p>
      <div style="margin: 24px 0;">
        <a href="#"><i class="fa fa-dribbble"></i></a>
        &nbsp;
        <a href="#"><i class="fa fa-twitter"></i></a>
        &nbsp;
        <a href="#"><i class="fa fa-linkedin"></i></a>
        &nbsp;
        <a href="#"><i class="fa fa-facebook"></i></a>
      </div>
      <p><button>Contact</button></p>
    </div>
  </div>
</body>
</html>
