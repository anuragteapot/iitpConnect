<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 Routes::setRoute('home', function() {
     HomeController::CreateView('home');
     HomeController::execute();
 });

 Routes::setRoute('login', function() {
     LoginController::CreateView('login');
     LoginController::execute();
 });
