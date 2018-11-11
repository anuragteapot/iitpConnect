<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 defined('_EXEC') or die;
?>

<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Cab Share</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>media/system/css/core.css" />
    <script src="<?php echo BASE_URL; ?>media/system/js/core.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css">
    <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>media/vendor/tui-calendar/css/tui-calendar.css" />
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>templates/images/logo.svg">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>media/vendor/tui-calendar/css/default.css"></link>
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>media/vendor/tui-calendar/css/icons.css"></link>
    <style>
    body
    {
        background-color: #f5f7fa;
    }
    </style>
</head>
<body>
<div style="display:none;" class="bar" id="loader"><div></div></div>
  <div id="snackbar"></div>
    <div id="top">
      <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">Home</a>
      <a href="<?php echo BASE_URL; ?>post/" class="btn btn-primary">Back</a>
      <?php if(User::isLoggedIn()) : ?>
      <a href="<?php echo BASE_URL; ?>profile/" class="btn btn-primary">Profile settings</a>
    <?php endif; ?>
    </div>
    <div id="lnb">
      <?php   if(User::isLoggedIn()) : ?>
        <div class="lnb-new-schedule">
            <button id="btn-new-schedule" type="button" class="btn btn-default btn-block lnb-new-schedule-btn" data-toggle="modal">
                New schedule</button>
        </div>
      <?php else: ?>
        <div class="lnb-new-schedule">
            <a href="<?php echo BASE_URL; ?>login/" type="button" class="btn btn-default btn-block lnb-new-schedule-btn" >
                Login</a>
        </div>
      <?php endif; ?>
        <div id="lnb-calendars" class="lnb-calendars">
            <div>
                <div class="lnb-calendars-item">
                    <label>
                        <input class="tui-full-calendar-checkbox-square" type="checkbox" value="all" checked>
                        <span></span>
                        <strong>View all</strong>
                    </label>
                </div>
            </div>
            <div id="calendarList" class="lnb-calendars-d1">
            </div>
        </div>

        <div id="user-det" class="lnb-calendars">
            <div>
                <div class="lnb-calendars-item">
                    <label>
                        <strong>User Details</strong>
                    </label>
                </div>
            </div>
            <div class="lnb-calendars-d1">
              <p><strong>Name :- </strong><a id="name" href="javascript:void(0);"></a></p>
              <p><strong>Username :- </strong><a id="username" href=""></a></p>
              <p><strong>Email :- </strong><a id="email" href="javascript:void(0);"></a></p>
              <strong>Phone Number :- </strong><p id="phoneNum"></p>
              <strong>Address :- </strong><p id="address"></p>
              <strong>Institute :- </strong><p id="institute"></p>
            </div>
        </div>
    </div>
    <div id="right">
        <div id="menu">
            <span class="dropdown">
                <button id="dropdownMenu-calendarType" class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                    <i id="calendarTypeIcon" class="calendar-icon ic_view_month" style="margin-right: 4px;"></i>
                    <span id="calendarTypeName">Dropdown</span>&nbsp;
                    <i class="calendar-icon tui-full-calendar-dropdown-arrow"></i>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu-calendarType">
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-daily">
                            <i class="calendar-icon ic_view_day"></i>Daily
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weekly">
                            <i class="calendar-icon ic_view_week"></i>Weekly
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-monthly">
                            <i class="calendar-icon ic_view_month"></i>Month
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks2">
                            <i class="calendar-icon ic_view_week"></i>2 weeks
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks3">
                            <i class="calendar-icon ic_view_week"></i>3 weeks
                        </a>
                    </li>
                    <li role="presentation" class="dropdown-divider"></li>
                    <li role="presentation">
                        <a role="menuitem" data-action="toggle-workweek">
                            <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-workweek" checked>
                            <span class="checkbox-title"></span>Show weekends
                        </a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" data-action="toggle-start-day-1">
                            <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-start-day-1">
                            <span class="checkbox-title"></span>Start Week on Monday
                        </a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" data-action="toggle-narrow-weekend">
                            <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-narrow-weekend">
                            <span class="checkbox-title"></span>Narrower than weekdays
                        </a>
                    </li>
                </ul>
            </span>
            <span id="menu-navi">
                <button type="button" class="btn btn-default btn-sm move-today" data-action="move-today">Today</button>
                <button type="button" class="btn btn-default btn-sm move-day" data-action="move-prev">
                    <i class="calendar-icon ic-arrow-line-left" data-action="move-prev"></i>
                </button>
                <button type="button" class="btn btn-default btn-sm move-day" data-action="move-next">
                    <i class="calendar-icon ic-arrow-line-right" data-action="move-next"></i>
                </button>
            </span>
            <span id="renderRange" class="render-range"></span>
        </div>
        <div id="calendar"></div>
        <input hidden type="text" id="token" value="<?php $config = new Config(); echo $config->secret; ?> ">
        <input hidden type="text" id="uid" value="<?php $app = new Session; echo $app->get('uid'); ?>">
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://uicdn.toast.com/tui.code-snippet/latest/tui-code-snippet.min.js"></script>
    <script type="text/javascript" src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
    <script type="text/javascript" src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chance/1.0.13/chance.min.js"></script>
    <script src="<?php echo BASE_URL; ?>media/vendor/tui-calendar/js/tui-calendar.js"></script>
    <script src="<?php echo BASE_URL; ?>media/vendor/tui-calendar/js/data/calendars.js"></script>
    <script src="<?php echo BASE_URL; ?>media/vendor/tui-calendar/js/data/schedules.js"></script>
    <script src="<?php echo BASE_URL; ?>media/vendor/tui-calendar/js/theme/dooray.js"></script>
    <script src="<?php echo BASE_URL; ?>media/vendor/tui-calendar/js/default.js"></script>
</body>
</html>
