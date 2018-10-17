<?php

$imageFolder = "../uploads/";

reset($_FILES);
$temp = current($_FILES);

if(isset($_POST['username']) && isset($_POST['profileimage']))
{
  $imageFolder = "../uploads/" . $_POST['username'] . '/';

  if (!file_exists($imageFolder)) {
    mkdir($imageFolder, 0777, true);
  }

  $fileinfo = @getimagesize($temp['tmp_name']);
  $width = $fileinfo[0];
  $height = $fileinfo[1];

  if ($width > "200" || $height > "200")
  {
    $result = array('response' => 'error', 'text' => 'Profile image should be less than 300 * 200 ');
    echo json_encode($result);
    exit();
  }
}

if(is_uploaded_file($temp['tmp_name']))
{
    // Sanitize input
    if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name']))
    {
      header("HTTP/1.1 400 Invalid file name.");
      return;
    }

    // Verify extension
    if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png")))
    {
      header("HTTP/1.1 400 Invalid extension.");
      return;
    }

    // Accept upload if there was no origin, or if it is an accepted origin

    $newTemp = explode(".", $temp['name']);
    $newfilename = 'profileimage';

    $filetowrite = $imageFolder . $newfilename;
    $res  = move_uploaded_file($temp['tmp_name'], $filetowrite);

    // Respond to the successful upload with JSON.

    $imagePath = "uploads/" . $_POST['username'] . '/' . $newfilename . '?' . md5(rand());

    if(isset($_POST['username']) && isset($_POST['profileimage']) && $res)
    {
      $result = array('response' => 'success', 'text' => 'Profile Image updated.', 'path' => $imagePath);
      echo json_encode($result);
      exit();
    }
    else
    {
      echo 'uploads/' . $temp['name'];
    }

  }
  else
  {
    $result = array('response' => 'error', 'text' => 'Server error image');
    echo json_encode($result);
    exit();
  }
