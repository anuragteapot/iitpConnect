<?php

require_once '../configuration.php';
require_once '../libraries/classes/ResizeImage.php';


$config = new Config();
define('BASE_URL', $config->baseurl);

if(!isset($_POST['tok']))
{
  die();
}

$imageFolder = "../uploads/" . sha1('iitp' . $_POST['username'] . 'upload') . "/";

reset($_FILES);
$temp = current($_FILES);

if(isset($_POST['username']) && isset($_POST['profileimage']))
{
  $imageFolder = "../uploads/" . sha1('iitp' . $_POST['username'] . 'upload') . '/' . sha1('user-profile') . '/';

  if (!file_exists($imageFolder)) {
    mkdir($imageFolder, 0777, true);
  }

  $fileinfo = @getimagesize($temp['tmp_name']);
  $width = $fileinfo[0];
  $height = $fileinfo[1];

  if ($width > "200" || $height > "200")
  {
    $result = array('response' => 'error', 'text' => 'Profile image should be less than or equal to 200 * 200 ');
    echo json_encode($result);
    return;
  }
}

if(is_uploaded_file($temp['tmp_name']))
{
    // Sanitize input
    if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name']))
    {
      $result = array('response' => 'error', 'text' => 'Invalid file name.');
      echo json_encode($result);
      return;
    }

    // Verify extension
    if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png", "jpeg")))
    {
      $result = array('response' => 'error', 'text' => 'Invalid extension.');
      echo json_encode($result);
      return;
    }

    // Accept upload if there was no origin, or if it is an accepted origin

    if(isset($_POST['username']) && isset($_POST['profileimage']))
    {

      $newTemp = explode(".", $temp['name']);
      $newfilename = 'profileimage';

      $filetowrite = $imageFolder . $newfilename;
      $res  = move_uploaded_file($temp['tmp_name'], $filetowrite);

      // Respond to the successful upload with JSON.
      $imagePath = "uploads/" . sha1('iitp' . $_POST['username'] . 'upload') . '/' . sha1('user-profile') . '/' . $newfilename . '?' . md5(rand());

      if($res)
      {
        $result = array('response' => 'success', 'text' => 'Profile Image updated.', 'path' => $imagePath);
        echo json_encode($result);
        return;
      }
      else {
        $result = array('response' => 'error', 'text' => 'Error on upload.', 'path' => $imagePath);
        echo json_encode($result);
        return;
      }

    }
    else
    {
      $imageFo = "../uploads/" . sha1('iitp' . $_POST['username'] . 'upload') . '/' . sha1('user-profile') . '/';

      if (!file_exists($imageFo)) {
        mkdir($imageFo, 0777, true);
      }

      $filetowrite = $imageFolder . $temp['name'];
      $res  = move_uploaded_file($temp['tmp_name'], $filetowrite);

      if($res)
      {
        if(isset($_POST['baseurl']))
        {
          echo $_POST['baseurl'] . '/uploads/' . sha1('iitp' . $_POST['username'] . 'upload') . '/'. $temp['name'];
        }
        else
        {
          echo 'uploads/' . sha1('iitp' . $_POST['username'] . 'upload') . '/'. $temp['name'];
        }
      }
      else
      {
        $result = array('response' => 'error', 'text' => 'Server error.', 'path' => $imagePath);
        echo json_encode($result);
        return;
      }
    }

  }
  else
  {
    $result = array('response' => 'error', 'text' => 'Server error image');
    echo json_encode($result);
    return;
  }
