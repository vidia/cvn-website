<option value="None">-- None --</option>
<?php

include_once("assets/includes/constants.php"); 

$hostname='localhost';
$username='cvn_main';
$password='stag3d00r';
$dbname='cvn_main';
mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);

$SQL2 = "SELECT U.ID as ID, U.LastName as LastName, U.FirstName as FirstName, U.Email as Email, Atten.RequestStatus as RequestStatus FROM User U LEFT JOIN (SELECT * FROM Attendance WHERE EventID='".$_GET['event']."') as Atten ON Atten.UserID=U.ID ORDER BY LastName";
echo $SQL2."<br>";
$result2 = mysql_query($SQL2);
while($row2 = mysql_fetch_array($result2)) {
	calculatePointTotalDB($row2['ID']);
}
?>
