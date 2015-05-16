<?php
$hostname='mydb.ics.purdue.edu';
$username='cvn';
$password='stag3d00r';
$dbname='cvn';
mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);
include("assets/includes/constants.php");

sendEmail(542,190,'thank-you');
echo "ok.";
?>