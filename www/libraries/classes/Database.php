<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_EXEC') or die;

class Database {

  // DATABASE configuration

	private static $server;
	private static $dbname;
	private static $dbpassword;
	private static $db;

	public $conn;

	public function __construct()
	{

    $config = new Config();

    self::$server     = $config->host;
    self::$dbname     = $config->dbusername;
    self::$dbpassword = $config->dbpassword;
    self::$db         = $config->db;

		$this->conn = new mysqli(self::$server, self::$dbname, self::$dbpassword, self::$db);

    if($this->conn->connect_error) {
			throw new \Exception("Could not connect to database", $this->conn->sqlstate);
      die();
    }
	}

	public function getDBO()
	{
		return $this->conn;
	}

	public function disconnect()
	{
		$this->conn->close();
	}
}
