<?php session_start();
include("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-uc.php");
include("assets/includes/constants.php");

function calculateLastRequest($UID)
{


    $SQL = "SELECT * FROM User WHERE ID='" . $UID . "'";
    $result = mysql_query($SQL);
    $ushered = 0;
    $cut = 0;
    $skipped = 0;
    $cancelled = 0;
    $meetings = 0;
    //$SQL = "SELECT MAX(RequestDate) AS LastRequest FROM (SELECT * FROM Attendance A, Event E JOIN Season S ON E.SeasonID=S.SeasonID WHERE A.UserID='". $UID ."' AND E.ID=A.EventID AND E.Archive<>1 AND S.Current = 1 ORDER BY E.CallTime ASC) AS LastRequestTable";
    $SQL = "SELECT MAX(RequestDate) AS LastRequest FROM Attendance A, Event E JOIN Season S ON E.SeasonID=S.SeasonID WHERE A.UserID='" . $UID . "' AND E.ID=A.EventID ORDER BY E.CallTime ASC";
    /*	$sqlYears = "SELECT YearsInvolved FROM User WHERE ID='" . $UID . "';";
        $result2 = mysql_query($sqlYears);
        $row2 = mysql_fetch_array($result2);
        $years = $row2["YearsInvolved"]; */


    $result = mysql_query($SQL);
    $row = mysql_fetch_array($result);
    $lasttime = $row['LastRequest'];

    return $lasttime;

} // end function


$filename = "CVN_Usher_Activity_" . date("m/d/Y") . ".xls";
$contents = "CVN Ushers \n ";
$contents .= "Last Name\t First Name \t Email \t PointTotal \t Activity\t LastActivity (after 08/2011) \t Last Login \t AccountCreated \t GradDate \n \n ";

$SQL = "SELECT * FROM User ORDER BY LastName ASC";
$result = mysql_query($SQL);
while ($row = mysql_fetch_array($result)) {

    $contents .= $row['LastName'] . "\t" . $row['FirstName'] . " \t" . $row['Email'] . "\t" . calculatePointTotal($row['ID']) . "\t" . array_sum(calculateActivity($row['ID'])) . "\t" . date("F j, Y", strtotime(calculateLastRequest($row['ID']))) . " \t" . date("F j, Y", strtotime($row["LastLogin"])) . " \t" . date("F j, Y", strtotime($row["Created"])) . "\t" . $row['GraduationDate'] . " \n";
}

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename=' . $filename);
echo $contents;
?>