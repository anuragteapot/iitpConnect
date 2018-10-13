<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

class HomeController extends BaseController
{
  public function execute()
  {
    $mysql = new Factory();
    $db = $mysql->getDBO();

    $result  = $db->query('select * from Paper_author');

    if($result)
    {
       print_r($result->fetch_assoc());
    }

    $db->connect_error;
  }
}
