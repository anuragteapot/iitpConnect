<?php
/**
* @package    iitpConnect.Site
*
* @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
* @license    GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_EXEC') or die;

if(User::isLoggedIn())
{
    header('Location: ' . BASE_URL);
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Register</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/system/css/core.css" />
    <script src="<?php echo BASE_URL; ?>media/system/js/core.js"></script>
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>templates/images/logo.svg">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/login/css/main.css" />
    <style>
    #cancel
    {
        text-decoration:none;
        font-size: 20px;
    }

    html
    {
        height: 100%;
    }
    </style>
</head>
<body>
    <div style="display:none;" id="backdrop" class="modal-backdrop fade show"></div>
    <div style="display:none;" class="bar" id="loader"><div></div></div>
    <div id="snackbar"></div>
    <div class="container">
        <div id="contact">
            <div id="state">
                <h1 id="response"></h1>
            </div>
            <br>
            <a id="redirect"></a>
            <div id="field">
                <h3>Register</h3>
                <br>
                <fieldset>
                    <input id="name" placeholder="Name" type="text" tabindex="1" required autofocus>
                </fieldset>
                <fieldset>
                    <input id="username" placeholder="Username your roll number / emp id" type="text" tabindex="1" required autofocus>
                </fieldset>
                <fieldset>
                    <input id="password" placeholder="Password" type="password" tabindex="1" required autofocus>
                </fieldset>
                <fieldset>
                    <input id="email" placeholder="Email : Use you IITP webmail." type="email" tabindex="2" required>
                </fieldset>
                <!-- <fieldset>
                <input id="secret" placeholder="Secret key" type="password" tabindex="3" required>
            </fieldset> -->
            <fieldset>
                <button id="login">Register</button>
            </fieldset>
            <br>
            <div style="text-align:center;">
                <a style=" float:left;" id="cancel" href="<?php echo BASE_URL; ?>">Cancel</a>
                <a style=" float:center;" id="cancel" href="<?php echo BASE_URL . 'forget';  ?>">Forget?</a>
                <a style=" float:right;" id="cancel" href="<?php echo BASE_URL . 'login'; ?>">Login</a>
                <div>
                    <fieldset >
                        <input hidden type="text" id="token" value="<?php $config = new Config(); echo $config->secret; ?> ">
                    </fieldset>
                </div>
            </div>
        </div>
    </body>
    <script src="<?php echo BASE_URL; ?>media/register/js/main.js"></script>
    </html>
