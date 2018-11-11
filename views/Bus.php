<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 defined('_EXEC') or die;

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
  <div style="display:none;" class="bar" id="loader"><div></div></div>
  <div id="snackbar"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Home</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </nav>
    <div class="jumbotron text-center">
        <h1>Bus Management System</h1>
    </div>
    <div class="container-fluid">
    <section class="main">
      <div class="row">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <i class='fas fa-user float-left' style='font-size:36px'></i>
                <h4 style="padding-left:50px;">Information</h4>
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col text-center">
                <div class="row">
                  <div class="col-md-12">
                    <form>
                      <div class="form-group row">
                        <label for="name" class="col-4 col-form-label"><strong>From : </strong></label>
                        <div class="col-8 text-left">
                          <input id="source" name="Purpose" placeholder="Source" class="form-control here" type="text">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="lastname" class="col-4 col-form-label"><strong>To : </strong></label>
                        <div class="col-8 text-left">
                          <input id="to" name="to" placeholder="To" class="form-control here" type="text">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="email" class="col-4 col-form-label"><strong>Date :<br>(dd/mm/yyyy)</strong></label>
                        <div class="col-8">
                            <input id="datepicker1" value="dd/mm/yyyy"/>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-4 col-8">
                          <a id="submit" name="submit" class="btn btn-success">Check</a>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="username" class="col-4 col-form-label"><strong>Name : </strong></label>
                        <div class="col-8 text-left">
                          <input id="leave-address" name="Purpose" placeholder="Name" class="form-control here" type="text">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="username" class="col-4 col-form-label"><strong>Email : </strong></label>
                        <div class="col-8 text-left">
                          <input id="email" name="email" placeholder="Email" class="form-control here" type="text">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="phonenumber" class="col-4 col-form-label"><strong>Phonenumber : </strong></label>
                        <div class="col-8 text-left">
                          <input id="phonenumber" name="phonenumber" placeholder="Phonenumber" class="form-control here" type="text">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="BusId" class="col-4 col-form-label"><strong>BusId : </strong></label>
                        <div class="col-8 text-left">
                          <input id="BusId" name="BusId" placeholder="Bus Id" class="form-control here" type="text">
                        </div>
                      </div>
                      <!-- <div class="form-group row">
                        <label for="text" class="col-4 col-form-label"><strong>Emp. Code : </strong></label>
                        <div class="col-8 text-left">
                          <input id="leave-address" name="Purpose" placeholder="Leave Address " class="form-control here" type="text">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="text" class="col-4 col-form-label"><strong>Date of Joining : </strong></label>
                        <div class="col-8 text-left">
                          <input id="leave-address" name="Purpose" placeholder="Leave Address " class="form-control here" type="text">
                        </div>
                      </div>
                      <div class="form-group row">
                        <input hidden id="emp-code" value="308" type="text"/>
                        <label for="select" class="col-4 col-form-label"><strong>Nature of Leave : </strong></label>
                        <div class="col-8 text-left">
                          <select id="nol" class="selectpicker show-tick form-control" data-live-search="true">
                            <option value="l0" selected>--Select Leave Type--</option>
                            <option value="SL">Station Leaving</option>
                            <option value="CL">Casual Leave</option>
                            <option value="EL">Earned Leave</option>
                            <option value="V">Vacation</option>
                            <option value="ML">Medical Leave</option>
                            <option value="DL">Duty Leave</option>
                            <option value="SCL">Sepcial Casual Leave</option>
                            <option value="LPW">Leave for Project Work</option>
                            <option value="_SL">Sabatical Leave</option>
                            <option value="EOL">Extra Ordinary Leave</option>
                            <option value="RH">Restricted Holiday</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="website" class="col-4 col-form-label"><strong>Leave Up To :<br>(dd/mm/yyyy)</strong></label>
                        <div class="col-4">
                            <input id="datepicker2" value="dd/mm/yyyy"/>
                        </div>
                        <div class="col-4">
                          <input id="datepicker2-upto" type="checkbox" data-toggle="toggle" data-off="Forenoon" data-on="Afternoon" data-onstyle="warning" data-offstyle="info">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="newpass" class="col-4 col-form-label"><strong>Purpose</strong></label>
                        <div class="col-8 text-left">
                          <input id="purpose" name="Purpose" placeholder="Purpose" class="form-control here" type="text">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="newpass" class="col-4 col-form-label"><strong>Reference number and date of approval from the competent authority
                          (for Special casual Leave, Duty Leave and Leave for Project Work)</strong></label>
                        <div class="col-8 text-left">
                          <input id="refrence" name="refrence" placeholder="Reference number" class="form-control here" type="text">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="newpass" class="col-4 col-form-label"><strong>Leave Address : </strong></label>
                        <div class="col-8 text-left">
                          <input id="leave-address" name="Purpose" placeholder="Leave Address " class="form-control here" type="text">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="newpass" class="col-4 col-form-label"><strong>Leave Arrangements :</strong></label>
                        <div class="col-8 text-left">
                          <textarea  id="leave-arrangements" name="leave adress" placeholder="Leave Arrangements" class="form-control here" type="text"></textarea>
                        </div>
                      </div>
                      <br>-->
                      <div class="form-group row">
                        <div class="offset-4 col-8">
                          <a id="submit" name="submit" class="btn btn-success">Book</a>
                        </div>
                      </div>
                      <br>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col text-center">
                <div class="second table-responsive" style="background-color:white;">
                  <table class="table table-bordered table-striped table-hover">
                    <thead  class="thead-dark">
                      <tr>
                        <th scope="col">Bus ID</th>
                        <th scope="col">Departure</th>
                        <th scope="col">Arrival</th>
                        <th scope="col">Fare</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>11/05/2018</td>
                        <td>11/05/2018</td>
                        <td>40</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>11/05/2018</td>
                        <td>11/05/2018</td>
                        <td>40</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>11/05/2018</td>
                        <td>11/05/2018</td>
                        <td>40</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <input style="display:none;" hidden type="text" id="token" value="<?php $config = new Config(); echo $config->secret; ?> ">
  </div>
  <script src="<?php echo BASE_URL; ?>media/bus/js/bootstrap-select.js"></script>
  <script src="<?php echo BASE_URL; ?>media/bus/js/main.js"></script>
  <script>
      $('#datepicker1').datepicker({
          uiLibrary: 'bootstrap4'
      });

      $('#datepicker2').datepicker({
          uiLibrary: 'bootstrap4'
      });

      $('#datepicker3').datepicker({
          uiLibrary: 'bootstrap4'
      });

      $('#datepicker4').datepicker({
          uiLibrary: 'bootstrap4'
      });

      $(function() {
        $('#sld').change(function(){
          $('.stoggle').hide();
          $('#' + $(this).val()).show();
        });
      });
  </script>
</body>
</html>
