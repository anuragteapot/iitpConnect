<?php

class LeaveController extends BaseController
{

  public static $leaveArran = NULL;
  public static $leaveAddr = NULL;
  public static $refrence = NULL;
  public static $purpose = NULL;
  public static $date1 = NULL;
  public static $date1from = NULL;
  public static $date2 = NULL;
  public static $date2upto = NULL;
  public static $date3 = NULL;
  public static $date3from = NULL;
  public static $date4 = NULL;
  public static $date4upto = NULL;
  public static $yes = NULL;
  public static $sld = NULL;
  public static $nol = NULL;
  public static $empCode = NULL;

  public function __construct()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    if(isset($_POST['nol']))
    {
      self::$leaveArran = mysqli_real_escape_string($mysql, $_POST['leaveArran']);
      self::$leaveAddr = mysqli_real_escape_string($mysql, $_POST['leaveAddr']);
      self::$refrence = mysqli_real_escape_string($mysql, $_POST['refrence']);
      self::$purpose = mysqli_real_escape_string($mysql, $_POST['purpose']);
      self::$date1 = mysqli_real_escape_string($mysql, $_POST['date1']);
      self::$date1from = mysqli_real_escape_string($mysql, $_POST['date1from']);
      self::$date2 = mysqli_real_escape_string($mysql, $_POST['date2']);
      self::$date2upto = mysqli_real_escape_string($mysql, $_POST['date2upto']);
      self::$empCode = mysqli_real_escape_string($mysql, $_POST['empCode']);
      self::$nol = mysqli_real_escape_string($mysql, $_POST['nol']);
      self::$sld = mysqli_real_escape_string($mysql, $_POST['sld']);

      if(self::$sld == 'YES')
      {
        self::$date3 = mysqli_real_escape_string($mysql, $_POST['date3']);
        self::$date3from = mysqli_real_escape_string($mysql, $_POST['date3form']);
        self::$date4 = mysqli_real_escape_string($mysql, $_POST['date4']);
        self::$date4upto = mysqli_real_escape_string($mysql, $_POST['date4upto']);
      }
    }
  }

  /**
  * Method to give leave.
  *
  * @param   string  $start  Start date
  * @param   string  $end    End date
  *
  * @return  bool
  *
  */
  public function giveLeave()
  {
    if(self::$nol == 'RH' || self::$nol == 'EL')
    {
      self::restrictedHoliday();
    }
    else if(self::$nol == 'CL' || self::$nol == 'SCL' || self::$nol == 'LPW' || self::$nol == 'DL')
    {
      self::casualLeave();
    }
    else if(self::$nol == 'V')
    {
      self::vacationLeave();
    }
    else if(self::$nol == 'l0')
    {
      $result = array('response' => 'error', 'text' => 'Select Leave type.');
      echo json_encode($result);
      exit();
    }

  }

  /**
  * Method to give leave.
  *
  * @param   string  $start  Start date
  * @param   string  $end    End date
  *
  * @return  bool
  *
  */
  public function casualLeave()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    if(self::$nol == 'SCL' || self::$nol == 'LPW' || self::$nol == 'DL')
    {
      $sql = "SELECT SUM(numDays) AS total FROM leaveHistory WHERE empCode = '" . self::$empCode . "' AND type = 'SCL' OR type = 'LPW' OR type = 'DL'";
    }
    else
    {
      $sql = "SELECT SUM(numDays) AS total FROM leaveHistory WHERE empCode = '" . self::$empCode . "' AND type = '" . self::$nol . "'";
    }

    $res = $mysql->query($sql);
    $rows = $res->fetch_assoc();

    $maxDay = $this->maxDays(self::$nol);

    $days = $this->nopublicAndweekend(self::$date1, self::$date2);

    if($days > $maxDay)
    {
      if(self::$nol == 'SCL' || self::$nol == 'LPW' || self::$nol == 'DL')
      {
        $mess = 'You have ' . ($maxDay-$rows['total']) . ' holidays left.';
      }
      else
      {
        $mess = 'You have ' . ($maxDay-$rows['total']) . ' casual holidays left.';
      }

      $result = array('response' => 'error', 'text' => $mess);
      echo json_encode($result);
      exit();
    }

    if($days <= ($maxDay-$rows['total']))
    {
      self::insert($days);
    }
    else
    {
      if(self::$nol == 'SCL' || self::$nol == 'LPW' || self::$nol == 'DL')
      {
        $mess = 'You have ' . ($maxDay-$rows['total']) . ' holidays left.';
      }
      else
      {
        $mess = 'You have ' . ($maxDay-$rows['total']) . ' casual holidays left.';
      }

      $result = array('response' => 'error', 'text' => $mess);
      echo json_encode($result);
      exit();
    }
  }

  /**
  * Method to give restricted leave.
  *
  * @param   string  $start  Start date
  * @param   string  $end    End date
  *
  * @return  bool
  *
  */
  public function restrictedHoliday()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    $sql = "SELECT SUM(numDays) AS total FROM leaveHistory WHERE empCode = '" . self::$empCode . "' AND type = '" . self::$nol . "'";
    $res = $mysql->query($sql);
    $rows = $res->fetch_assoc();

    $maxDay = $this->maxDays(self::$nol);

    $days = $this->numDays(self::$date1, self::$date2);

    if($days > $maxDay)
    {
      if(self::$nol == 'RH')
      {
        $mess = 'You have ' . ($maxDay-$rows['total']) . ' restricted holidays left.';
      }
      else
      {
        $mess = 'You have ' . ($maxDay-$rows['total']) . ' earned levae left.';
      }

      $result = array('response' => 'error', 'text' => $mess);
      echo json_encode($result);
      exit();
    }

    if($days <= ($maxDay-$rows['total']))
    {
      self::insert($days);
    }
    else
    {
      $mess = 'You have ' . ($maxDay-$rows['total']) . ' restricted holidays left.';
      $result = array('response' => 'error', 'text' => $mess);
      echo json_encode($result);
      exit();
    }
  }


  /**
  * Method to give restricted leave.
  *
  * @param   string  $start  Start date
  * @param   string  $end    End date
  *
  * @return  bool
  *
  */
  public function vacationLeave()
  {
    $vacform = '2018-12-13';
    $vacto   = '2019-01-01';

    if((strtotime(self::$date1) >= strtotime($vacform)) && (strtotime(self::$date2) <= strtotime($vacto)))
    {

    }
    else
    {
      $result = array('response' => 'error', 'text' => 'This is not a vacation.');
      echo json_encode($result);
      exit();
    }

    $app = new Factory;
    $mysql = $app->getDBO();

    $sql = "SELECT SUM(numDays) AS total FROM leaveHistory WHERE empCode = '" . self::$empCode . "' AND type = '" . self::$nol . "'";
    $res = $mysql->query($sql);
    $rows = $res->fetch_assoc();

    $maxDay = $this->maxDays(self::$nol);

    $days = $this->numDays(self::$date1, self::$date2);

    if($days > $maxDay)
    {

      $mess = 'You have ' . ($maxDay-$rows['total']) . ' vacations levae left.';

      $result = array('response' => 'error', 'text' => $mess);
      echo json_encode($result);
      exit();
    }

    if($days <= ($maxDay-$rows['total']))
    {
      self::insert($days);
    }
    else
    {
      $mess = 'You have ' . ($maxDay-$rows['total']) . ' vasctions holidays left.';
      $result = array('response' => 'error', 'text' => $mess);
      echo json_encode($result);
      exit();
    }
  }

  /**
  * Method to insert data.
  *
  * @param   string  $type  Type of leave
  *
  * @return  bool
  *
  */
  public function insert($numDays)
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    $sql = "insert into leaveHistory(empCode, type, dateFrom, dayFrom, dateUpto, dayUpto, sdateFrom, sdayFrom, sdateUpto, sdayUpto, numDays,stationLeaveing, 	purpose, leaveAddress, leaveArrangement)
    values ('". self::$empCode ."','". self::$nol ."','". self::$date1 ."','". self::$date1from ."','". self::$date2 ."','". self::$date2upto ."',
    '". self::$date3 ."','". self::$date3from ."','". self::$date4 ."','". self::$date4upto ."','". $numDays ."','". 0 ."','". self::$purpose ."','". self::$leaveAddr ."','". self::$leaveArran ."')";

    $mysql->query($sql);

    if($mysql->connect_error)
    {
      $result = array('response' => 'error', 'text' => 'Error occurred.' , 'sqlstate' => $mysql->sqlstate);
      echo json_encode($result);
      exit();
    }
    else
    {
      $mess = 'Done!';
      $result = array('response' => 'success', 'text' => $mess);
      echo json_encode($result);
      exit();
    }
  }


  /**
  * Method to get leave history.
  *
  * @return  object
  *
  */
  public function getLeaveHistory($eCode = '')
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    $code = $eCode;

    $sql = "SELECT * FROM leaveHistory WHERE empCode  = $eCode ";
    $res = $mysql->query($sql);

    return $res;
  }

  /**
  * Method to get max leave.
  *
  * @param   string  $type  Type of leave
  *
  * @return  bool
  *
  */
  public function maxDays($type)
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    $sql = "SELECT maxday FROM leaveType WHERE type = '" . $type . "'";
    $res = $mysql->query($sql);
    $rows = $res->fetch_assoc();

    return $rows['maxday'];
  }

  /**
  * Method to check both date are in same year or not.
  *
  * @param   string  $start  Start date
  * @param   string  $end    End date
  *
  * @return  bool
  *
  */
  public function checkSameYear($startDate, $endDate)
  {
    $start = DateTime::createFromFormat('Y-m-d', $startDate);
    $end   = DateTime::createFromFormat('Y-m-d', $endDate);

    if($start->format('Y') == $end->format('Y'))
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  /**
  * Method to calculate earnLeave.
  *
  * @param   string  $start        Start date
  * @param   string  $end          End date
  * @param   array   $expholidays  Optional holidays
  *
  * @return  string
  *
  */
  public function numDays($startDate, $endDate)
  {
    if($startDate == $endDate)
    {
      return 1;
    }

    $start = new DateTime($startDate);
    $end   = new DateTime($endDate);

    $end->modify('+1 day');

    $interval = $end->diff($start);

    // total days
    $days = $interval->days;

    return $days;
  }

  /**
  * Method to calculate casualLeave.
  *
  * @param   string  $start        Start date
  * @param   string  $end          End date
  * @param   array   $expholidays  Optional holidays
  *
  * @return  string
  *
  */
  public static function nopublicAndweekend($startDate, $endDate, $expholidays = array())
  {
    $app  = new Factory;
    $mysql = $app->getDBO();

    $sql = "SELECT * FROM holidayList where type = 1";

    $res = $mysql->query($sql);

    $publicholidays = array();

    while($rows = $res->fetch_assoc())
    {
      $createDate = new DateTime($rows['holidayDate']);
      $strip = $createDate->format('Y-m-d');

      $publicholidays[] = $strip;
    }

    if(count($expholidays) > 0)
    {
      $publicholidays = array_merge($publicholidays, $expholidays);
    }

    $start = new DateTime($startDate);
    $end = new DateTime($endDate);

    $end->modify('+1 day');

    $interval = $end->diff($start);

    // total days
    $days = $interval->days;

    // create an iterateable period of date (P1D equates to 1 day)
    $period = new DatePeriod($start, new DateInterval('P1D'), $end);

    foreach($period as $dt)
    {
      $curr = $dt->format('D');

      // substract if Saturday or Sunday
      if ($curr == 'Sat' || $curr == 'Sun')
      {
        $days--;
      }
      // (optional) for the updated question
      elseif (in_array($dt->format('Y-m-d'), $publicholidays))
      {
        $days--;
      }
    }

    return $days;
  }
}
