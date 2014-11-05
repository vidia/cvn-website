<?php session_start();
include("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-uc.php");
include("assets/includes/constants.php");


function countShows($UID, $num_ushered, $num_meetings)
{


    $SQL = "SELECT * FROM User WHERE ID='" . $UID . "'";
    $result = mysql_query($SQL);
    $ushered = 0;
    $meetings = 0;
    $SQL = "SELECT * FROM Attendance A, Event E JOIN Season S ON E.SeasonID=S.SeasonID WHERE A.UserID='" . $UID . "' AND E.ID=A.EventID AND E.Archive<>1 AND S.Current = 1 ORDER BY E.CallTime ASC";
    $sqlYears = "SELECT YearsInvolved FROM User WHERE ID='" . $UID . "';";
    $result2 = mysql_query($sqlYears);
    $row2 = mysql_fetch_array($result2);
    $years = $row2["YearsInvolved"];


    $result = mysql_query($SQL);
    while ($row = mysql_fetch_array($result)) {

        if ($row['Type'] == 'Meeting' && $row['RequestStatus'] == 'Present') {
            $meetings++;
        } else {
            if ($row['RequestStatus'] == 'Present') {
                $ushered++;
            }
        } // end if

    } // end while

    if ($num_ushered == 'true') {
        return $ushered;
    } elseif ($num_meetings == 'true') {
        return $meetings;
    }
} // end function

$filename = "CVN_Ushers_Export_" . date("m/d/Y") . ".xls";
$contents = "CVN Ushers \n ";
$contents .= "Last Name, First Name \t Email \t Points \t Meetings  \t  Shows \n \n ";

$SQL = "SELECT * FROM User ORDER BY LastName ASC";
$result = mysql_query($SQL);
while ($row = mysql_fetch_array($result)) {

    $contents .= $row['LastName'] . ", " . $row['FirstName'] . " \t" . $row['Email'] . " \t" . calculatePointTotal($row['ID']) . " \t" . countShows($row['ID'], 'false', 'true') . "\t" . countShows($row['ID'], true, false) . " \n";
}

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename=' . $filename);
echo $contents;
?>