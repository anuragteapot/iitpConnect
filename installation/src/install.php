<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

class Install {

  // DATABASE configuration
	public $server;
	public $dbname;
	public $dbpassword;
	public $dbtablename;
	public $conn;

  //User information
	public $name;
  public $useremail;
	public $username;
  public $password;

	public function __construct()
	{
		error_reporting(E_ERROR);

    if(isset($_POST['uname']) )
    {
      $this->server = $_POST['uhost'];
      $this->dbname = $_POST['udatabase'];
      $this->dbpassword = $_POST['udatabasepassword'];
    }

		$mysql = new mysqli($this->server, $this->dbname, $this->dbpassword);

    if($mysql->connect_error) {
			$result = array('response' => 'error', 'text' => 'Could not connect to database ' . $this->dbtablename, 'conn' => $mysql->connect_error);
			echo json_encode($result);
      die();
    }

		$this->dbtablename = mysqli_real_escape_string($mysql, $_POST['udatabasetablename']);

		// Admin data
		$this->name = mysqli_real_escape_string($mysql, $_POST['uname']);
		$this->useremail = mysqli_real_escape_string($mysql, $_POST['uemail']);
		$this->username = mysqli_real_escape_string($mysql, $_POST['uadmin']);
		$this->password = mysqli_real_escape_string($mysql, $_POST['uadminpassword']);

    if($mysql->select_db($this->dbtablename))
    {
      $result = array('response' => 'error', 'text' => 'Database with ' . $this->dbtablename . ' name already exist.', 'sqlstate' => $mysql->sqlstate, 'conn' => $mysql);
      echo json_encode($result);
      die();
    }

    $sql = 'CREATE DATABASE IF NOT EXISTS ' . $this->dbtablename;
    $res = $mysql->query($sql);

    if(!$res)
    {
      $result = array('response' => 'error', 'text' => 'Could not create database ' . $this->dbtablename , 'sqlstate' => $mysql->sqlstate, 'conn' => $mysql);
      echo json_encode($result);
      die();
    }

    $mysql->close();
	}

	public function connect()
	{
		$this->conn = new mysqli($this->server, $this->dbname, $this->dbpassword, $this->dbtablename);
		return $this->conn;
	}

	public function disconnect()
	{
		$this->conn->close();
	}
}

$conn = new Install();
$mysql = $conn->connect();

$sqlFileToExecute = dirname(__DIR__) . '/sql/main.sql';

$f = fopen($sqlFileToExecute,"r+");
$sqlFile = fread($f, filesize($sqlFileToExecute));
$sqlArray = explode(';',$sqlFile);
foreach ($sqlArray as $stmt)
{
  if (strlen($stmt)> 3 && substr(ltrim($stmt),0,2)!='/*')
  {
		$result = $mysql->query($stmt);
  }
}

$sql = "insert into users(name,username,email,password,registerDate,lastvisitDate)
 			values ('". $conn->name ."','". $conn->username ."','". $conn->useremail ."','". sha1('1601' . $conn->password . 'iitp') ."','". date("Y-m-d") ."','". date("Y-m-d") ."')";

$mysql->query($sql);

echo $mysql->connect_error;

$result = array('response' => 'success', 'text' => 'Installation Done!' , 'sqlstate' => $mysql->sqlstate, 'conn' => $mysql);
echo json_encode($result);

$data = "<?php
class Config {
	public \$username = '". $conn->username . "';
	public \$useremail = '". $conn->useremail ."';
	public \$sitename = 'iitpConnect';
	public \$debug = true;
	public \$dbtype = 'mysqli';
	public \$host = '". $conn->server ."';
	public \$dbusername = '". $conn->dbname ."';
	public \$dbpassword = '". $conn->dbpassword ."';
	public \$db = '". $conn->dbtablename ."';
	public \$secret = '" . md5($conn->useremail . $conn->username . "iitpConnect") . "';
	public \$error_reporting = 'default';
	public \$baseurl = 'http://localhost/project/iitpConnect/';
}";

$filename = substr(dirname(__DIR__), 0, strpos(dirname(__DIR__), '/installation')) . '/configuration.php';
file_put_contents($filename, $data);
chmod($filename, 0664);

$conn->disconnect();
