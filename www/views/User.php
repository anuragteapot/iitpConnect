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
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/user/css/main.css">
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
      <p class="title"><?php echo ($user['phonenumber']) ? $user['phonenumber'] : 'Phone No. Not Available' ; ?></p>
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
      <?php if(User::isloggedIn()): ?>
        <button type='button'>Follow</button>
      <?php endif; ?>
      <p><button type="button" onclick="location.href='mailto:<?php echo $user['email']; ?>'">Contact</button></p>
    </div>
  </div>
</body>
</html>
