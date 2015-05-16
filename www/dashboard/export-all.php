<?php session_start();
include("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-uc.php");
include("assets/includes/constants.php");



$filename ="CVN_Ushers_Export_".date("m/d/Y").".xls";
$contents = "CVN Ushers \n ";
$contents .= "Last Name \t First Name \t Email \t PointTotal \t Last Login \n \n ";
$contents .= "If login is 31-Dec-69 that means they have never logged in. \n \n";

$SQL = "SELECT * FROM User ORDER BY LastName ASC";
$result = mysql_query($SQL);
while($row = mysql_fetch_array($result)) {
	
	$contents .= $row['LastName']." \t".$row['FirstName']." \t".$row['Email']." \t".calculatePointTotal($row['ID'])." \t" . date("F j, Y", strtotime($row["LastLogin"])) . "\n"; 	
}

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $contents;
?>