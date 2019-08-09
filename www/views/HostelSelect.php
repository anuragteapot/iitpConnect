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

$numHostels = $controller->getHostels();
$hos = urldecode($router->get('hos'));

$numBlocks = $controller->getBlocks($hos);

if ($block != 'NA' && $hos != 'NA') {
    $block = $router->get('block');
    $blockInfo = $controller->getBlockInfo($block, $hos);
    $result = mysqli_fetch_array($blockInfo);

    $start = $result['start'];
    $end = $result['end'];
}

$floor = $router->get('floor');
$room = $router->get('room');

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
    </div>
    <div class="container-fluid">
        <section class="main">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4>Block Action</h4>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form>
                                            <div class="form-group row">
                                                <label for="name" class="col-4 col-form-label"><strong>Hostel : </strong></label>
                                                <div class="col-8 text-left">
                                                    <select id="hostel" class="selectpicker show-tick form-control" data-live-search="true">
                                                        <option value="NA">--Select Hostel--</option>
                                                        <?php while ($resHostel = mysqli_fetch_array($numHostels)) { ?>

                                                            <option value="<?php echo $resHostel['hostel_name']; ?>" <?php if ($hos == $resHostel['hostel_name']) {
                                                                                                                            echo ' selected ';
                                                                                                                        } ?>><?php echo $resHostel['hostel_name']; ?></option>

                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name" class="col-4 col-form-label"><strong>Block : </strong></label>
                                                <div class="col-8 text-left">
                                                    <select id="block" class="selectpicker show-tick form-control" data-live-search="true">
                                                        <option value="NA">--Select Block--</option>
                                                        <?php while ($resBlocks = mysqli_fetch_array($numBlocks)) { ?>

                                                            <option value="<?php echo $resBlocks['blocks']; ?>" <?php if ($block == $resBlocks['blocks']) {
                                                                                                                    echo ' selected ';
                                                                                                                } ?>>Block <?php echo $resBlocks['blocks']; ?></option>

                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="lastname" class="col-4 col-form-label"><strong>Floor : </strong></label>
                                                <div class="col-8 text-left">
                                                    <select id="floor" class="selectpicker show-tick form-control" data-live-search="true">
                                                        <option value="NA">--Select Floor--</option>
                                                        <?php while ($start <= $result['end']) { ?>

                                                            <option <?php if ($floor == $start && $start != '') {
                                                                        echo 'selected';
                                                                    } ?> value="<?php echo $start; ?>">Floor <?php echo $start; ?></option>

                                                            <?php $start++;
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-4 col-form-label"><strong>Room no :</strong></label>
                                                <div class="col-8">
                                                    <select id="room" class="selectpicker show-tick form-control" data-live-search="true">
                                                        <option value="NA">--Select Room--</option>
                                                        <?php $rc = 0;
                                                        while ($rc <= $result['number'] && $result['number'] != 0) { ?>

                                                            <option <?php if ($room == $rc) {
                                                                        echo 'selected';
                                                                    } ?> value="<?php echo $rc; ?>">Room <?php echo $rc; ?></option>

                                                            <?php $rc++;
                                                        } ?>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-4 col-8">
                                                    <a id="checkBlock" name="submit" class="btn btn-success">Check Block</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <form>
                                            <div class="form-group row">
                                                <label for="name" class="col-4 col-form-label"><strong>Hostel : </strong></label>
                                                <div class="col-8 text-left">
                                                    <input id="inputHostel" name="inputHostel" placeholder="Hostel Name" class="form-control here" type="text">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name" class="col-4 col-form-label"><strong>Block : </strong></label>
                                                <div class="col-8 text-left">
                                                    <input id="inputBlock" name="inputBlock" placeholder="Block Name" class="form-control here" type="text">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="lastname" class="col-4 col-form-label"><strong>Floor Start : </strong></label>
                                                <div class="col-8 text-left">
                                                    <input id="inputFloorStart" name="inputFloorStart" placeholder="Floor Start" class="form-control here" type="text">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-4 col-form-label"><strong>Floor End :</strong></label>
                                                <div class="col-8">
                                                    <input id="inputFloorEnd" name="inputFloorEnd" placeholder="Floor End" class="form-control here" type="text">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-4 col-form-label"><strong>Total number of room at each floor:</strong></label>
                                                <div class="col-8">
                                                    <input id="inputRoom" name="inputRoom" placeholder="Total Rooms" class="form-control here" type="text">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-4 col-8">
                                                    <a id="addBlock" name="submit" class="btn btn-success">Add Block</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4>Search</h4>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form>
                                            <div class="form-group row">
                                                <label for="name" class="col-4 col-form-label"><strong>Search By: </strong></label>
                                                <div class="col-8 text-left">
                                                    <select id="searchBy" class="selectpicker show-tick form-control" data-live-search="true">
                                                        <option value="RN" selected>By Roll Number</option>
                                                        <option value="NAME">Room Id</option>
                                                        <!-- <option value="MN">By Mobile Number</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <form>
                                            <div class="form-group row">
                                                <label for="searchData" class="col-4 col-form-label"><strong>Data : </strong></label>
                                                <div class="col-8 text-left">
                                                    <input id="searchData" name="searchData" placeholder="Search Data" class="form-control here" type="text">
                                                </div>
                                            </div>
                                        </form>
                                        <div class="form-group row">
                                            <div class="offset-4 col-8">
                                                <a id="search" name="submit" class="btn btn-success">Search</a>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Room Id</th>
                                                <th scope="col">Roll</th>
                                                <th scope="col">Previous</th>
                                                <th scope="col">Hostel Name</th>
                                                <th scope="col">Get Full Info</th>
                                            </tr>
                                        </thead>
                                        <tbody id="searchResult">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <input style="display:none;" hidden type="text" id="token" value="<?php $config = new Config();
                                                                            echo $config->secret; ?> ">
    </div>
    <script src="<?php echo BASE_URL; ?>media/hostel/js/bootstrap-select.js"></script>
    <script src="<?php echo BASE_URL; ?>media/hostel/js/main.js"></script>
</body>

</html>