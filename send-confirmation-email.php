<?php 
session_start();
include("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-admin.php");
include("assets/includes/constants.php");

$eventID = $_GET['ID'];

$SQL = "SELECT * FROM Attendance A, User U WHERE A.EventID='".$eventID."' AND A.RequestStatus='Ushering' AND U.ID=A.UserID";
//echo $SQL;
$result = mysql_query($SQL);
while($row = mysql_fetch_array($result)) {
	//echo "sendEmail - '".$row['ID']."', '".$eventID."', confirmation-email <br>";
	sendEmail($row['ID'], $eventID, 'confirmation-email');
}

$query = "SELECT * FROM User WHERE AcctType<>'USHER'";
$result = mysql_query($query);
while($row = mysql_fetch_array($result)) {
	sendEmail($row['ID'], $eventID, 'uc-email');
}

$_SESSION['success'] = "The confirmation emails have been successfully sent to all confirmed ushers.";
header("Location: confirmation-email.php");
?>