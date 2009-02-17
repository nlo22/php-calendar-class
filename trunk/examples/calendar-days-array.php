<?php

include('../calendar.class.php');

$cal = new Calendar(1, 2009);
$days = $cal->getCalenderMonthDays(); 

var_dump($days);

?>