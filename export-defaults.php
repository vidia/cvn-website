<?php session_start();
include("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-admin.php");
include("assets/includes/constants.php");


$filename = "CVN_UC_Defaults_Export_" . date("m/d/Y") . ".xls";
$contents = "CVN UC Defaults List \n ";
$contents .= "UserName \t ID \t First Name \t Last Name \t Time of Issue \t Reason \n \n ";

$SQL = "SELECT * FROM User WHERE AcctType = 'UC' ORDER BY LastName ASC";
$result = mysql_query($SQL);
while ($row = mysql_fetch_array($result)) {
    $contents .= $row['Email'] . " \t" . $row['ID'] . " \t" . $row['FirstName'] . " \t" . $row['LastName'] . " \n";


    $sqlSeason = "SELECT SeasonID FROM Season WHERE Current=1;";
    $resultSeason = mysql_query($sqlSeason);
    $rowSeason = mysql_fetch_array($resultSeason);

    $SQL2 = "SELECT * FROM Defaults WHERE UserID=" . $row["ID"] . " AND Archived=0 AND SeasonID=" . $rowSeason["SeasonID"];
    $result2 = mysql_query($SQL2);
    $resultCounter = mysql_num_rows($result2);

    if ($resultCounter > 0) {
        while ($row2 = mysql_fetch_array($result2)) {
            $contents .= " \t\t\t\t" . $row2["DateReported"] . " \t" . $row2["Reason"] . "\n";
        }

    } else {
        $contents .= "\t\t\t\t No defaults.\n";
    }
}

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename=' . $filename);
echo $contents;
?>