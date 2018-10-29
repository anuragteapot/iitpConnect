<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 defined('_EXEC') or die;

 if(!User::isLoggedIn())
 {
   header('Location: ' . BASE_URL);
 }

$session = new Session;
$userDetails = User::getUser($session->get('username'));

$userPost = new PostController;
$res = $userPost->fetchUserPosts($userDetails['id']);
?>
<html>
<head>
  <title>Leave Arrangements</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/system/css/core.css" />
  <script src="<?php echo BASE_URL; ?>media/system/js/core.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ycije1qe3wsljxo43rypvv9zgiuc6g3tof66c2lqhusvd6gr"></script>
  <style>
  body
  {
    background-color: #f5f7fa;
  }

  .card
  {
    box-shadow: 0 0 20px #bacdea;
    background-color: white;
    border-radius: 5px;
    padding: 50px;
  }
  .container
  {
    width: 1370px;
  }
  </style>
</head>
<body>
  <span style="display:none;" id="loader" class="_it4vx _72fik"></span>
  <div id="snackbar"></div>
  <nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Leave Arrangements</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
      <li><a href="#">Page 3</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
  </div>
</nav>
  <div style="margin-bottom:200px" class="container">
    <div class="row" style="margin:60px 0px 30px 0px">
      <div class="text-center col-sm-12">
        <h1>
          Leave and Station Leaving Application Form
        </h1>
      </div>
    </div>
    <div class="row">
      <section class="card">
          <div id="invoice-template" class="card-body">
            <!-- Invoice Company Details -->
            <div id="invoice-company-details" class="row">
              <div class="col-md-6 col-sm-12 text-center text-md-left">
                <div class="media">
                  <div class="media-body">
                    <ul class="ml-2 px-0 list-unstyled">
                      <h2>Name</h2>
                      <li class="text-bold-800">Mr. Mayank Agarwal</li>
                      <br>
                      <h4>Designation</h4>
                      <li class="text-bold-800">Assistant Professor</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 text-center text-md-right">
                <h2>Department</h2>
                <ul class="px-0 list-unstyled">
                  <li>Computer Science and Engineering</li>
                </ul>
                <br>
                <h4>Emp. Code</h4>
                <ul class="px-0 list-unstyled">
                  <li>308</li>
                </ul>
              </div>
            </div>
            <!--/ Invoice Company Details -->
            <!-- Invoice Customer Details -->
            <div id="invoice-customer-details" class="row pt-2">
              <div class="col-md-6 col-sm-12 text-center text-md-left">
                <ul class="px-0 list-unstyled">

                </ul>
              </div>
              <div class="col-md-6 col-sm-12 text-center text-md-right">
                <p>
                  <span class="text-muted">Joining Date : </span> 06/05/2016</p>
              </div>
            </div>
            <br>
            <!--/ Invoice Customer Details -->
            <!-- Invoice Items Details -->
            <div id="invoice-items-details" class="pt-2">
              <div class="row">
                <div class="table-responsive col-sm-12">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Item &amp; Description</th>
                        <th class="text-right">Rate</th>
                        <th class="text-right">Hours</th>
                        <th class="text-right">Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>
                          <p>Create PSD for mobile APP</p>
                          <p class="text-muted">Simply dummy text of the printing and typesetting industry.</p>
                        </td>
                        <td class="text-right">$ 20.00/hr</td>
                        <td class="text-right">120</td>
                        <td class="text-right">$ 2400.00</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>
                          <p>iOS Application Development</p>
                          <p class="text-muted">Pellentesque maximus feugiat lorem at cursus.</p>
                        </td>
                        <td class="text-right">$ 25.00/hr</td>
                        <td class="text-right">260</td>
                        <td class="text-right">$ 6500.00</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>
                          <p>WordPress Template Development</p>
                          <p class="text-muted">Vestibulum euismod est eu elit convallis.</p>
                        </td>
                        <td class="text-right">$ 20.00/hr</td>
                        <td class="text-right">300</td>
                        <td class="text-right">$ 6000.00</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-md-7 col-sm-12 text-center text-md-left">
                  <p class="lead">Payment Methods:</p>
                  <div class="row">
                    <div class="col-md-8">
                      <table class="table table-borderless table-sm">
                        <tbody>
                          <tr>
                            <td>Bank name:</td>
                            <td class="text-right">ABC Bank, USA</td>
                          </tr>
                          <tr>
                            <td>Acc name:</td>
                            <td class="text-right">Amanda Orton</td>
                          </tr>
                          <tr>
                            <td>IBAN:</td>
                            <td class="text-right">FGS165461646546AA</td>
                          </tr>
                          <tr>
                            <td>SWIFT code:</td>
                            <td class="text-right">BTNPP34</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-md-5 col-sm-12">
                  <p class="lead">Total due</p>
                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>Sub Total</td>
                          <td class="text-right">$ 14,900.00</td>
                        </tr>
                        <tr>
                          <td>TAX (12%)</td>
                          <td class="text-right">$ 1,788.00</td>
                        </tr>
                        <tr>
                          <td class="text-bold-800">Total</td>
                          <td class="text-bold-800 text-right"> $ 16,688.00</td>
                        </tr>
                        <tr>
                          <td>Payment Made</td>
                          <td class="pink text-right">(-) $ 4,688.00</td>
                        </tr>
                        <tr class="bg-grey bg-lighten-4">
                          <td class="text-bold-800">Balance Due</td>
                          <td class="text-bold-800 text-right">$ 12,000.00</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="text-center">
                    <p>Authorized person</p>
                    <h6>Amanda Orton</h6>
                    <p class="text-muted">Managing Director</p>
                  </div>
                </div>
              </div>
            </div>
            <!-- Invoice Footer -->
            <div id="invoice-footer">
              <div class="row">
                <div class="col-md-7 col-sm-12">
                  <h6>Terms &amp; Condition</h6>
                  <p>You know, being a test pilot isn't always the healthiest business
                    in the world. We predict too much for the next year and yet far
                    too little for the next 10.</p>
                </div>
                <div class="col-md-5 col-sm-12 text-center">
                  <button type="button" class="btn btn-primary btn-lg my-1"><i class="fa fa-paper-plane-o"></i> Submit Application</button>
                </div>
              </div>
            </div>
            <!--/ Invoice Footer -->
          </div>
        </section>
    </div>
  </div>
</body>
</html>
