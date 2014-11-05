<?php session_start();
include("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-uc.php");
include("assets/includes/constants.php");

$eventID = $_GET['ID'];
$SQL = "SELECT * FROM Event WHERE ID='" . $eventID . "'";
$result = mysql_query($SQL);
while ($row = mysql_fetch_array($result)) {
    $filename = "CVN__Export_" . date("m/d/Y") . ".xls";
    $contents = "CVN: " . $row['Name'] . " Usher List \n \n ";
    $contents .= "Last Name \t First Name \t E-mail \t Points \n\n";
}

$SQL = "SELECT * FROM Attendance A, User U WHERE A.EventID='" . $eventID . "' AND A.UserID=U.ID AND A.RequestStatus='Ushering'";
$result = mysql_query($SQL);


while ($row = mysql_fetch_array($result)) {


    $contents .= $row['LastName'] . " \t" . $row['FirstName'] . " \t" . $row['Email'] . "\t " . calculatePointTotal($row["ID"]) . "\n";
}

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename=' . $filename);
echo $contents;
?>