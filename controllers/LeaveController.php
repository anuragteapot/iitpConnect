<?php


/**
 *  Leave module
 */
class LeaveController extends BaseController
{
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
  public function earnedleave($startDate, $endDate)
  {

    $start = new DateTime($startDate);
    $end  = new DateTime($endDate);

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
  public function casualLeave($startDate, $endDate, $expholidays = array())
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
