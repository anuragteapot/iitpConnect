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
  public static $malExtra = NULL;
  public static $malClExtra = NULL;
  public static $handicap = NULL;

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
      self::$malExtra = mysqli_real_escape_string($mysql, $_POST['malExtra']);
      self::$malClExtra = mysqli_real_escape_string($mysql, $_POST['malClExtra']);

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
    if(self::$nol == 'RH')
    {
      self::restrictedHoliday();
    }
    else if (self::$nol == 'EL')
    {
      self::earnedLeave();
    }
    else if(self::$nol == 'SL')
    {
      self::stationLeave();
    }
    else if(self::$nol == 'MAL')
    {
      self::maternityLeave();
    }
    else if(self::$nol == 'MALA')
    {
      self::maternityLeaveAdoption();
    }
    else if(self::$nol == 'SABL')
    {
      self::sabbaticalLeave();
    }
    else if(self::$nol == 'EOL')
    {
      self::extraOrdinaryLeave();
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

    // Add station leave to database.

    if($this->haveWeekends(self::$date1, self::$date2) && self::$sld != 'YES') {

      $mess = 'Please fill station leaving details.';
      $result = array('response' => 'error', 'text' => $mess);
      echo json_encode($result);
      exit();
    }

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

    if($_POST['hc']) {
      $hc = $_POST['hc'];
    }

    if(self::$nol == 'CL' && $hc) {
      $maxDay = $maxDay + 2;
    }

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

    $explodeDate1 = explode('-', self::$date1);
    $explodeDate2 = explode('-', self::$date2);

    if( ( (int)$explodeDate1['1'] == 5 && (int)$explodeDate2['1'] == 5 )  || ( (int)$explodeDate1['1'] == 6 && (int)$explodeDate2['1'] == 6 )
    || ( (int)$explodeDate1['1'] == 5 && (int)$explodeDate2['1'] == 6 ) || ( (int)$explodeDate1['1'] == 12 && (int)$explodeDate2['1'] == 12 ) )
    {
    } else {
      $result = array('response' => 'error', 'text' => 'This is not a vacation month.');
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

      $mess = 'You have ' . ($maxDay-$rows['total']) . ' vacations leave left.';

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
      $mess = 'You have ' . ($maxDay-$rows['total']) . ' vacations holidays left.';
      $result = array('response' => 'error', 'text' => $mess);
      echo json_encode($result);
      exit();
    }
  }


  public function isWeekend($date) {
    return (date('N', strtotime($date)) >= 6);
  }


    /**
  * Method to give restricted leave.
  *
  * @param   string  $start  Start date
  * @param   string  $end    End date
   *Only saturday and sunday.
  *
  * @return  bool
  *
  */
  public function stationLeave()
  {
    $days = $this->numDays(self::$date1, self::$date2);
    $this->isWeekend(self::$date1);
    if ($this->isWeekend(self::$date1) && $this->isWeekend(self::$date2) && $days <= 2){
      self::insert($days);
      return true;
    } else {
      $mess = 'Not valid station leave.';
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
   *Only saturday and sunday.
  *
  * @return  bool
  *
  */
  public function maternityLeave()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    $sql = "SELECT SUM(numDays) AS total FROM leaveHistory WHERE empCode = '" . self::$empCode . "' AND type = '" . self::$nol . "'";
    $res = $mysql->query($sql);
    $rows = $res->fetch_assoc();

    $maxDay = $this->maxDays(self::$nol);
    $days = $this->numDays(self::$date1, self::$date2);

    if(self::$malExtra)
    {
      $maxDay = $maxDay + 45;
      $days = $days + 45;
    }

    if(self::$malClExtra != 0)
    {
      $query = "SELECT SUM(numDays) AS total FROM leaveHistory WHERE empCode = '" . self::$empCode . "' AND type = 'CL'";
      $res = $mysql->query($query);
      $rows = $res->fetch_assoc();

      $maxDay = $this->maxDays('CL');

      if(self::$malClExtra > $maxDay-$rows['total']) {

        $mess = 'You have ' . ($maxDay-$rows['total']) . ' casual leave left.';

        $result = array('response' => 'error', 'text' => $mess);
        echo json_encode($result);
        exit();
      } else {
        $maxDay = $maxDay  + self::$malClExtra;
        $days  = $days + self::$malClExtra;
      }
    }

    if($days > $maxDay)
    {

      $mess = 'You have ' . ($maxDay-$rows['total']) . ' maternity leave left.';

      $result = array('response' => 'error', 'text' => $mess);
      echo json_encode($result);
      exit();
    } else {
      self::insert($days);
    }
  }



      /**
  * sabbaticalLeave.
  *
  * @param   string  $start  Start date
  * @param   string  $end    End date
   *Only saturday and sunday.
  *
  * @return  bool
  *
  */
  public function sabbaticalLeave()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    $sql = "SELECT SUM(numDays) AS total FROM leaveHistory WHERE empCode = '" . self::$empCode . "' AND type = '" . self::$nol . "'";
    $res = $mysql->query($sql);
    $rows = $res->fetch_assoc();

    $maxDay = $this->maxDays(self::$nol);
    $days = $this->numDays(self::$date1, self::$date2);

    // Date of joining.
    $doj = '2010-04-04';

    if(self::getNumYear($doj, self::$date2) < 6)
    {
      $mess = 'Your 6 years is not completed.';
      $result = array('response' => 'error', 'text' => $mess);
      echo json_encode($result);
      exit();
    }

    if($days > $maxDay)
    {
      $mess = 'You have ' . ($maxDay-$rows['total']) . ' sabbatical leave left.';
      $result = array('response' => 'error', 'text' => $mess);
      echo json_encode($result);
      exit();
    } else {
      self::insert($days);
    }
  }


        /**
  * Extra Ordinary Leave.
  *
  * @param   string  $start  Start date
  * @param   string  $end    End date
   *Only saturday and sunday.
  *
  * @return  bool
  *
  */
  public function extraOrdinaryLeave()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    $sql = "SELECT SUM(numDays) AS total FROM leaveHistory WHERE empCode = '" . self::$empCode . "' AND type = '" . self::$nol . "'";
    $res = $mysql->query($sql);
    $rows = $res->fetch_assoc();

    $maxMonths = $this->maxDays(self::$nol);
    $months = $this->monthsBetweenDates(self::$date1, self::$date2);

    // Date of joining.
    // $doj = '2010-04-04';

    // if(self::getNumYear($doj, self::$date2) < 1)
    // {
    //   $mess = 'Your 6 years is not completed.';
    //   $result = array('response' => 'error', 'text' => $mess);
    //   echo json_encode($result);
    //   exit();
    // }

    if($months > $maxMonths)
    {
      $mess = 'You have ' . ($maxMonths-$rows['total']) . ' sabbatical leave left.';
      $result = array('response' => 'error', 'text' => $mess);
      echo json_encode($result);
      exit();
    } else {
      self::insert($days);
    }
  }


      /**
  * Method to give restricted leave.
  *
  * @param   string  $start  Start date
  * @param   string  $end    End date
   *Only saturday and sunday.
  *
  * @return  bool
  *
  */
  public function maternityLeaveAdoption()
  {
    $app = new Factory;
    $mysql = $app->getDBO();

    $sql = "SELECT SUM(numDays) AS total FROM leaveHistory WHERE empCode = '" . self::$empCode . "' AND type = '" . self::$nol . "'";
    $res = $mysql->query($sql);
    $rows = $res->fetch_assoc();

    $maxDay = $this->maxDays(self::$nol);
    $days = $this->numDays(self::$date1, self::$date2);

    if(self::$malExtra)
    {
      $maxDay = 365;
    }

    if($days > $maxDay)
    {
      $mess = 'You have ' . ($maxDay-$rows['total']) . ' maternity leave left.';
      $result = array('response' => 'error', 'text' => $mess);
      echo json_encode($result);
      exit();
    } else {
      self::insert($days);
    }
  }

      /**
  * Method to give restricted leave.
  *
  * @param   string  $start  Start date
  * @param   string  $end    End date
   *Only saturday and sunday.
  *
  * @return  bool
  *
  */
  public function monthsBetweenDates($date1, $date2)
  {
    $ts1 = strtotime($date1);
    $ts2 = strtotime($date2);

    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);
    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);

    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

    return $diff;
  }


      /**
  * Method to give restricted leave.
  *
  * @param   string  $start  Start date
  * @param   string  $end    End date
  *
  *
  * @return  bool
  *
  */
  public function earnedLeave()
  {
    $dateOfJoining = '2018-01-01';

    $numMonths = $this->monthsBetweenDates($dateOfJoining, self::$date2);

    $app = new Factory;
    $mysql = $app->getDBO();

    $sql = "SELECT SUM(numDays) AS total FROM leaveHistory WHERE empCode = '" . self::$empCode . "' AND type = '" . self::$nol . "'";
    $res = $mysql->query($sql);
    $rows = $res->fetch_assoc();

    $totalTaken = $rows['total'];

    $totalAvailable = min(($numMonths * 2.5), 300) - $totalTaken;

    $days = $this->numDays(self::$date1, self::$date2);

    if($days > 180) {
      $mess = 'Not allowed more than 180.';
      $result = array('response' => 'error', 'text' => $mess);
      echo json_encode($result);
      exit();
    }

    if ($days < $totalAvailable)
    {
      self::insert($days);
    } else {
      $mess = 'You have ' . ($totalAvailable) . ' earned leave left.';

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
   *Only saturday and sunday.
  *
  * @return  bool
  *
  */
  public function haveWeekends($fromDate, $toDate)
  {
    $day_of_week = date("N", strtotime($fromDate));
    $days = $day_of_week + (strtotime($toDate) - strtotime($fromDate)) / (60*60*24);

    if ($days >= 6){
      return true;
    } else {
      return false;
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
  * Method to get number ofyear;
  *
  * @param   string  $start  Start date
  * @param   string  $end    End date
  *
  * @return  bool
  *
  */
  public function getNumYear($startDate, $endDate)
  {
    $d1 = new DateTime($startDate);
    $d2 = new DateTime($endDate);
    $diff = $d2->diff($d1);
    return $diff->y;
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
