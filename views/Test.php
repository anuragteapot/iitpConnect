<?php

echo 'Date calculation.';

echo '<pre>';

echo 'Casual leave';
echo '<pre>';

$app = new LeaveController;

$start = '2018-11-01';
$end = '2018-11-09';

echo $app->checkSameYear($start, $end);
