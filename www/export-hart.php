<?php session_start();
$hostname='mydb.ics.purdue.edu';
$username='cvn';
$password='stag3d00r';
$dbname='cvn';
mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);
include("assets/includes/verify.php");
include("assets/includes/verify-uc.php");

$SQL = "SELECT * FROM Event JOIN Season ON Event.SeasonID=Season.SeasonID WHERE Season.Current=1 AND Event.Name LIKE '%hart%'";
$result = mysql_query($SQL);
$filename ="CVN_HartAttendance_Export_".date("m/d/Y").".xls";
$contents = "Last Name \t First Name \t E-mail \t Status";
while($row = mysql_fetch_array($result)) {


	$contents .= "\n////////////////////////////////\n".$row['Name']."\n////////////////////////////////\n";
//	$SQL2 = "SELECT * FROM Attendance A, User U WHERE A.EventID='".$row["ID"]."' AND A.UserID=U.ID AND (A.RequestStatus='Present' OR A.RequestStatus='Cut' OR A.RequestStatus='No-Show') ORDER BY U.LastName ASC";
	$SQL2 = "SELECT * FROM Attendance A, User U WHERE A.EventID='".$row["ID"]."' AND A.UserID=U.ID ORDER BY U.LastName ASC";
	$result2 = mysql_query($SQL2);
	while($row2 = mysql_fetch_array($result2)) {
		$contents .= $row2['LastName']." \t".$row2['FirstName']." \t".$row2['Email']." \t".$row2['RequestStatus']." \n"; 	
	}
}

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $contents;

?>
