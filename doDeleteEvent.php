<?php session_start();
include_once("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-admin.php");

$eventid = $_GET['ID'];

$SQL = "DELETE FROM Event WHERE ID='" . $eventid . "' LIMIT 1";
mysql_query($SQL);

$SQL = "DELETE FROM Attendance WHERE EventID='" . $eventid . "'";
mysql_query($SQL);

$_SESSION['success'] = "You have successfully deleted the event.";
header("Location: event-admin.php");
?>