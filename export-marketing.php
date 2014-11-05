<?php session_start();
include("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-uc.php");

$filename = "CVN_Ushers_Marketing_Export_" . date("m/d/Y") . ".xls";
$contents = "CVN Ushers Interested In Marketing \n \n ";

$SQL = "SELECT * FROM User WHERE Marketing<>'' ORDER BY LastName ASC";
$result = mysql_query($SQL);
while ($row = mysql_fetch_array($result)) {
    $contents .= $row['LastName'] . " \t" . $row['FirstName'] . " \t" . $row['Email'] . " \n";
}

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename=' . $filename);
echo $contents;
?>