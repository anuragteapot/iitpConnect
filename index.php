<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Define the application's minimum supported PHP version as a constant so it can be referenced within the application.
 */
define('IITPCONNECT_MINIMUM_PHP', '7.0');

if (version_compare(PHP_VERSION, IITPCONNECT_MINIMUM_PHP, '<'))
{
	die(
		str_replace(
			'{{PHP_VERSION}}',
			IITPCONNECT_MINIMUM_PHP,
			file_get_contents(dirname(__FILE__) . '/templates/incompatible.html')
		)
	);
}

define('_EXEC', 1);

// Run the application - All executable code should be triggered through this file
require_once dirname(__FILE__) . '/includes/app.php';
