<?php session_start();
include("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-uc.php");

$SQL = "SELECT * FROM Event JOIN Season ON Event.SeasonID=Season.SeasonID WHERE Season.Current=1";
$result = mysql_query($SQL);
$filename = "CVN_AllEventAttendance_Export_" . date("m/d/Y") . ".xls";
$contents = "Last Name \t First Name \t E-mail \t Status";
while ($row = mysql_fetch_array($result)) {


    $contents .= "\n////////////////////////////////\n" . $row['Name'] . "\n////////////////////////////////\n";
    $SQL2 = "SELECT * FROM Attendance A, User U WHERE A.EventID='" . $row["ID"] . "' AND A.UserID=U.ID AND (A.RequestStatus='Present' OR A.RequestStatus='Cut' OR A.RequestStatus='No-Show') ORDER BY U.LastName ASC";
    $result2 = mysql_query($SQL2);
    while ($row2 = mysql_fetch_array($result2)) {
        $contents .= $row2['LastName'] . " \t" . $row2['FirstName'] . " \t" . $row2['Email'] . " \t" . $row2['RequestStatus'] . " \n";
    }
}

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename=' . $filename);
echo $contents;

?>
