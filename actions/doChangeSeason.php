<?php session_start();
include_once("../assets/includes/db.php");
include_once("../assets/includes/constants.php");
include("../assets/includes/verify-admin.php");

$seasonID = $_POST['season'];

$SQL = "SELECT * FROM Season WHERE Current=1;";
$result = mysql_query($SQL);
$row = mysql_fetch_array($result);

$SQL3 = "UPDATE Season SET Current=0 WHERE SeasonID=" . $row["SeasonID"] .";";
mysql_query($SQL3);

$SQL2 = "UPDATE Season SET Current=1 WHERE SeasonID=" . $seasonID . ";";
mysql_query($SQL2);

// iterate through every user and update point totals
$sql = "SELECT * FROM User";
$results = mysql_query($sql);
while($user = mysql_fetch_array($results)) {
   calculatePointTotalDB($user["ID"]);
}



$_SESSION['success'] = "The season has successfully been updated.";
header("Location: /event-admin.php");
?>