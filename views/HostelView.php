<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_EXEC') or die;

if (!User::isLoggedIn(true)) {
    header('Location: ' . BASE_URL);
}

$controller = new HostelController;
$router = new Router;

$hos = urldecode($router->get('hos'));
$numBlocks = $controller->getBlocks($hos);

$damageRoom = $controller->getStatus('DM', $hos);
$readyMove = $controller->getStatus('RM', $hos);
$occupied = $controller->getStatus('OC', $hos);

if ($block != 'NA') {
    $block = $router->get('block');
    $blockInfo = $controller->getBlockInfo($block, $hos);
    $result = mysqli_fetch_array($blockInfo);

    $start = $result['start'];
    $end = $result['end'];
}

$floor = $router->get('floor');
$room = $router->get('room');

if ($floor != 'NA' && $block != 'NA' && $room != 'NA') {
    if ($room < 9) {
        $room_id = strtoupper($block . $floor . '0' . $room);
    } else {
        $room_id = strtoupper($block . $floor . $room);
    }

    $occupants = $controller->getOccupants($room_id, $hos);
    $stock = $controller->getStocks($room_id, $hos);
    $roomStatus = $controller->getRoomStatus($room_id, $hos);
}

?>
<html>

<head>
    <title>Leave Arrangements</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.4.1/css/all.css' integrity='sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz' crossorigin='anonymous'>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/hostel/css/main.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/system/css/core.css" />
    <script src="<?php echo BASE_URL; ?>media/system/js/core.js"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/hostel/css/bootstrap-select.css" />
    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/js/gijgo.min.js" type="text/javascript"></script>
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>templates/images/logo.svg">
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</head>

<body>
    <div style="display:none;" class="bar" id="loader">
        <div></div>
    </div>
    <div id="snackbar"></div>
    <div class="jumbotron text-center">
        <h1>Hostel Management System</h1>
        <a href="<?php echo BASE_URL; ?>hostel" class="btn btn-info " type="submit">Chooose New Block</a>
    </div>
    <div class="container-fluid">
        <section class="main">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">

                                <h5>Hostel Name : <strong><?php echo $hos; ?></strong>
                                    <------> Block : <strong><?php echo $room_id; ?></strong>
                                </h5>
                                <hr>

                                <input id="block" type="text" value="<?php echo $router->get('block'); ?>" hidden />
                                <input id="floor" type="text" value="<?php echo $router->get('floor'); ?>" hidden />
                                <input id="room" type="text" value="<?php echo $router->get('room'); ?>" hidden />


                                <?php if ($room > 0 && $floor != 'NA' && $block != 'NA' && $room != 'NA') {  ?>
                                    <a id="prev" class="btn btn-info " type="submit">
                                        < Previous</a> <?php  } ?> <button id="editDetails" class="btn btn-danger " type="submit">Edit Details</button>

                                        <?php if ($room < $result['number'] && $floor != 'NA' && $block != 'NA' && $room != 'NA') {  ?>
                                            <a id="next" class="btn btn-info " type="submit">Next ></a>
                                        <?php } ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 order-md-2 mb-4">

                                <h4 class="d-flex justify-content-between align-items-center mb-3">
                                    <h5>Overall Details Hostel Wise</h5>
                                </h4>
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed" data-toggle="collapse" data-target="#collapseHostel" aria-expanded="false" aria-controls="collapseExample">
                                        <div>
                                            <h6 class="my-0">Damaged Rooms</h6>
                                            <div class="collapse" id="collapseHostel">
                                                <br>

                                                <?php while ($damageHostel =  mysqli_fetch_array($damageRoom->hostel)) {

                                                    $split = str_split($damageHostel['room_id']);

                                                    ?>

                                                    <div style="float:left;">
                                                        <h3 style="margin-left:3px;"><a href="<?php echo BASE_URL . 'hostel/view/hos/' . $hos . '/block/' . $split[0] . '/floor/' . $split[1] . '/room/';
                                                                                                if ($split[2] == 0) {
                                                                                                    echo $split[3];
                                                                                                } else {
                                                                                                    echo $split[2] . $split[3];
                                                                                                } ?>"><span class="badge badge-primary"><?php echo $damageHostel['room_id']; ?></span></a></h3>
                                                    </div>

                                                <?php } ?>

                                            </div>
                                        </div>
                                        <span class="text-muted"><?php echo mysqli_num_rows($damageRoom->hostel); ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed" data-toggle="collapse" data-target="#collapseHostelReady" aria-expanded="false" aria-controls="collapseExample">
                                        <div>
                                            <h6 class="my-0">Ready To Move</h6>
                                            <div class="collapse" id="collapseHostelReady">
                                                <br>

                                                <?php while ($readyMoves =  mysqli_fetch_array($readyMove->hostel)) {

                                                    $split = str_split($readyMoves['room_id']);

                                                    ?>

                                                    <div style="float:left;">
                                                        <h3 style="margin-left:3px;"><a href="<?php echo BASE_URL . 'hostel/view/hos/' . $hos . '/block/' . $split[0] . '/floor/' . $split[1] . '/room/';
                                                                                                if ($split[2] == 0) {
                                                                                                    echo $split[3];
                                                                                                } else {
                                                                                                    echo $split[2] . $split[3];
                                                                                                } ?>"><span class="badge badge-primary"><?php echo $readyMoves['room_id']; ?></span></a></h3>
                                                    </div>

                                                <?php } ?>

                                            </div>
                                        </div>
                                        <span class="text-muted"><?php echo mysqli_num_rows($readyMove->hostel);  ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed" data-toggle="collapse" data-target="#collapseHostelOccupied" aria-expanded="false" aria-controls="collapseExample">
                                        <div>
                                            <h6 class="my-0">Occupied</h6>
                                            <div class="collapse" id="collapseHostelOccupied">
                                                <br>

                                                <?php while ($roccupied =  mysqli_fetch_array($occupied->hostel)) {

                                                    $split = str_split($roccupied['room_id']);

                                                    ?>

                                                    <div style="float:left;">
                                                        <h3 style="margin-left:3px;"><a href="<?php echo BASE_URL . 'hostel/view/hos/' . $hos . '/block/' . $split[0] . '/floor/' . $split[1] . '/room/';
                                                                                                if ($split[2] == 0) {
                                                                                                    echo $split[3];
                                                                                                } else {
                                                                                                    echo $split[2] . $split[3];
                                                                                                } ?>"><span class="badge badge-primary"><?php echo $roccupied['room_id']; ?></span></a></h3>
                                                    </div>

                                                <?php } ?>

                                            </div>
                                        </div>
                                        <span class="text-muted"><?php echo mysqli_num_rows($occupied->hostel);  ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed" data-toggle="collapse" data-target="#collapseHostelSingle" aria-expanded="false" aria-controls="collapseExample">
                                        <div>
                                            <h6 class="my-0">Single Occupied Rooms</h6>
                                            <div class="collapse" id="collapseHostelSingle">
                                                <br>

                                                <?php while ($damageHostel =  mysqli_fetch_array($damageRoom->hostelSingle)) {

                                                    $split = str_split($damageHostel['room_id']);

                                                    ?>

                                                    <div style="float:left;">
                                                        <h3 style="margin-left:3px;"><a href="<?php echo BASE_URL . 'hostel/view/hos/' . $hos . '/block/' . $split[0] . '/floor/' . $split[1] . '/room/';
                                                                                                if ($split[2] == 0) {
                                                                                                    echo $split[3];
                                                                                                } else {
                                                                                                    echo $split[2] . $split[3];
                                                                                                } ?>"><span class="badge badge-primary"><?php echo $damageHostel['room_id']; ?></span></a></h3>
                                                    </div>

                                                <?php } ?>

                                            </div>
                                        </div>
                                        <span class="text-muted"><?php echo mysqli_num_rows($damageRoom->hostelSingle); ?></span>
                                    </li>
                                </ul>

                                <?php if ($block != 'NA') { ?>

                                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                                        <h5>Overall Details Block wise </h5>
                                    </h4>

                                    <ul class="list-group mb-3">
                                        <li class="list-group-item d-flex justify-content-between lh-condensed" data-toggle="collapse" data-target="#collapseBlock" aria-expanded="false" aria-controls="collapseExample">
                                            <div>
                                                <h6 class="my-0">Damaged Block</h6>
                                                <div class="collapse" id="collapseBlock">
                                                    <br>

                                                    <?php while ($damageHostel =  mysqli_fetch_array($damageRoom->block)) {

                                                        $split = str_split($damageHostel['room_id']);

                                                        ?>

                                                        <div style="float:left;">
                                                            <h3 style="margin-left:3px;"><a href="<?php echo BASE_URL . 'hostel/view/hos/' . $hos . '/block/' . $split[0] . '/floor/' . $split[1] . '/room/';
                                                                                                    if ($split[2] == 0) {
                                                                                                        echo $split[3];
                                                                                                    } else {
                                                                                                        echo $split[2] . $split[3];
                                                                                                    } ?>"><span class="badge badge-primary"><?php echo $damageHostel['room_id']; ?></span></a></h3>
                                                        </div>

                                                    <?php } ?>

                                                </div>
                                            </div>
                                            <span class="text-muted"><?php echo mysqli_num_rows($damageRoom->block); ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-condensed" data-toggle="collapse" data-target="#collapseBlockReady" aria-expanded="false" aria-controls="collapseExample">
                                            <div>
                                                <h6 class="my-0">Ready To Move</h6>
                                                <div class="collapse" id="collapseBlockReady">
                                                    <br>

                                                    <?php while ($readyMoves =  mysqli_fetch_array($readyMove->block)) {

                                                        $split = str_split($readyMoves['room_id']);

                                                        ?>

                                                        <div style="float:left;">
                                                            <h3 style="margin-left:3px;"><a href="<?php echo BASE_URL . 'hostel/view/hos/' . $hos . '/block/' . $split[0] . '/floor/' . $split[1] . '/room/';
                                                                                                    if ($split[2] == 0) {
                                                                                                        echo $split[3];
                                                                                                    } else {
                                                                                                        echo $split[2] . $split[3];
                                                                                                    } ?>"><span class="badge badge-primary"><?php echo $readyMoves['room_id']; ?></span></a></h3>
                                                        </div>

                                                    <?php } ?>

                                                </div>
                                            </div>
                                            <span class="text-muted"><?php echo mysqli_num_rows($readyMove->block);  ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-condensed" data-toggle="collapse" data-target="#collapseBlockOccupied" aria-expanded="false" aria-controls="collapseExample">
                                            <div>
                                                <h6 class="my-0">Occupied</h6>
                                                <div class="collapse" id="collapseBlockOccupied">
                                                    <br>

                                                    <?php while ($roccupied =  mysqli_fetch_array($occupied->block)) {

                                                        $split = str_split($roccupied['room_id']);

                                                        ?>

                                                        <div style="float:left;">
                                                            <h3 style="margin-left:3px;"><a href="<?php echo BASE_URL . 'hostel/view/hos/' . $hos . '/block/' . $split[0] . '/floor/' . $split[1] . '/room/';
                                                                                                    if ($split[2] == 0) {
                                                                                                        echo $split[3];
                                                                                                    } else {
                                                                                                        echo $split[2] . $split[3];
                                                                                                    } ?>"><span class="badge badge-primary"><?php echo $roccupied['room_id']; ?></span></a></h3>
                                                        </div>

                                                    <?php } ?>

                                                </div>
                                            </div>
                                            <span class="text-muted"><?php echo mysqli_num_rows($occupied->block);  ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-condensed" data-toggle="collapse" data-target="#collapseBlockSingle" aria-expanded="false" aria-controls="collapseExample">
                                            <div>
                                                <h6 class="my-0">Single Occupied Rooms</h6>
                                                <div class="collapse" id="collapseBlockSingle">
                                                    <br>

                                                    <?php while ($damageHostel =  mysqli_fetch_array($damageRoom->blockSingle)) {

                                                        $split = str_split($damageHostel['room_id']);


                                                        ?>

                                                        <div style="float:left;">
                                                            <h3 style="margin-left:3px;"><a href="<?php echo BASE_URL . 'hostel/view/hos/' . $hos . '/block/' . $split[0] . '/floor/' . $split[1] . '/room/';
                                                                                                    if ($split[2] == 0) {
                                                                                                        echo $split[3];
                                                                                                    } else {
                                                                                                        echo $split[2] . $split[3];
                                                                                                    } ?>"><span class="badge badge-primary"><?php echo $damageHostel['room_id']; ?></span></a></h3>
                                                        </div>

                                                    <?php } ?>

                                                </div>
                                            </div>
                                            <span class="text-muted"><?php echo mysqli_num_rows($damageRoom->blockSingle); ?></span>
                                        </li>
                                    </ul>

                                <?php } ?>

                                <?php if ($floor != 'NA' && $block != 'NA') { ?>

                                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                                        <h5>Overall Details Floor wise </h5>
                                    </h4>

                                    <ul class="list-group mb-3">
                                        <li class="list-group-item d-flex justify-content-between lh-condensed" data-toggle="collapse" data-target="#collapseFloor1" aria-expanded="false" aria-controls="collapseExample">
                                            <div>
                                                <h6 class="my-0">Damaged Floors</h6>
                                                <div class="collapse" id="collapseFloor1">
                                                    <br>

                                                    <?php while ($damageHostel =  mysqli_fetch_array($damageRoom->floor)) {

                                                        $split = str_split($damageHostel['room_id']);


                                                        ?>

                                                        <div style="float:left;">
                                                            <h3 style="margin-left:3px;"><a href="<?php echo BASE_URL . 'hostel/view/hos/' . $hos . '/block/' . $split[0] . '/floor/' . $split[1] . '/room/';
                                                                                                    if ($split[2] == 0) {
                                                                                                        echo $split[3];
                                                                                                    } else {
                                                                                                        echo $split[2] . $split[3];
                                                                                                    } ?>"><span class="badge badge-primary"><?php echo $damageHostel['room_id']; ?></span></a></h3>
                                                        </div>

                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <span class="text-muted"><?php echo mysqli_num_rows($damageRoom->floor); ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-condensed" data-toggle="collapse" data-target="#collapsefloorReady" aria-expanded="false" aria-controls="collapseExample">
                                            <div>
                                                <h6 class="my-0">Ready To Move</h6>
                                                <div class="collapse" id="collapsefloorReady">
                                                    <br>

                                                    <?php while ($readyMoves =  mysqli_fetch_array($readyMove->floor)) {

                                                        $split = str_split($readyMoves['room_id']);

                                                        ?>

                                                        <div style="float:left;">
                                                            <h3 style="margin-left:3px;"><a href="<?php echo BASE_URL . 'hostel/view/hos/' . $hos . '/block/' . $split[0] . '/floor/' . $split[1] . '/room/';
                                                                                                    if ($split[2] == 0) {
                                                                                                        echo $split[3];
                                                                                                    } else {
                                                                                                        echo $split[2] . $split[3];
                                                                                                    } ?>"><span class="badge badge-primary"><?php echo $readyMoves['room_id']; ?></span></a></h3>
                                                        </div>

                                                    <?php } ?>

                                                </div>
                                            </div>
                                            <span class="text-muted"><?php echo mysqli_num_rows($readyMove->floor);  ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-condensed" data-toggle="collapse" data-target="#collapseFloorOccupied" aria-expanded="false" aria-controls="collapseExample">
                                            <div>
                                                <h6 class="my-0">Occupied</h6>
                                                <div class="collapse" id="collapseFloorOccupied">
                                                    <br>

                                                    <?php while ($roccupied =  mysqli_fetch_array($occupied->floor)) {

                                                        $split = str_split($roccupied['room_id']);

                                                        ?>

                                                        <div style="float:left;">
                                                            <h3 style="margin-left:3px;"><a href="<?php echo BASE_URL . 'hostel/view/hos/' . $hos . '/block/' . $split[0] . '/floor/' . $split[1] . '/room/';
                                                                                                    if ($split[2] == 0) {
                                                                                                        echo $split[3];
                                                                                                    } else {
                                                                                                        echo $split[2] . $split[3];
                                                                                                    } ?>"><span class="badge badge-primary"><?php echo $roccupied['room_id']; ?></span></a></h3>
                                                        </div>

                                                    <?php } ?>

                                                </div>
                                            </div>
                                            <span class="text-muted"><?php echo mysqli_num_rows($occupied->floor);  ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-condensed" data-toggle="collapse" data-target="#collapseFloorSingle" aria-expanded="false" aria-controls="collapseExample">
                                            <div>
                                                <h6 class="my-0">Single Occupied Rooms</h6>
                                                <div class="collapse" id="collapseFloorSingle">
                                                    <br>

                                                    <?php while ($damageHostel =  mysqli_fetch_array($damageRoom->floorSingle)) {

                                                        $split = str_split($damageHostel['room_id']);

                                                        ?>

                                                        <div style="float:left;">
                                                            <h3 style="margin-left:3px;"><a href="<?php echo BASE_URL . 'hostel/view/hos/' . $hos . '/block/' . $split[0] . '/floor/' . $split[1] . '/room/';
                                                                                                    if ($split[2] == 0) {
                                                                                                        echo $split[3];
                                                                                                    } else {
                                                                                                        echo $split[2] . $split[3];
                                                                                                    } ?>"><span class="badge badge-primary"><?php echo $damageHostel['room_id']; ?></span></a></h3>
                                                        </div>

                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <span class="text-muted"><?php echo mysqli_num_rows($damageRoom->floorSingle); ?></span>
                                        </li>
                                    </ul>

                                <?php } ?>
                            </div>
                            <div class="col-md-8 order-md-1">
                                <h4 class="mb-3">Room details</h4>
                                <hr>
                                <form id="myForm" enctype="multipart/form-data" method="post" name="myForm">
                                    <input name="room_id" id="room_id" type="text" hidden value="<?php echo $room_id; ?>">
                                    <input id="hos" name="hos" type="text" value="<?php echo $hos; ?>" hidden />
                                    <h5 class="mb-3">Occupants : 1 </h5>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="name_1">Name</label>
                                            <input type="text" name="name_1" class="form-control" id="name_1" placeholder="Name.." value="<?php echo $occupants->first['name']; ?>" required="">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="roll_1">Roll No</label>
                                            <input type="text" name="roll_1" class="form-control" id="roll_1" placeholder="Roll no.." value="<?php echo $occupants->first['roll']; ?>" required="">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="email_1">Email</label>
                                            <input type="text" name="email_1" class="form-control" id="email_1" placeholder="Email.." value="<?php echo $occupants->first['email']; ?>" required="">
                                            <div class="invalid-feedback">
                                                Valid last name is required.
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="mobile_1">Mobile</label>
                                            <input type="number" name="mobile_1" class="form-control" id="mobile_1" placeholder="Mobile.." value="<?php echo $occupants->first['mobile']; ?>" required="">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="super_1">Supervision / Faculty</label>
                                            <input type="text" name="super_1" class="form-control" id="super_1" placeholder="Supervision / Faculty" value="<?php echo $occupants->first['supervision']; ?>" required="">
                                        </div>
                                    </div>
                                    <hr>
                                    <h5 class="mb-3">Occupants : 2 </h5>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="name_2">Name</label>
                                            <input type="text" name="name_2" class="form-control" id="name_2" placeholder="Name.." value="<?php echo $occupants->second['name']; ?>" required="">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="roll_2">Roll No</label>
                                            <input type="text" name="roll_2" class="form-control" id="roll_2" placeholder="Roll no.." value="<?php echo $occupants->second['roll']; ?>" required="">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="email_2">Email</label>
                                            <input type="text" name="email_2" class="form-control" id="email_2" placeholder="Email.." value="<?php echo $occupants->second['email']; ?>" required="">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="mobile_2">Mobile</label>
                                            <input type="number" name="mobile_2" class="form-control" id="mobile_2" placeholder="Mobile.." value="<?php echo $occupants->second['mobile']; ?>" required="">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="super_2">Supervision / Faculty</label>
                                            <input type="text" name="super_2" class="form-control" id="super_2" placeholder="Supervision / Faculty" value="<?php echo $occupants->second['supervision']; ?>" required="">
                                        </div>
                                    </div>

                                    <hr>
                                    <h5 class="mb-3">Occupants : 3 </h5>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="name_3">Name</label>
                                            <input type="text" name="name_3" class="form-control" id="name_3" placeholder="Name.." value="<?php echo $occupants->third['name']; ?>" required="">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="roll_3">Roll No</label>
                                            <input type="text" name="roll_3" class="form-control" id="roll_3" placeholder="Roll no.." value="<?php echo $occupants->third['roll']; ?>" required="">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="email_3">Email</label>
                                            <input type="text" name="email_3" class="form-control" id="email_3" placeholder="Email.." value="<?php echo $occupants->third['email']; ?>" required="">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="mobile_3">Mobile</label>
                                            <input type="number" name="mobile_3" class="form-control" id="mobile_3" placeholder="Mobile.." value="<?php echo $occupants->third['mobile']; ?>" required="">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="super_3">Supervision / Faculty</label>
                                            <input type="text" name="super_3" class="form-control" id="super_3" placeholder="Supervision / Faculty" value="<?php echo $occupants->third['supervision']; ?>" required="">
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">

                                            <label for="single">Occupants Type : </label>
                                            <select id="single" name="single" class="selectpicker show-tick form-control" data-live-search="true">
                                                <option value="NA">--Select occupants type--</option>
                                                <option value="S" <?php if ($roomStatus['single'] == 'S') {
                                                                        echo 'selected';
                                                                    } ?>>Single</option>
                                                <option value="D" <?php if ($roomStatus['single'] == 'D') {
                                                                        echo 'selected';
                                                                    } ?>>Double</option>
                                                <option value="T" <?php if ($roomStatus['single'] == 'T') {
                                                                        echo 'selected';
                                                                    } ?>>Tripal</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <p>Previous Occupants</p>
                                            <h5>1) <?php echo explode('.', $occupants->previous)[0]; ?></h5>
                                            <h5>2) <?php echo explode('.', $occupants->previous)[1]; ?></h5>
                                            <h5>3) <?php echo explode('.', $occupants->previous)[2]; ?></h5>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5>Stock Status</h5>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="beds">Beds</label>
                                            <input type="number" name="beds" class="form-control" id="beds" placeholder="No. of Beds" value="<?php echo $stock['beds']; ?>">

                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="chairs">Chairs</label>
                                            <input type="number" name="chairs" class="form-control" id="chairs" placeholder="No. of Chairs" value="<?php echo $stock['chairs']; ?>">

                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="tables">Table</label>
                                            <input type="number" name="tables" class="form-control" id="tables" placeholder="No. of Table" required value="<?php echo $stock['tables']; ?>">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="fans">Fan</label>
                                            <input type="number" name="fans" class="form-control" id="fans" placeholder="No. of Fan" required="" value="<?php echo $stock['fans']; ?>">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="tubelights">Tubelight</label>
                                            <input type="number" name="tubelights" class="form-control" id="tubelights" placeholder="No. of Tubelights" required="" value="<?php echo $stock['tubelights']; ?>">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="dt">Type of damage : </label>
                                            <select id="dt" name="dt" class="selectpicker show-tick form-control" data-live-search="true">
                                                <option value="NA">--Select Damage--</option>
                                                <option value="SP" <?php if ($roomStatus['dt'] == 'SP') {
                                                                        echo 'selected';
                                                                    } ?>>Seepage</option>
                                                <option value="DB" <?php if ($roomStatus['dt'] == 'DB') {
                                                                        echo 'selected';
                                                                    } ?>>Door Broken</option>
                                                <option value="NP" <?php if ($roomStatus['dt'] == 'NP') {
                                                                        echo 'selected';
                                                                    } ?>>Need Painting</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="rs">Room Status</label>
                                            <select id="rs" name="rs" class="selectpicker show-tick form-control" data-live-search="true">
                                                <option value="NA">--Select Status--</option>
                                                <option value="OC" <?php if ($roomStatus['rs'] == 'OC') {
                                                                        echo 'selected';
                                                                    } ?>>Occupied</option>
                                                <option value="RM" <?php if ($roomStatus['rs'] == 'RM') {
                                                                        echo 'selected';
                                                                    } ?>>Ready to move</option>
                                                <option value="DM" <?php if ($roomStatus['rs'] == 'DM') {
                                                                        echo 'selected';
                                                                    } ?>>Damaged</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="comments">Comments</label>
                                            <textarea id="comments" name="comments" placeholder="Comments" class="form-control here" type="text"><?php echo $roomStatus['comment']; ?></textarea>
                                        </div>

                                    </div>
                                    <input style="display:none;" hidden type="text" name="token" id="token" value="<?php $config = new Config();
                                                                                                                    echo $config->secret; ?> ">
                                    <hr class="mb-4">
                                    <a class="btn btn-primary btn-lg btn-block" id="updateButton" type="button">Update Details</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <script src="<?php echo BASE_URL; ?>media/hostel/js/bootstrap-select.js"></script>
    <script src="<?php echo BASE_URL; ?>media/hostel/js/main_view.js"></script>
    <script>
        document.querySelectorAll('input').forEach((val) => {
            val.setAttribute("readonly", "true");
        });
    </script>
</body>

</html>