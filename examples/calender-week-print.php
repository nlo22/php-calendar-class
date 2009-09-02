<?php

include('../calendar.class.php');

$cal = new Calendar();

// print the days in week 2, show header, show full day names
echo $cal->getWeekHTML(2, true, true, 0);

?>
