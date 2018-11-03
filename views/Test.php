<?php

echo 'Date calculation.';

echo '<pre>';

echo 'Casual leave';
echo '<pre>';

$app = new LeaveController;

$start = '2018-11-01';
$end = '2018-11-9';

echo $app->earnedleave($start, $end);
