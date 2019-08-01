<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_EXEC') or die;

class HostelController extends BaseController
{
    public $block;
    public $floor;
    public $room;

    public function __construct()
    {
        $router = new Router;
        $this->block = $router->get('block');
        $this->floor = $router->get('floor');
        $this->room = $router->get('room');
    }

    public function updateDetails()
    {
        $request = new Request;

        $room_id = $request->get('room_id');

        $name_1 = $request->get('name_1');
        $roll_1  = $request->get('roll_1');
        $email_1 = $request->get('email_1');
        $mobile_1 = $request->get('mobile_1');
        $super_1 = $request->get('super_1');

        $name_2 = $request->get('name_2');
        $roll_2  = $request->get('roll_2');
        $email_2 = $request->get('email_2');
        $mobile_2 = $request->get('mobile_2');
        $super_2 = $request->get('super_2');

        $name_3 = $request->get('name_3');
        $roll_3  = $request->get('roll_3');
        $email_3 = $request->get('email_3');
        $mobile_3 = $request->get('mobile_3');
        $super_3 = $request->get('super_3');

        $dt = $request->get('dt');
        $rs = $request->get('rs');
        $comment = $request->get('comments');

        $single = 0;

        if ($roll_1 != '') {

            $single++;
        }

        if ($roll_2 != '') {

            $single++;
        }

        if ($roll_3 != '') {

            $single++;
        }

        $beds = $request->get('beds');
        $hos = urldecode($request->get('hos'));
        $chairs = $request->get('chairs');
        $tables = $request->get('tables');
        $fans = $request->get('fans');
        $tubelights = $request->get('tubelights');

        if ((!preg_match('/^[0-9]{4}[A-Za-z]{2}[0-9]{2}$/', $roll_1) && $roll_1 != '') || (!preg_match('/^[0-9]{4}[A-Za-z]{2}[0-9]{2}$/', $roll_2) && $roll_2 != '') || (!preg_match('/^[0-9]{4}[A-Za-z]{2}[0-9]{2}$/', $roll_3) && $roll_3 != '')) {
            $result = array('response' => 'error', 'text' => 'Incorrect roll no.');
            echo json_encode($result);
            exit();
        }

        if ((!$this->checkEmail($email_1) && $email_1 != '') || (!$this->checkEmail($email_2) && $email_2 != '') || (!$this->checkEmail($email_3) && $email_3 != '')) {
            $result = array('response' => 'error', 'text' => 'Incorrect webmail.');
            echo json_encode($result);
            exit();
        }

        if ($this->block != 'NA' && $this->floor != 'NA' && $this->room != 'NA') {
            $this->updateStock($room_id, $hos, $beds, $chairs, $tables, $fans, $tubelights);
            $this->updateStatus($room_id, $hos, $dt, $rs, $comment, $single);
            $this->updateOccupants($room_id, $hos, $name_1, $roll_1, $email_1, $mobile_1, $super_1, $name_2, $roll_2, $email_2, $mobile_2, $super_2, $name_3, $roll_3, $email_3, $mobile_3, $super_3);
        } else {
            $result = array('response' => 'error', 'text' => 'Please select correct Block, Floor and Room.');
            echo json_encode($result);
            exit();
        }

        $result = array('response' => 'success', 'text' => 'Updated');
        echo json_encode($result);
        exit();
    }

    public function checkEmail($email)
    {
        $explodEmail = explode('@', $email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || ($explodEmail[1] != 'iitp.ac.in')) {
            return false;
        }
        return true;
    }

    public function updateStock($room_id, $hos, $beds, $chairs, $tables, $fans, $tubelights)
    {
        $app = new Factory;
        $mysql = $app->getDBO();

        $sql = "SELECT * FROM stock WHERE room_id = '$room_id' AND hostel_name = '$hos'";

        $check = $mysql->query($sql);

        if (mysqli_num_rows($check) > 0) {
            $query = "UPDATE stock SET beds = $beds, chairs = $chairs, tables = $tables, fans = $fans , tubelights = $tubelights WHERE room_id = '$room_id' AND hostel_name = '$hos'";
        } else {
            $query = "INSERT INTO stock(room_id, hostel_name, beds, chairs, tables, fans, tubelights) VALUES ('$room_id', '$hos' , $beds, $chairs, $tables,$fans ,$tubelights)";
        }

        $mysql->query($query);

        if ($mysql->connect_error) {
            return false;
        } else {
            return true;
        }
    }

    public function updateStatus($room_id, $hos, $dt, $rs, $comment, $single)
    {
        $app = new Factory;
        $mysql = $app->getDBO();

        $sql = "SELECT * FROM rstatus WHERE room_id = '$room_id' AND hostel_name = '$hos'";

        $check = $mysql->query($sql);

        if (mysqli_num_rows($check) > 0) {
            $query = "UPDATE rstatus SET dt = '$dt', rs = '$rs', comment = '$comment', single = '$single' WHERE room_id = '$room_id' AND hostel_name = '$hos'";
        } else {
            $query = "INSERT INTO rstatus(room_id, hostel_name, dt, rs, comment, single) VALUES ('$room_id', '$hos' ,'$dt', '$rs', '$comment', '$single')";
        }

        $mysql->query($query);

        if ($mysql->connect_error) {
            return false;
        } else {
            return true;
        }
    }

    public function updateOccupants($room_id, $hos, $n1 = '', $r1 = '', $e1 = '', $m1 = '', $s1 = '', $n2 = '', $r2 = '', $e2 = '', $m2 = '', $s2 = '', $n3 = '', $r3 = '', $e3 = '', $m3 = '', $s3 = '')
    {
        $app = new Factory;
        $mysql = $app->getDBO();

        $sql = "SELECT * FROM occupants_alloc WHERE room_id = '$room_id' AND roll LIKE '$r1%' AND roll LIKE '%$r2%' AND roll LIKE '%$r3' AND hostel_name = '$hos'";

        $check = $mysql->query($sql);

        if (mysqli_num_rows($check) > 0) { } else {
            $sql = "SELECT * FROM occupants_alloc WHERE room_id = '$room_id' AND hostel_name = '$hos'";

            $check = $mysql->query($sql);

            $pr1 = $r1 . '.' . $r2 . '.' . $r3;

            if (mysqli_num_rows($check) > 0) {
                $prev = mysqli_fetch_array($check)['roll'];
                $sql = "UPDATE occupants_alloc SET roll = '$pr1', previous = '$prev' WHERE room_id = '$room_id' AND hostel_name = '$hos'";
            } else {
                $sql = "INSERT INTO occupants_alloc(room_id, hostel_name,  roll) VALUES ('$room_id', '$hos' , '$pr1')";
            }

            $mysql->query($sql);
        }


        $sql = "SELECT * FROM occupants WHERE room_id = '$room_id' AND roll = '$r1' AND hostel_name = '$hos'";

        $check = $mysql->query($sql);

        if (mysqli_num_rows($check) <= 0 && $r1 != '') {
            $query = "INSERT INTO occupants(room_id, hostel_name, name, roll, email, mobile, supervision) VALUES ('$room_id', '$hos' ,'$n1', '$r1', '$e1', '$m1', '$s1')";
            $mysql->query($query);
        } elseif ($r1 != '') {
            $query = "UPDATE occupants SET name = '$n1', roll = '$r1', email = '$e1', mobile = '$m1' , supervision = '$s1' WHERE room_id = '$room_id' AND roll = '$r1' AND hostel_name = '$hos'";
            $mysql->query($query);
        }

        $sql = "SELECT * FROM occupants WHERE room_id = '$room_id' AND roll = '$r2' AND hostel_name = '$hos'";

        $check = $mysql->query($sql);

        if (mysqli_num_rows($check) <= 0 && $r2 != '') {
            $query = "INSERT INTO occupants(room_id, hostel_name ,name, roll, email, mobile, supervision) VALUES ('$room_id', '$hos' , '$n2', '$r2', '$e2', '$m2', '$s2')";
            $mysql->query($query);
        } elseif ($r2 != '') {
            $query = "UPDATE occupants SET name = '$n2', roll = '$r2', email='$e2', mobile='$m2' , supervision = '$s2' WHERE room_id = '$room_id' AND roll = '$r2' AND hostel_name = '$hos'";
            $mysql->query($query);
        }

        $sql = "SELECT * FROM occupants WHERE room_id = '$room_id' AND roll = '$r3' AND hostel_name = '$hos'";

        $check = $mysql->query($sql);

        if (mysqli_num_rows($check) <= 0 && $r3 != '') {
            $query = "INSERT INTO occupants(room_id, hostel_name, name, roll, email, mobile, supervision) VALUES ('$room_id', '$hos' ,'$n3', '$r3', '$e3', '$m3', '$s3')";
            $mysql->query($query);
        } elseif ($r3 != '') {
            $query = "UPDATE occupants SET name = '$n3', roll = '$r3', email='$e3', mobile='$m3' , supervision = '$s3' WHERE room_id = '$room_id' AND roll = '$r3' AND hostel_name = '$hos'";
            $mysql->query($query);
        }

        if ($mysql->connect_error) {
            return false;
        } else {
            return true;
        }
    }

    public function addBlocks()
    {
        $request = new Request;

        $inputHostel = $request->get('inputHostel');
        $block = $request->get('blocks');
        $start = $request->get('start');
        $end  = $request->get('end');
        $number = $request->get('number');

        $app = new Factory;
        $mysql = $app->getDBO();

        $checkSql = "SELECT * FROM hostel_info WHERE blocks = '$block' AND hostel_name = '$inputHostel'";

        $res = $mysql->query($checkSql);

        if (mysqli_num_rows($res) > 0) {
            $result = array('response' => 'error', 'text' => 'Block with this name exist.', 'type' => 'error');
            echo json_encode($result);
            exit();
        }

        $sql = "INSERT INTO hostel_info(hostel_name, blocks, start, end, number) VALUES ('$inputHostel', '$block','$start','$end','$number')";
        $mysql->query($sql);

        for($f = $start; $f< $end; $f++)
        {
            for($r = 0; $r <= $number; $r++) 
            {
                if ($r <= 9) 
                {
                    $roomId = strtoupper($block . $f . '0' . $r);
                } 
                else 
                {
                    $roomId = strtoupper($block . $f . $r);
                }
                $this->updateStatus($roomId, $inputHostel, 'NA', 'RM', 'Ready to Move', 0);
            }
        }

        if ($mysql->connect_error) {
            $result = array('response' => 'error', 'text' => 'Error occurred.', 'sqlstate' => $mysql->sqlstate);
            echo json_encode($result);
            exit();
        } else {
            $result = array('response' => 'success', 'text' => 'Added', 'type' => 'success');
            echo json_encode($result);
            exit();
        }
    }

    public function getOccupants($room_id, $hos)
    {
        $result = new \stdClass;

        $app = new Factory;
        $mysql = $app->getDBO();
        $sql = $sql = "SELECT * FROM occupants_alloc WHERE room_id = '$room_id' AND hostel_name = '$hos'";
        $res = mysqli_fetch_array($mysql->query($sql));

        $explodRes = explode('.', $res['roll']);

        $result->previous = $res['previous'];

        if ($explodRes['0'] != '') {
            $first = $explodRes['0'];
            $sql = "SELECT * FROM occupants WHERE room_id = '$room_id' AND roll = '$first' AND hostel_name = '$hos'";
            $result->first = mysqli_fetch_array($mysql->query($sql));
        }

        if ($explodRes['1'] != '') {
            $second = $explodRes['1'];
            $sql = "SELECT * FROM occupants WHERE room_id = '$room_id' AND roll = '$second' AND hostel_name = '$hos'";
            $result->second = mysqli_fetch_array($mysql->query($sql));
        }

        if ($explodRes['2'] != '') {
            $third = $explodRes['2'];
            $sql = "SELECT * FROM occupants WHERE room_id = '$room_id' AND roll = '$third' AND hostel_name = '$hos'";
            $result->third = mysqli_fetch_array($mysql->query($sql));
        }

        return $result;
    }

    public function getBlockInfo($block, $hos)
    {
        $app = new Factory;
        $mysql = $app->getDBO();
        $sql = "SELECT * from hostel_info where blocks = '$block' AND hostel_name = '$hos'";
        $res = $mysql->query($sql);
        return $res;
    }

    public function getStocks($room_id, $hos)
    {
        $app = new Factory;
        $mysql = $app->getDBO();
        $sql = "SELECT * from stock WHERE room_id = '$room_id' AND hostel_name = '$hos'";
        $res = $mysql->query($sql);
        return mysqli_fetch_array($res);
    }

    public function getRoomStatus($room_id, $hos)
    {
        $app = new Factory;
        $mysql = $app->getDBO();
        $sql = "SELECT * from rstatus WHERE room_id = '$room_id' AND hostel_name = '$hos'";
        $res = $mysql->query($sql);
        return mysqli_fetch_array($res);
    }

    public function getBlocks($hos)
    {
        $app = new Factory;
        $mysql = $app->getDBO();
        $sql = "SELECT blocks from hostel_info WHERE hostel_name = '$hos' ORDER BY blocks ASC";
        $res = $mysql->query($sql);
        return $res;
    }

    public function getHostels()
    {
        $app = new Factory;
        $mysql = $app->getDBO();
        $sql = "SELECT hostel_name from hostel_info GROUP BY hostel_name ORDER BY hostel_name ASC";
        $res = $mysql->query($sql);
        return $res;
    }

    public function getStatus($roomStatus, $hos)
    {
        $result = new \stdClass;

        $app = new Factory;
        $mysql = $app->getDBO();

        $sql = "SELECT room_id from rstatus WHERE rs = '$roomStatus' AND hostel_name = '$hos' ORDER BY room_id ASC";
        $result->hostel = $mysql->query($sql);

        $sql = "SELECT room_id from rstatus WHERE single = 1 AND hostel_name = '$hos' ORDER BY room_id ASC";
        $result->hostelSingle = $mysql->query($sql);

        $sql = "SELECT room_id from rstatus WHERE single = 2 AND hostel_name = '$hos' ORDER BY room_id ASC";
        $result->hostelDouble = $mysql->query($sql);

        $sql = "SELECT room_id from rstatus WHERE single = 3 AND hostel_name = '$hos' ORDER BY room_id ASC";
        $result->hostelTripal = $mysql->query($sql);


        if ($this->block != 'NA') {
            $block = $this->block;
            $sql = "SELECT room_id from rstatus WHERE rs = '$roomStatus' AND room_id LIKE '$block%' AND hostel_name = '$hos' ORDER BY room_id ASC";
            $result->block = $mysql->query($sql);

            $sql = "SELECT room_id from rstatus WHERE single = 1 AND room_id LIKE '$block%' AND hostel_name = '$hos' ORDER BY room_id ASC";
            $result->blockSingle = $mysql->query($sql);

            $sql = "SELECT room_id from rstatus WHERE single = 2 AND room_id LIKE '$block%' AND hostel_name = '$hos' ORDER BY room_id ASC";
            $result->blockDouble = $mysql->query($sql);

            $sql = "SELECT room_id from rstatus WHERE single = 3 AND room_id LIKE '$block%' AND hostel_name = '$hos' ORDER BY room_id ASC";
            $result->blockTripal = $mysql->query($sql);
        }

        if ($this->floor != 'NA' && $this->block != 'NA') {
            $floor = $this->floor;
            $block = $this->block;
            $check = $block . $floor;

            $sql = "SELECT room_id from rstatus WHERE rs = '$roomStatus' AND room_id LIKE '$check%' AND hostel_name = '$hos' ORDER BY room_id ASC";
            $result->floor = $mysql->query($sql);

            $sql = "SELECT room_id from rstatus WHERE single = 1 AND room_id LIKE '$check%' AND hostel_name = '$hos' ORDER BY room_id ASC";
            $result->floorSingle = $mysql->query($sql);

            $sql = "SELECT room_id from rstatus WHERE single = 2 AND room_id LIKE '$check%' AND hostel_name = '$hos' ORDER BY room_id ASC";
            $result->floorDouble = $mysql->query($sql);

            $sql = "SELECT room_id from rstatus WHERE single = 3 AND room_id LIKE '$check%' AND hostel_name = '$hos' ORDER BY room_id ASC";
            $result->floorTripal = $mysql->query($sql);
        }

        return $result;
    }
}
