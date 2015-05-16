<?php session_start();
$hostname='mydb.ics.purdue.edu';
$username='cvn';
$password='stag3d00r';
$dbname='cvn';
mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);


include("assets/includes/constants.php");

//$query = "SELECT * FROM User WHERE AcctType='UC'";
//$result = mysql_query($query);
//while($row = mysql_fetch_array($result)) {
	//echo $row['ID']."<br>";
	//sendEmail($userArray[$i]['ID'], $eventID, 'uc-email');
//}

//$_SESSION['Login'] = "jshennin@purdue.edu";
//$_SESSION['UID'] = 27;

?>