<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

class Install {

  // Database configuration
	public static $server;
	public static $dbname;
	public static $dbpassword;
	public static $dbtablename;
	public $conn;

  //User information
	public static $name;
  public static $useremail;
	public static $username;
  public static $password;

	public function __construct()
	{
		error_reporting(E_ERROR);

    if(isset($_POST['uname']) && isset($_POST['uhost']))
    {
      self::$server = $_POST['uhost'];
      self::$dbname = $_POST['udatabase'];
      self::$dbpassword = $_POST['udatabasepassword'];
    }

		$mysql = new mysqli(self::$server, self::$dbname, self::$dbpassword);

    if($mysql->connect_error)
		{
			$result = array('response' => 'error', 'text' => 'Could not connect to database ' . self::$dbtablename, 'conn' => $mysql->connect_error);
			echo json_encode($result);
      die();
    }

		// Admin data
		self::$dbtablename = mysqli_real_escape_string($mysql, $_POST['udatabasetablename']);
		self::$name = mysqli_real_escape_string($mysql, $_POST['uname']);
		self::$useremail = mysqli_real_escape_string($mysql, $_POST['uemail']);
		self::$username = mysqli_real_escape_string($mysql, $_POST['uadmin']);
		self::$password = mysqli_real_escape_string($mysql, $_POST['uadminpassword']);

		if(!preg_match("/^[a-zA-Z\s]*$/",self::$name))
		{
			$result = array('response' => 'error', 'text' => 'Name should be alphabatic.', 'message' => self::$name);
			echo json_encode($result);
			exit();
		}

		if(!preg_match('/^[a-zA-Z0-9]*_?[a-zA-Z0-9]*$/', self::$username))
		{
			$result = array('response' => 'error', 'text' => 'Username not valid.' . self::$dbtablename, 'conn' => $mysql->connect_error);
			echo json_encode($result);
			die();
		}

		if(!filter_var(self::$useremail, FILTER_VALIDATE_EMAIL))
		{
			$result = array('response' => 'error', 'text' => 'Email not valid.', 'message' => self::$useremail);
			echo json_encode($result);
			exit();
		}

		if(!preg_match('/^[a-zA-Z0-9]*_?[a-zA-Z0-9]*$/', self::$dbtablename))
		{
			$result = array('response' => 'error', 'text' => 'Database name not valid.' . self::$dbtablename, 'conn' => $mysql->connect_error);
			echo json_encode($result);
			die();
		}

    if($mysql->select_db(self::$dbtablename))
    {
      $result = array('response' => 'error', 'text' => 'Database with ' . self::$dbtablename . ' name already exist.', 'sqlstate' => $mysql->sqlstate, 'conn' => $mysql);
      echo json_encode($result);
      die();
    }

    $sql = 'CREATE DATABASE IF NOT EXISTS ' . self::$dbtablename;
    $res = $mysql->query($sql);

    if(!$res)
    {
      $result = array('response' => 'error', 'text' => 'Could not create database.' . self::$dbtablename , 'sqlstate' => $mysql->sqlstate, 'conn' => $mysql);
      echo json_encode($result);
      die();
    }

    $mysql->close();
	}

	public function connect()
	{
		$this->conn = new mysqli(self::$server, self::$dbname, self::$dbpassword, self::$dbtablename);
		return $this->conn;
	}

	public function disconnect()
	{
		$this->conn->close();
	}

	public function insertData()
	{
		$mysql = $this->connect();

		$sqlFileToExecute = dirname(__DIR__) . '/sql/main.sql';

		$f = fopen($sqlFileToExecute,"r+");
		$sqlFile = fread($f, filesize($sqlFileToExecute));
		$sqlArray = explode(';',$sqlFile);
		foreach ($sqlArray as $stmt)
		{
		  if (strlen($stmt)> 3 && substr(ltrim($stmt),0,2)!='/*')
		  {
				$result = $mysql->query($stmt);
				if(!$mysql->sqlstate != 00000)
				{
					$result = array('response' => 'error', 'text' => 'Error in mysql.' , 'sqlstate' => $mysql->sqlstate);
					echo json_encode($result);
					exit();
					break;
				}
		  }
		}
	}

	public function addAdmin()
	{
		$mysql = $this->connect();

		$sql = "insert into users(name, username, email, password, admin, registerDate, lastvisitDate, activation)
		 			values ('". self::$name ."','". self::$username ."','". self::$useremail ."','". sha1('1601' . self::$password . 'iitp') ."','". 1 ."','". date("Y-m-d") ."','". date("Y-m-d") ."','". 1 ."')";

		$mysql->query($sql);

		if($mysql->connect_error)
		{
			$result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate, 'conn' => $mysql);
			echo json_encode($result);
			exit();
		}
	}

	public function configuration()
	{
		$baseurl  =  substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], 'installation'));

		$data = "<?php
		class Config {
			public \$username = '". self::$username . "';
			public \$useremail = '". self::$useremail ."';
			public \$sitename = 'iitpConnect';
			public \$debug = true;
			public \$dbtype = 'mysqli';
			public \$host = '". self::$server ."';
			public \$dbusername = '". self::$dbname ."';
			public \$dbpassword = '". self::$dbpassword ."';
			public \$db = '". self::$dbtablename ."';
			public \$secret = '" . md5("1601" . self::$useremail . self::$username . "iitp") . "';
			public \$error_reporting = 'default';
			public \$baseurl = '". $baseurl ."';
		}";

		$filename = substr(dirname(__DIR__), 0, strpos(dirname(__DIR__), '/installation')) . '/configuration.php';
		file_put_contents($filename, $data);
		chmod($filename, 0664);
	}
}

$install = new Install;
$install->insertData();
$install->addAdmin();
$install->configuration();

$result = array('response' => 'success', 'text' => 'Installation Done!.');
echo json_encode($result);
exit();
