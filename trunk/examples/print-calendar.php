<?php

include('../calendar.class.php');

$cal = new Calendar(1, 2009);
echo $cal->getMonthHTML();

?>
