<?php session_start();
include("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-uc.php");
include("assets/includes/constants.php");

$eventID = $_GET['ID'];
$SQL = "SELECT * FROM Event WHERE ID='" . $eventID . "'";
$result = mysql_query($SQL);
while ($row = mysql_fetch_array($result)) {
    $filename = "CVN_" . $row['Name'] . "_Export_" . date("m/d/Y") . ".xls";
    $contents = "";//"CVN: ".$row['Name']." Ushers Attended Record \n ";
    $contents .= "Last Name\tFirst Name\tE-mail\tAttendance\t" . "Dress Code\t";//Points\n";
    $contents .= "\n";
}


//$SQL = "SELECT * FROM Attendance A, User U WHERE A.EventID='".$eventID."' AND A.UserID=U.ID AND (A.RequestStatus='Present' OR A.RequestStatus='Cut' OR A.RequestStatus='No-Show')";
$SQL = "SELECT * FROM Attendance A, User U WHERE A.EventID='" . $eventID . "' AND A.UserID=U.ID AND (A.RequestStatus='Present' OR A.RequestStatus='Ushering') ORDER BY U.LastName ASC";
$result = mysql_query($SQL);
while ($row = mysql_fetch_array($result)) {
    $contents .= $row['LastName'] . "\t" . $row['FirstName'] . "\t" . $row['Email'] . "\t" . $row['RequestStatus'] . "\t";//. calculatePointTotal($row["ID"]);
    $activity = calculateActivity($row['UserID']);
    $contents .= $activity['Dress-Violation'];
    $contents .= "\n";
}

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename=' . $filename);
echo $contents;
?>