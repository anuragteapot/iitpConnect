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
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/leave/css/main.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/leave/css/bootstrap-select.css" />
  <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/js/gijgo.min.js" type="text/javascript"></script>
  <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>templates/images/logo.svg">
  <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Home</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">Employees on leave</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Leave Record</a>
          </li>
        </ul>
          <button class="btn btn-success my-2 my-sm-0" type="submit">Logout</button>
      </div>
    </nav>
    <div class="jumbotron text-center">
        <h1>Leave and Station Leaving Application Form</h1>
    </div>
    <div class="container-fluid">
    <section class="main">
      <div class="row">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <i class='fas fa-user float-left' style='font-size:36px'></i>
                <h4 style="padding-left:50px;">Your Profile</h4>
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col text-center">
                <div class="row">
                  <div class="col-md-12">
                    <form>
                      <div class="form-group row">
                        <label for="username" class="col-4 col-form-label"><strong>Name : </strong></label>
                        <div class="col-8 text-left">
                          	Mayank Agarwal
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="name" class="col-4 col-form-label"><strong>Department : </strong></label>
                        <div class="col-8 text-left">
                           	Computer Science and Engineering
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="lastname" class="col-4 col-form-label"><strong>Designation : </strong></label>
                        <div class="col-8 text-left">
                          Assistant Professor
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="text" class="col-4 col-form-label"><strong>Emp. Code : </strong></label>
                        <div class="col-8 text-left">
                          308
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="text" class="col-4 col-form-label"><strong>Date of Joining : </strong></label>
                        <div class="col-8 text-left">
                          11-07-2018
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="select" class="col-4 col-form-label"><strong>Nature of Leave : </strong></label>
                        <div class="col-8 text-left">
                          <select id="basic" class="selectpicker show-tick form-control" data-live-search="true">
                            <option value="l0" selected>--Select Leave Type--</option>
                            <option value="l1">Station Leaving</option>
                            <option value="l2">Casual Leave</option>
                            <option value="l3">Earned Leave</option>
                            <option value="l4">Vacation</option>
                            <option value="l5">Medical Leave</option>
                            <option value="l6">Duty Leave</option>
                            <option value="l7">Sepcial Casual Leave</option>
                            <option value="l8">Leave for Project Work</option>
                            <option value="l9">Sabatical Leave</option>
                            <option value="l10">Extra Ordinary Leave</option>
                            <option value="RH">Restricted Holiday</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="email" class="col-4 col-form-label"><strong>Leave From :<br>(dd/mm/yyyy)</strong></label>
                        <div class="col-4">
                            <input id="datepicker1" value="dd/mm/yyyy"/>
                        </div>
                        <div class="col-4">
                          <input type="checkbox" data-toggle="toggle" data-off="Forenoon" data-on="Afternoon" data-onstyle="warning" data-offstyle="info">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="website" class="col-4 col-form-label"><strong>Leave Up To :<br>(dd/mm/yyyy)</strong></label>
                        <div class="col-4">
                            <input id="datepicker2" value="dd/mm/yyyy"/>
                        </div>
                        <div class="col-4">
                          <input type="checkbox" data-toggle="toggle" data-off="Forenoon" data-on="Afternoon" data-onstyle="warning" data-offstyle="info">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="publicinfo" class="col-4 col-form-label"><strong>Station Leaving Details :</strong></label>
                        <div class="col-8 text-left">
                          <select class="selectpicker show-tick form-control" id="colorselector">
                            <option value="NA">Not Applicable</option>
                            <option selected value="YES">YES</option>
                          </select>
                        </div>
                      </div>
                      <div id="YES" class="stoggle">
                        <div class="form-group row">
                          <label for="email" class="col-4 col-form-label"><strong>Leave From :<br>(dd/mm/yyyy)</strong></label>
                          <div class="col-4">
                              <input id="datepicker3" value="dd/mm/yyyy"/>
                          </div>
                          <div class="col-4">
                            <input type="checkbox" data-toggle="toggle" data-off="Forenoon" data-on="Afternoon" data-onstyle="warning" data-offstyle="info">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="website" class="col-4 col-form-label"><strong>Leave Up To :<br>(dd/mm/yyyy)</strong></label>
                          <div class="col-4">
                              <input id="datepicker4" value="dd/mm/yyyy"/>
                          </div>
                          <div class="col-4">
                            <input type="checkbox" data-toggle="toggle" data-off="Forenoon" data-on="Afternoon" data-onstyle="warning" data-offstyle="info">
                          </div>
                        </div>
                    </div>
                      <div class="form-group row">
                        <label for="newpass" class="col-4 col-form-label"><strong>Purpose</strong></label>
                        <div class="col-8 text-left">
                          <input name="Purpose" placeholder="Purpose" class="form-control here" type="text">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="newpass" class="col-4 col-form-label"><strong>Reference number and date of approval from the competent authority
                          (for Special casual Leave, Duty Leave and Leave for Project Work)</strong></label>
                        <div class="col-8 text-left">
                          <input name="Purpose" placeholder="Reference number" class="form-control here" type="text">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="newpass" class="col-4 col-form-label"><strong>Leave Address : </strong></label>
                        <div class="col-8 text-left">
                          <input name="Purpose" placeholder="Leave Address " class="form-control here" type="text">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="newpass" class="col-4 col-form-label"><strong>Leave Arrangements :</strong></label>
                        <div class="col-8 text-left">
                          <textarea name="Purpose" placeholder="Leave Arrangements" class="form-control here" type="text"></textarea>
                        </div>
                      </div>
                      <br>
                      <div class="form-group row">
                        <div class="offset-2 col-8">
                          <button name="submit" type="submit" class="btn btn-success">Submit Application</button>
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
                        <th scope="col">Nature of Leave</th>
                        <th scope="col">Applied</th>
                        <th scope="col">Canceled</th>
                        <th scope="col">Availed</th>
                        <th scope="col">Accumulated Balance</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">Station Leaving</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>asadsa</td>
                      </tr>
                      <tr>
                        <th scope="row">Casual Leave</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>asadsa</td>
                      </tr>
                      <tr>
                        <th scope="row">Earned Leave</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>asadsa</td>
                      </tr>
                      <tr>
                        <th scope="row">Vacation</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>asadsa</td>
                      </tr>
                      <tr>
                        <th scope="row">Medical Leave</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>asadsa</td>
                      </tr>
                      <tr>
                        <th scope="row">Duty Leave</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>asadsa</td>
                      </tr>
                      <tr>
                        <th scope="row">Special Casual Leave</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>asadsa</td>
                      </tr>
                      <tr>
                        <th scope="row">Leave for Project Work</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>asadsa</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">Sabatical Leave</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>asadsa</td>
                      </tr>
                      <tr>
                        <th scope="row">Extra Ordinary Leave</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>asadsa</td>
                      </tr>
                      <tr>
                        <th scope="row">Restricted Holiday</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>asadsa</td>
                      </tr>
                      <tr>
                        <th scope="row">Paternity Leave</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>asadsa</td>
                      </tr>
                      <tr>
                        <th scope="row">Maternity Leave</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>asadsa</td>
                      </tr>
                      <tr>
                        <th scope="row">Child Care Leave</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>asadsa</td>
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
  </div>
  <script src="<?php echo BASE_URL; ?>media/leave/js/bootstrap-select.js"></script>
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
        $('#colorselector').change(function(){
          $('.stoggle').hide();
          $('#' + $(this).val()).show();
        });
      });
  </script>
</body>
</html>
