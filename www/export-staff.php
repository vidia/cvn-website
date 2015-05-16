<?php session_start();
$hostname='mydb.ics.purdue.edu';
$username='cvn';
$password='stag3d00r';
$dbname='cvn';
mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);
include("assets/includes/verify.php");
include("assets/includes/verify-admin.php");




$filename ="CVN_Ushers_Export_".date("m/d/Y").".xls";
$contents = "CVN Ushers \n ";
$contents .= "Last Name \t First Name \t Email \t PointTotal \t Last Login \t Account Type\n \n ";
$contents .= "Last Name\tFirst Name";


$SQLevent = "SELECT * FROM Event JOIN Season ON Event.SeasonID=Season.SeasonID WHERE Season.Current=1 ORDER BY Event.CallTime ASC";
$resultEvent = mysql_query($SQLevent);
$resultEvent2 = mysql_query($SQLevent);

while($event2 = mysql_fetch_array($resultEvent)) {
	
	$contents .= "\t" . $event2["Name"];

}
	
while($event = mysql_fetch_array($resultEvent2)) {
	
		$SQL = "SELECT * FROM User WHERE AcctType='ADMIN' OR AcctType='UC' ORDER BY LastName ASC";
		$result = mysql_query($SQL);
		while($row = mysql_fetch_array($result)) {
			$contents .= "\n" . $row['LastName']." \t".$row['FirstName']." \t";
			
			$sqlAttendance = "SELECT * FROM Attendance WHERE UserID=" . $row["ID"] . " AND EventID =" . $event["ID"];
			$resultAttendance = mysql_query($sqlAttendance);
			$attendance = mysql_fetch_array($resultAttendance);
			
			if($attendance["RequestStatus"] == "Present") {
				$contents .= "1\t";
			}

			$contents .= "\n";
		}
}


header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $contents;
?>