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
        $this->updateStock('A302', 1, 1, 1, 1, 1);
        $this->updateStatus('A302', 'NP', 'DM', 'ANURAG', 0);
        $this->updateOccupants('A302', 'Anurag', '1601CS05', 'anurag.cs16@iitp.ac.in', 123123, 'sdasd');
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

        $dt = $request->get('dt');
        $rs = $request->get('rs');
        $comment = $request->get('comment');
        $single = $request->get('single');

        $beds = $request->get('beds');
        $chairs = $request->get('chairs');
        $tables = $request->get('tables');
        $fans = $request->get('fans');
        $tubelights = $request->get('tubelights');

        $result = array('response' => 'error', 'text' => 'CHeck', 'sqlstate' => $mysql->sqlstate);
        echo json_encode($result);
        exit();
    }

    public function updateStock($room_id, $beds, $chairs, $tables, $fans, $tubelights)
    {
        $app = new Factory;
        $mysql = $app->getDBO();

        $sql = "SELECT * FROM stock WHERE room_id = '$room_id'";

        $check = $mysql->query($sql);

        if (mysqli_num_rows($check) > 0) {
            $query = "UPDATE stock SET beds = $beds, chairs = $chairs, tables = $tables, fans = $fans , tubelights = $tubelights WHERE room_id = '$room_id'";
        } else {
            $query = "INSERT INTO stock(room_id, beds, chairs, tables, fans, tubelights) VALUES ('$room_id', $beds, $chairs, $tables,$fans ,$tubelights)";
        }

        $mysql->query($query);

        if ($mysql->connect_error) {
            return false;
        } else {
            return true;
        }
    }

    public function updateStatus($room_id, $dt, $rs, $comment, $single)
    {
        $app = new Factory;
        $mysql = $app->getDBO();

        $sql = "SELECT * FROM rstatus WHERE room_id = '$room_id'";

        $check = $mysql->query($sql);

        if (mysqli_num_rows($check) > 0) {
            $query = "UPDATE rstatus SET dt = '$dt', rs = '$rs', comment = '$comment', single = $single WHERE room_id = '$room_id'";
        } else {
            $query = "INSERT INTO rstatus(room_id, dt, rs, comment, single) VALUES ('$room_id', '$dt', '$rs', '$comment', $single)";
        }

        $mysql->query($query);

        if ($mysql->connect_error) {
            return false;
        } else {
            return true;
        }
    }

    public function updateOccupants($room_id, $name, $roll, $email, $mobile, $super)
    {
        $app = new Factory;
        $mysql = $app->getDBO();

        $sql = "SELECT * FROM occupants WHERE room_id = '$room_id' ORDER BY id DESC LIMIT 3";

        $check = $mysql->query($sql);

        $res1 =  mysqli_fetch_array($check);
        $res2 =  mysqli_fetch_array($check);

        if ($res1['roll'] == $roll || $res2['roll'] == $roll) {
            return true;
        }

        $query = "INSERT INTO occupants(room_id, name, roll, email, mobile, supervision) VALUES ('$room_id', '$name', '$roll', '$email', '$mobile', '$super')";

        $mysql->query($query);

        if ($mysql->connect_error) {
            return false;
        } else {
            return true;
        }
    }

    public function addBlocks()
    {
        $request = new Request;

        $block = $request->get('blocks');
        $start = $request->get('start');
        $end  = $request->get('end');
        $number = $request->get('number');

        $app = new Factory;
        $mysql = $app->getDBO();

        $checkSql = "SELECT * FROM hostel_info WHERE blocks = '$block' ";

        $res = $mysql->query($checkSql);

        if (mysqli_num_rows($res) > 0) {
            $result = array('response' => 'error', 'text' => 'Block with this name exist.', 'type' => 'error');
            echo json_encode($result);
            exit();
        }

        $sql = "INSERT INTO hostel_info(blocks, start, end, number) VALUES ('" . $block . "','" . $start . "','" . $end . "','" . $number . "')";
        $mysql->query($sql);

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

    public function getOccupants($room_id)
    {
        $app = new Factory;
        $mysql = $app->getDBO();
        $sql = $sql = "SELECT * FROM occupants WHERE room_id = '$room_id' ORDER BY id DESC LIMIT 4";
        $res = $mysql->query($sql);
        return $res;
    }

    public function getBlockInfo($block)
    {
        $app = new Factory;
        $mysql = $app->getDBO();
        $sql = "SELECT * from hostel_info where blocks = '$block'";
        $res = $mysql->query($sql);
        return $res;
    }


    public function getBlocks()
    {
        $app = new Factory;
        $mysql = $app->getDBO();
        $sql = "SELECT blocks from hostel_info ORDER BY blocks ASC";
        $res = $mysql->query($sql);
        return $res;
    }

    public function getStatus($roomStatus)
    {
        $result = new \stdClass;

        $app = new Factory;
        $mysql = $app->getDBO();

        $sql = "SELECT room_id from rstatus WHERE rs = '$roomStatus' ORDER BY room_id ASC";
        $result->hostel = $mysql->query($sql);

        $sql = "SELECT room_id from rstatus WHERE single = 1 ORDER BY room_id ASC";
        $result->hostelSingle = $mysql->query($sql);


        if ($this->block != 'NA') {
            $block = $this->block;
            $sql = "SELECT room_id from rstatus WHERE rs = '$roomStatus' AND room_id LIKE '$block%' ORDER BY room_id ASC";
            $result->block = $mysql->query($sql);

            $sql = "SELECT room_id from rstatus WHERE single = 1 AND room_id LIKE '$block%' ORDER BY room_id ASC";
            $result->blockSingle = $mysql->query($sql);
        }

        if ($this->floor != 'NA' && $this->block != 'NA') {
            $floor = $this->floor;
            $block = $this->block;
            $check = $block . $floor;

            $sql = "SELECT room_id from rstatus WHERE rs = '$roomStatus' AND room_id LIKE '$check%' ORDER BY room_id ASC";
            $result->floor = $mysql->query($sql);

            $sql = "SELECT room_id from rstatus WHERE single = 1 AND room_id LIKE '$check%' ORDER BY room_id ASC";
            $result->floorSingle = $mysql->query($sql);
        }

        return $result;
    }
}
