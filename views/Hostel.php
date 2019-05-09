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

$router = new Router;
// if ($router->get('hostel') == 'select') {
$router->get('block');
$router->get('floor');
$router->get('room');
// }
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
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/bus/css/main.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/system/css/core.css" />
    <script src="<?php echo BASE_URL; ?>media/system/js/core.js"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/bus/css/bootstrap-select.css" />
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
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
                                <h4>Select Block</h4>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col text-center">
                                <div class="row">
                                    <div class="col-md-6 offset-2">
                                        <form>
                                            <div class="form-group row">
                                                <label for="name" class="col-4 col-form-label"><strong>Block : </strong></label>
                                                <div class="col-8 text-left">
                                                    <select id="block" class="selectpicker show-tick form-control" data-live-search="true">
                                                        <option value="l0" selected>--Select Block--</option>
                                                        <option value="A">Block A</option>
                                                        <option value="B">Block B</option>
                                                        <option value="C">Block C</option>
                                                        <option value="D">Block D</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="lastname" class="col-4 col-form-label"><strong>Floor : </strong></label>
                                                <div class="col-8 text-left">
                                                    <select id="floor" class="selectpicker show-tick form-control" data-live-search="true">
                                                        <option value="l0" selected>--Select Floor--</option>
                                                        <option value="0">Floor 0</option>
                                                        <option value="1">Floor 1</option>
                                                        <option value="2">Floor 2</option>
                                                        <option value="3">Floor 3</option>
                                                        <option value="4">Floor 4</option>
                                                        <option value="5">Floor 5</option>
                                                        <option value="6">Floor 6</option>
                                                        <option value="7">Floor 7</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-4 col-form-label"><strong>Room no :</strong></label>
                                                <div class="col-8">
                                                    <select id="room" class="selectpicker show-tick form-control" data-live-search="true">
                                                        <option value="l0" selected>--Select Floor--</option>
                                                        <option value="0">Room 0</option>
                                                        <option value="1">Room 1</option>
                                                        <option value="2">Room 2</option>
                                                        <option value="3">Room 3</option>
                                                        <option value="4">Room 4</option>
                                                        <option value="5">Room 5</option>
                                                        <option value="6">Room 6</option>
                                                        <option value="7">Room 7</option>
                                                        <option value="8">Room 8</option>
                                                        <option value="9">Room 9</option>
                                                        <option value="10">Room 10</option>
                                                        <option value="11">Room 11</option>
                                                        <option value="12">Room 12</option>
                                                        <option value="13">Room 13</option>
                                                        <option value="14">Room 14</option>
                                                        <option value="15">Room 15</option>
                                                        <option value="16">Room 16</option>
                                                        <option value="17">Room 17</option>
                                                        <option value="18">Room 18</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-4 col-8">
                                                    <a id="submit" name="submit" class="btn btn-success">Submit</a>
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
        </section>
        <input style="display:none;" hidden type="text" id="token" value="<?php $config = new Config();
                                                                            echo $config->secret; ?> ">
    </div>
    <script src="<?php echo BASE_URL; ?>media/bus/js/bootstrap-select.js"></script>
    <script src="<?php echo BASE_URL; ?>media/bus/js/main.js"></script>
</body>

</html>
