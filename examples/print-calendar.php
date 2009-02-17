<?php

include('../calendar.class.php');

$cal = new Calendar(1, 2009);
$html = $cal->getHTML(); 

echo $html;

?>
