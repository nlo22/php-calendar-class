<?php

include('../calendar.class.php');

$cal = new Calendar();
$days = $cal->getCalenderMonthDays(); 

var_dump($days);

?>