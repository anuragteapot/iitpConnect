<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

define('_EXEC', 1);

// function get_status_for_permission($dir)
// {
//   $dh = new DirectoryIterator($dir);
//
//   foreach ($dh as $item)
//   {
//     if (!$item->isDot())
//     {
//       if ($item->isDir())
//       {
//         if(get_status_for_permission("$dir/$item"))
//         {
//           return 1;
//         }
//       }
//       else
//       {
//         $fp = fileperms($dir."/".$item);
//         $fpi =  (int)substr(sprintf('%o', $fp), -4);
//         if($fpi < 644)
//         {
//           return 1;
//         }
//       }
//     }
//   }
// }
//
// $dir = dirname(__DIR__);
// $count = get_status_for_permission($dir);
//
// if($count >0)
// {
//   die(
//     file_get_contents(dirname(__FILE__) . '/templates/permission_require.php')
//   );
// }

header('Location: ' . substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '/installation')));
// require_once __DIR__ . '/templates/install.html';
//
// if(file_exists(dirname(__DIR__) . '/configuration.php'))
// {
//
//   exit;
// }
