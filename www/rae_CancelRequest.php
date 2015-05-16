<?php session_start();
$hostname='mydb.ics.purdue.edu';
$username='cvn';
$password='stag3d00r';
$dbname='cvn';
mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);
include("assets/includes/verify.php");
include("assets/includes/rae_constants.php");

ini_set('display_errors', 1);
error_reporting('E_ALL');


$eventid = $_GET['id'];

$SQL = "SELECT CallTime, UC FROM Event WHERE ID='".$eventid."'";
$result = mysql_query($SQL);
while($row = mysql_fetch_array($result)){
	$callTime = $row['CallTime'];
	$UC = $row['UC'];
	echo $callTime."<br>";
}


$now = date("Y-m-d H:i:s");
echo $now."<br>";

$fiveDayLimit = date('Y-m-d H:i:s', strtotime('7 days'));
echo $fiveDayLimit."<br>";

$twoDayLimit = date('Y-m-d H:i:s', strtotime('2 days'));
echo $twoDayLimit."<br>";


/*
	UC'S CAN NOW REGISTER FOR SHOWS
	THEY CAN CANCEL UP TO 24HRS BEFORE THE SHOW
*/

	//i'm tired. 


/*
	END UC CHECK
*/



if($callTime < $fiveDayLimit && $callTime > $twoDayLimit) {
	echo "within 5 days but greater than 2"."<br>";
	$SQL = "DELETE FROM Attendance WHERE UserID='".$_SESSION['UID']."' AND EventID='".$eventid."'";
//	mysql_query($SQL);
	echo $SQL."<br>";
	
//insert find anther usher and email them
/*	$query = "SELECT UserID FROM Attendance WHERE RequestStatus='Cut' AND EventID='".$eventid."' LIMIT 1";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if($num_rows > 0) {
		while($row = mysql_fetch_array($result)){
			$ID = $row['UserID'];
		}
		$sql_u = "UPDATE Attendance SET RequestStatus='Ushering' WHERE UserID='".$ID."' AND EventID='".$eventid."'";
		echo $sql_u."<br>";
		mysql_query($sql_u);
		sendEmail($ID, $eventid, 'replacement-email');
	} else {
		$query = "SELECT UserID FROM Attendance WHERE RequestStatus='Requested' AND EventID='".$eventid."' LIMIT 1";
		$result = mysql_query($query);
		$num_rows = mysql_num_rows($result);
		if($num_rows > 0) {
			while($row = mysql_fetch_array($result)){
				$ID = $row['UserID'];
			}
			$sql_u = "UPDATE Attendance SET RequestStatus='Ushering' WHERE UserID='".$ID."' AND EventID='".$eventid."'";
			echo $sql_u."<br>";
			mysql_query($sql_u);
			sendEmail($ID, $eventid, 'replacement-email');
		} else {
			//Send email to user with ID 17 (cvn2 account)
			sendEmail(17, $eventid, 'no-replacement');
		}
	}*/
	pullAttendance(1,$eventid,1,0);
	
} elseif($callTime < $twoDayLimit) {
	echo "within 2 days"."<br>";
	$SQL = "Update Attendance SET RequestStatus='Cancelled' WHERE UserID='".$_SESSION['UID']."' AND EventID='".$eventid."'";
	echo $SQL."<br>";
	pullAttendance(1,$eventid,1,1);

	//Notify UC and Kate that there was a late cut
	$query = "SELECT ID FROM User WHERE Username='".$UC."'";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)){
		$ID = $row['ID'];
	}
/*	//send email to event UC
	sendEmail($ID, $eventid, 'late-cut');
	//Send email to user with ID 17 (cvn2 account)
	sendEmail(17, $eventid, 'late-cut');	


	mysql_query($SQL);
	*/

}  else {
	echo "early still"."<br>";
	$SQL = "DELETE FROM Attendance WHERE UserID='".$_SESSION['UID']."' AND EventID='".$eventid."'";
	//mysql_query($SQL);
	echo $SQL."<br>";
}

/*$_SESSION['request-message'] = "You have successfully cancelled your request.";
header("Location: my-events.php");*/
?>